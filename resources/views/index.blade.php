<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Tasks</h1>
    <ul>
        @foreach ($tasks as $task)
        <li>
            <label><input type="checkbox" name="completed" id="">{{ $task->title }}</label>
        </li>
        @endforeach
    </ul>
</body>

</html>