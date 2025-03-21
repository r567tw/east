@extends('layouts.app')

@section('title', 'Book')
@section('content')
    <h1>{{ $book->title }}</h1>
    <p>{{ $book->author }}</p>
    <p>{{ $book->created_at->diffForHumans() }}</p>
    <a href="{{ route('books.index') }}" class="btn btn-secondary">Back</a>
    <a href="{{ route('books.edit', $book) }}" class="btn btn-primary">Edit Task</a>
    <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Book</button>
    </form>
@endsection
