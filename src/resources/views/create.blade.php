@extends('layouts.app')

@section('title', 'Create Task')
@section('content')
<h1>Create Task</h1>
<form action="{{ route('tasks.store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control">
        <label for="description">Description</label>
        <input type="text" name="description" id="description" class="form-control">
        <label for="long_description">Long Description</label>
        <input type="text" name="long_description" id="long_description" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>
@endsection
