@extends('layouts.app')

@section('title', 'Book List')
@section('content')
    <a href="{{ route('books.create') }}" class="btn btn-default">Create Book</a>
    <ul class="list-unstyled">
        @foreach ($books as $book)
            <li class="mb-2">
                <label>
                    <a href="{{ route('books.show', $book) }}">
                        {{ $book->title }}
                    </a>
                </label>
            </li>
        @endforeach
    </ul>


    {{ $books->links('pagination::bootstrap-4') }}
@endsection
