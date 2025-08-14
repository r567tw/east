@extends('layouts.event')
@section('title', $event->name)

@section('styles')
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        main {
            flex: 1;
        }
        .hero {
            background: url('/images/event-background.jpg') center/cover no-repeat;
            color: white;
            padding: 100px 0;
            text-shadow: 0px 2px 4px rgba(0,0,0,0.6);
        }
        .countdown {
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <!-- Hero 區 -->
    <section class="hero text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">{{ $event->name }}</h1>
            {{-- <p class="lead">2025/09/10 高雄國際會議中心</p> --}}
            <div class="countdown" id="countdown">倒數計時載入中...</div>
        </div>
    </section>

    <!-- 活動介紹 -->
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4">活動介紹</h2>
            <p>{{ $event->description }}</p>
        </div>
    </section>

    <!-- 活動時間 -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="mb-4">活動時間</h2>
            <p><strong>開始時間：</strong> <label id="event-start-time">{{ \Carbon\Carbon::parse($event->start_time)->format("Y-m-d H:i") }}</label></p>
            <p><strong>結束時間：</strong> <label id="event-end-time">{{ \Carbon\Carbon::parse($event->end_time)->format("Y-m-d H:i") }}</label></p>
        </div>
    </section>

    <!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
    <p class="mb-0">© {{ \Carbon\Carbon::now()->format("Y") }} {{ $event->name }}. All rights reserved.</p>
</footer>


@endsection

@section('scripts')
    <script>
    // 倒數計時
    const countdownElement = document.getElementById("countdown");
    const eventDate = new Date(document.getElementById("event-start-time").innerText).getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = eventDate - now;

        if (distance < 0) {
            countdownElement.innerHTML = "活動已開始！";
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        countdownElement.innerHTML = `${days} 天 ${hours} 小時 ${minutes} 分 ${seconds} 秒`;
    }

    setInterval(updateCountdown, 1000);
</script>
@endsection
