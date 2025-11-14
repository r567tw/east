<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BMI Calculator</title>

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- blade-formatter-disable --}}
   <style type="text/tailwindcss">
     .btn {
       @apply rounded-md px-2 py-1 text-center font-medium text-slate-700 shadow-sm ring-1 ring-slate-700/10 hover:bg-slate-50
     }

     label {
       @apply block uppercase text-slate-700 mb-2
     }

     input,
     textarea {
       @apply shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none
     }

     .error {
       @apply text-red-500 text-sm
     }
   </style>
   {{-- blade-formatter-enable --}}

    @livewireStyles
</head>

<body class="container mx-auto mt-10 mb-10 max-w-lg bg-gray-100 min-h-screen">
    @livewireScripts
    <div class="py-8">
        <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">BMI 健康計算器</h1>
        <div class="mb-4 text-center text-sm text-gray-600">
            <p>💾 您的身高和體重會自動儲存在瀏覽器中</p>
        </div>
        @livewire('bmi-calculator')

        <div class="mt-8 text-center text-xs text-gray-500">
            <p>💡 <strong>隱私保護：</strong>您的個人數據僅儲存在您的瀏覽器中</p>
            <p>下次訪問時會自動載入您之前輸入的數值</p>
        </div>
    </div>
</body>

</html>
