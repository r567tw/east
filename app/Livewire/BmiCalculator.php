<?php

namespace App\Livewire;

use App\Models\Option;
use Livewire\Component;

class BmiCalculator extends Component
{
    public $weight;
    public $height;
    public $bmi = 0;

    public function mount()
    {
        // 組件初始化時，這些值將由前端 JavaScript 設定
    }

    public function render()
    {
        return view('livewire.bmi-calculator');
    }

    public function calculateBmi()
    {
        if (is_numeric($this->weight) && is_numeric($this->height) && $this->height > 0) {
            $height = $this->height / 100; // Convert cm to meters
            $bmi = $this->weight / ($height * $height);
            $this->bmi = round($bmi, 2);
        } else {
            $this->bmi = 0;
        }
    }

    // 監聽屬性變化，即時計算 BMI 並儲存到 localStorage
    public function updatedWeight($value)
    {
        $this->calculateBmi();
        // 觸發前端事件來儲存數據
        $this->dispatch('save-to-storage', key: 'bmi_weight', value: $value);
    }

    public function updatedHeight($value)
    {
        $this->calculateBmi();
        // 觸發前端事件來儲存數據
        $this->dispatch('save-to-storage', key: 'bmi_height', value: $value);
    }

    // 從前端接收儲存的數據
    public function loadFromStorage($weight, $height)
    {
        if ($weight) {
            $this->weight = $weight;
        }
        if ($height) {
            $this->height = $height;
        }
        $this->calculateBmi();
    }

    // 清除儲存的數據
    public function clearStorage()
    {
        $this->weight = null;
        $this->height = null;
        $this->bmi = 0;
        $this->dispatch('clear-storage');
    }

    // 取得 BMI 分類
    public function getBmiCategory()
    {
        if ($this->bmi == 0) return '';

        if ($this->bmi < 18.5) {
            return '體重過輕';
        } elseif ($this->bmi < 24) {
            return '正常範圍';
        } elseif ($this->bmi < 27) {
            return '過重';
        } elseif ($this->bmi < 30) {
            return '輕度肥胖';
        } elseif ($this->bmi < 35) {
            return '中度肥胖';
        } else {
            return '重度肥胖';
        }
    }

    // 取得 BMI 分類顏色
    public function getBmiColor()
    {
        if ($this->bmi == 0) return 'text-gray-500';

        if ($this->bmi < 18.5) {
            return 'text-blue-500';
        } elseif ($this->bmi < 24) {
            return 'text-green-500';
        } elseif ($this->bmi < 27) {
            return 'text-yellow-500';
        } elseif ($this->bmi < 30) {
            return 'text-orange-500';
        } elseif ($this->bmi < 35) {
            return 'text-red-500';
        } else {
            return 'text-red-700';
        }
    }
}
