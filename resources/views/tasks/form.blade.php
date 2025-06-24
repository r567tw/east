@extends('layouts.app')

@section('title', isset($task) ? 'Update Task' : 'Create Task')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ isset($task) ? route('tasks.update', $task) : route('tasks.store') }}" method="post">
        @csrf
        @isset($task)
            @method('PUT')
        @endisset
        <div class="form-group mb-3">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ $task->title ?? old('title') }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="form-control"
                    value="{{ $task->description ?? old('description') }}" required>
            </div>
            <div class="form-group">
                <label for="long_description">Long Description</label>
                <textarea class="form-control" name="long_description" id="long_description" cols="30" rows="10">{{ $task->long_description ?? old('long_description') }}</textarea>
            </div>
        </div>
        @isset($task)
            <a href="{{ route('tasks.show', $task) }}" class="btn btn-secondary">Back</a>
        @endisset
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to List</a>

        @isset($task)
            <button type="submit" class="btn btn-primary">Update</button>
        @else
            <button type="submit" class="btn btn-primary">Create</button>
        @endisset
    </form>
@endsection
