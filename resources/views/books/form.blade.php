@extends('layouts.app')

@section('title', isset($book) ? 'Update Book' : 'Create Book')
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
    <form action="{{ isset($book) ? route('books.update', $book) : route('books.store') }}" method="post">
        @csrf
        @isset($book)
            @method('PUT')
        @endisset
        <div class="form-group mb-3">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ $book->title ?? old('title') }}" required>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" class="form-control"
                    value="{{ $book->author ?? old('author') }}" required>
            </div>
        </div>
        @isset($book)
            <a href="{{ route('books.show', $book) }}" class="btn btn-secondary">Back</a>
        @endisset
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to List</a>

        @isset($book)
            <button type="submit" class="btn btn-primary">Update</button>
        @else
            <button type="submit" class="btn btn-primary">Create</button>
        @endisset
    </form>
@endsection
