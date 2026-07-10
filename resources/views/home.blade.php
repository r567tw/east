@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
          <h2>{{ Carbon\Carbon::now()->format('Y-m-d H:i') }}</h2>
          <p>距離今年結束<span id="days" style="font-weight: bold;font-size: 4em;color: #ff6347;">0</span>天</p>
          <div class="mt-4 d-grid gap-2 d-md-flex justify-content-md-start">
            <a class="btn btn-primary btn-lg" href="{{ route("present") }}" role="button">Present »</a>
            {{-- <a class="btn btn-secondary btn-lg" href="{{ route("changelog") }}" role="button">changelog »</a> --}}
            <a href="https://r567tw.cc/blog/架站日記" class="position-fixed end-0 top-0 m-4 btn btn-secondary" style="z-index: 1050;">架站筆記</a>
          </div>
            <div class="mt-5">
                    <h3>Change Log</h3>
                    <div class="overflow-y-scroll mt-5" style="max-height: 150px;">
                    @foreach ($logs as $log)
                        <div class="mb-5">
                            <h4 class="text-primary mb-2">{{ $log['date'] }}</h4>
                            <ul class="list-disc ps-5 text-gray-800">
                                @foreach ($log['changes'] as $change)
                                    <li>{{ $change }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                    </div>
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

