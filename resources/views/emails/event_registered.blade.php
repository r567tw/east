<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>活動參加通知</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>活動參加通知</h1>
    </div>

    <div class="content">
        <p>Hi {{ $attendee->name }},</p>
        <p>你已成功報名活動：<strong>{{ $attendee->event->name }}</strong></p>
        <p>活動期間：{{ $start }} ~ {{ $end }}<br>

        <a href="https://r567tw.github.io/event-app/#/events/{{ $attendee->event_id }}" class="button">查看活動詳情</a>

        <p>謝謝你參加我們的活動！</p>
    </div>
</body>
</html>
