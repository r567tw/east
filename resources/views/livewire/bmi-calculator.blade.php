<div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md"
     x-data="bmiStorage()"
     x-init="loadFromStorage()"
     @save-to-storage.window="saveToStorage($event.detail.key, $event.detail.value)"
     @clear-storage.window="clearStorage()">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">BMI 計算器</h2>
        <button @click="clearData()"
                class="text-sm px-3 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200 transition-colors"
                title="清除記憶的數據">
            🗑️ 清除
        </button>
    </div>

    <div class="mb-4">
        <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
            體重 (公斤):
            <span class="text-xs text-green-600" x-show="hasStoredWeight">📱 已記住</span>
        </label>
        <input type="number"
               id="weight"
               wire:model.live.debounce.300ms="weight"
               step="0.1"
               min="1"
               max="500"
               placeholder="請輸入體重"
               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>

    <div class="mb-6">
        <label for="height" class="block text-sm font-medium text-gray-700 mb-2">
            身高 (公分):
            <span class="text-xs text-green-600" x-show="hasStoredHeight">📱 已記住</span>
        </label>
        <input type="number"
               id="height"
               wire:model.live.debounce.300ms="height"
               step="1"
               min="50"
               max="250"
               placeholder="請輸入身高"
               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>

    @if($bmi > 0)
        <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between mb-2">
                <span class="text-lg font-semibold text-gray-700">您的 BMI:</span>
                <span class="text-2xl font-bold {{ $this->getBmiColor() }}">{{ $bmi }}</span>
            </div>

            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">分類:</span>
                <span class="text-lg font-medium {{ $this->getBmiColor() }}">{{ $this->getBmiCategory() }}</span>
            </div>
        </div>

        <div class="mt-4 text-xs text-gray-500">
            <p><strong>BMI 分類標準:</strong></p>
            <ul class="mt-1 space-y-1">
                <li class="text-blue-500">• 體重過輕: < 18.5</li>
                <li class="text-green-500">• 正常範圍: 18.5 - 23.9</li>
                <li class="text-yellow-500">• 過重: 24.0 - 26.9</li>
                <li class="text-orange-500">• 輕度肥胖: 27.0 - 29.9</li>
                <li class="text-red-500">• 中度肥胖: 30.0 - 34.9</li>
                <li class="text-red-700">• 重度肥胖: ≥ 35.0</li>
            </ul>
        </div>
    @elseif($weight || $height)
        <div class="bg-yellow-50 rounded-lg p-4 border-l-4 border-yellow-400">
            <p class="text-yellow-700">請輸入有效的體重和身高數值</p>
        </div>
    @else
        <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-400">
            <p class="text-blue-700">請輸入您的體重和身高，系統將即時計算 BMI</p>
            <p class="text-xs text-blue-600 mt-1">💡 您的數據會自動儲存在瀏覽器中</p>
        </div>
    @endif
</div>

<script>
// BMI Calculator Storage Management
document.addEventListener('DOMContentLoaded', function() {
    // 在頁面載入時自動從 localStorage 載入數據
    loadBmiDataFromStorage();

    // 監聽 Livewire 事件
    window.addEventListener('save-to-storage', function(event) {
        saveBmiDataToStorage(event.detail.key, event.detail.value);
    });

    window.addEventListener('clear-storage', function() {
        clearBmiDataFromStorage();
    });
});

function loadBmiDataFromStorage() {
    try {
        const storedWeight = localStorage.getItem('bmi_weight');
        const storedHeight = localStorage.getItem('bmi_height');

        if (storedWeight || storedHeight) {
            // 使用 Livewire 的 @this 來調用組件方法
            if (window.Livewire) {
                const component = window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'));
                if (component) {
                    component.call('loadFromStorage', storedWeight, storedHeight);
                    showBmiNotification('已載入您之前儲存的數據 📱');
                }
            }
        }
    } catch (error) {
        console.error('載入儲存數據時出錯:', error);
    }
}

function saveBmiDataToStorage(key, value) {
    try {
        if (value && value !== '') {
            localStorage.setItem(key, value);
        } else {
            localStorage.removeItem(key);
        }
    } catch (error) {
        console.error('儲存數據時出錯:', error);
    }
}

function clearBmiDataFromStorage() {
    try {
        localStorage.removeItem('bmi_weight');
        localStorage.removeItem('bmi_height');
        showBmiNotification('已清除儲存的數據 🗑️');
    } catch (error) {
        console.error('清除儲存數據時出錯:', error);
    }
}

function showBmiNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50 transition-opacity duration-300';
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 2000);
}

// Alpine.js 組件 (作為備用)
function bmiStorage() {
    return {
        hasStoredWeight: false,
        hasStoredHeight: false,

        init() {
            this.checkStoredData();
        },

        checkStoredData() {
            this.hasStoredWeight = !!localStorage.getItem('bmi_weight');
            this.hasStoredHeight = !!localStorage.getItem('bmi_height');
        },

        loadFromStorage() {
            loadBmiDataFromStorage();
            this.checkStoredData();
        },

        saveToStorage(key, value) {
            saveBmiDataToStorage(key, value);
            this.checkStoredData();
        },

        clearStorage() {
            clearBmiDataFromStorage();
            this.checkStoredData();
        },

        clearData() {
            if (confirm('確定要清除儲存的身高和體重數據嗎？')) {
                this.$wire.clearStorage();
            }
        }
    }
}
</script>
