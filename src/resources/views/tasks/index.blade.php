@extends('layouts.app')

@section('title', 'Task List')
@section('content')
    <a href="{{ route('tasks.create') }}" class="btn btn-default">Create Task</a>
    <ul class="list-unstyled">
        @foreach ($tasks as $task)
            <li class="mb-2">
                <label>
                    <form action="{{ route('tasks.toggle', $task) }}" method="post" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="checkbox" name="completed" id="" class="form-group mr-2"
                            onclick="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                    </form>
                    <a href="{{ route('tasks.show', $task) }}">
                        @if ($task->completed)
                            <del>{{ $task->title }}</del>
                        @else
                            {{ $task->title }}
                        @endif
                    </a>
                </label>
            </li>
        @endforeach
    </ul>


    {{ $tasks->links('pagination::bootstrap-4') }}
@endsection
