<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        #countdown {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        #countdown div {
            font-size: 1.5em;
        }

        #countdown span {
            font-weight: bold;
            font-size: 2em;
            color: #ff6347;
        }
    </style>
</head>
<body>
    <h1 style="text-align:center">Hi , Developers</h1>
    <div id="countdown">
      <div><span id="days">0</span>天</div>
      <div><span id="hours">0</span>時</div>
      <div><span id="minutes">0</span>分</div>
      <div><span id="seconds">0</span>秒</div>
    </div>
    <script>
        // 設定年底的日期
        const endOfYear = new Date(new Date().getFullYear(), 11, 31, 23, 59, 59).getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const timeRemaining = endOfYear - now;

            // 計算天數、時、分、秒
            const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            // 更新 HTML
            document.getElementById("days").textContent = days;
            document.getElementById("hours").textContent = hours;
            document.getElementById("minutes").textContent = minutes;
            document.getElementById("seconds").textContent = seconds;
        }

        // 每秒更新倒數
        setInterval(updateCountdown, 1000);

    </script>
</body>
</html>