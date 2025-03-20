@extends('layouts.app')

@section('title', 'Task')
@section('content')
    <h1>{{ $task->title }}</h1>
    <p>{{ $task->description }}</p>
    <p>{{ $task->long_description }}</p>
    <p>{{ $task->created_at->diffForHumans() }}</p>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">Edit Task</a>
    <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="d-inline">
        @csrf
        @method('PATCH')
        @if ($task->completed)
            <button type="submit" class="btn btn-info">Not yet</button>
        @else
            <button type="submit" class="btn btn-info">Mark Completed</button>
        @endif
    </form>
    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Task</button>
    </form>
@endsection
