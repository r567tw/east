<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>例行公事每週通知</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .content {
            margin: 20px;
        }
        ul {
            list-style-type: disc;
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <div class="content">
        <div style="background:#f5f5f5;border-radius:8px;padding:16px 24px 12px 24px;margin-bottom:24px;border-left:6px solid #4F8A8B;">
            <h2 style="margin:0;color:#4F8A8B;">本週例行公事提醒</h2>
            <p style="margin:8px 0 0 0;color:#333;font-size:16px;">請留意以下本週需完成的事項：</p>
        </div>
        <ul style="padding:0;">
            @foreach ($tasks as $task)
                <li style="margin-bottom:18px;padding-bottom:8px;border-bottom:1px solid #eee;">
                    <span style="font-weight:bold;color:#4F8A8B;font-size:15px;">{{ $task->getTargetDateForThisMonth()->format('Y-m-d') }}</span>
                    <span style="font-size:16px;margin-left:8px;">{{ $task->title }}</span>
                    <div style="color:#666;margin-left:24px;font-size:14px;">{{ $task->description }}</div>
                </li>
            @endforeach
        </ul>
        <div style="margin-top:32px;color:#888;font-size:13px;">
            <hr>
            <p>如有疑問或需協助，請隨時聯絡管理員。祝您本週順利！</p>
        </div>
    </div>
</body>
</html>
