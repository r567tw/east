@extends('layouts.app')

@section('title', '📝 Change Log')

@section('content')
<div class="container py-5">
    <a href="{{ route('home') }}" class="btn btn-primary mb-4"> Back to Home</a>
    @foreach ($logs as $log)
        <div class="mb-5">
            <h4 class="text-primary mb-2">{{ $log['date'] }}</h4>
            <ul class="list-disc ps-5 text-gray-800">
                @foreach ($log['changes'] as $change)
                    <li>{{ $change }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
@endsection
