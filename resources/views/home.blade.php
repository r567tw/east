@extends('layouts.app')

@section('content')
<body>
    <div class="jumbotron">
        <div class="container">
          <h1 class="display-3">Hi, Developers</h1>
          <h2>{{ Carbon\Carbon::now()->format('Y-m-d H:i') }}</h2>
          <p>距離今年結束<span id="days" style="font-weight: bold;font-size: 4em;color: #ff6347;">0</span>天</p>
          <div class="mt-4 d-grid gap-2 d-md-flex justify-content-md-start">
            <a class="btn btn-primary btn-lg" href="{{ route("present") }}" role="button">Present »</a>
            <a class="btn btn-info btn-lg" href="{{ route("production.swagger") }}" role="button" target="_blank">Production API »</a>
            <a class="btn btn-secondary btn-lg" href="{{ route("changelog") }}" role="button">changelog »</a>
          </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // 設定年底的日期 設定為當年的12月31日23:59:59
        const endOfYear = new Date(new Date().getFullYear(), 11, 31, 23, 59, 59).getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const timeRemaining = endOfYear - now;

            // 計算天數、時、分、秒
            const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
            //const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            //const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            //const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            // 更新 HTML
            document.getElementById("days").textContent = days;
            //document.getElementById("hours").textContent = hours;
            //document.getElementById("minutes").textContent = minutes;
            //document.getElementById("seconds").textContent = seconds;
        }

        // 每秒更新倒數
        updateCountdown();
        //setInterval(updateCountdown, 1000);
    </script>
@endsection

