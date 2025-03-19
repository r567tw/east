<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Tasks</title>
</head>

<body class="container">
    <h1>Tasks</h1>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <ul class="list-unstyled">
        @foreach ($tasks as $task)
            <li>
                <label>
                    <input type="checkbox" name="completed" id="" class="form-group mr-2">
                    {{ $task->title }}
                </label>
            </li>
        @endforeach
    </ul>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Task</a>
</body>

</html>
