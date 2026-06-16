@extends('layouts.app')

@section('title', '📝 Change Log')

@section('content')
<div class="container py-5">
    <a href="https://r567tw.cc/blog/架站日記" class="position-fixed end-0 top-0 m-4 btn btn-secondary" style="z-index: 1050;">架站筆記</a>
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
