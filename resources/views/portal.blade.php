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
                            <a href="{{ route('bmi') }}">BMI Calculator</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 col-md-8">
                <div class="card">
                    <div class="card-header">Bookmarks</div>

                    <div class="card-body">
                        <ul>
                            <li>
                                <a href="{{ route('home') }}">Projects</a>
                            </li>
                            <li>
                                <a href="https://r567tw.cc">Blog</a>
                            </li>
                            <li>
                                <a href="https://my.vultr.com/">Vultr</a>
                            </li>
                            <li>
                                <a href="https://free-for.dev/#/">Free for Developers</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
