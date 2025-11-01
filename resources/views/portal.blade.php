@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Portal Page</div>

                    <div class="card-body">
                        Welcome to the Portal Page!
                        <div>
                            <a href="{{ route('home') }}">Go to Home</a>
                            <a href="{{ route('books.index') }}">Book Reviews System</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
