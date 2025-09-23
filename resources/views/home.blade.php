<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EAST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="jumbotron">
        <div class="container">
          <h1 class="display-3">Hi, Developers</h1>
          <p>距離今年結束<span id="days" style="font-weight: bold;font-size: 4em;color: #ff6347;">0</span>天</p>
          <p>
            <a class="btn btn-primary btn-lg" href="{{ route("present") }}" role="button">Present »</a>
            <a class="btn btn-info btn-lg" href="{{ route("production.swagger") }}" role="button" target="_blank">Production API »</a>
          </p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ Carbon\Carbon::now()->format('Y-m-d H:i') }}</h2>
                <p> Week: {{ Carbon\Carbon::now()->weekOfYear }}/{{ Carbon\Carbon::now()->weekInYear }} ,剩下 {{ Carbon\Carbon::now()->weekInYear - Carbon\Carbon::now()->weekOfYear }} 週</p>
            </div>
        </div>
    </div>
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
</body>

</html>
