@extends('layouts.main')

@section('title', $lesson['title'])

@section('content')
<div class="container">
    <h1 class="my-4">{{ $lesson['title'] }}</h1>
    <img src="{{ asset('images/lesson-banner.png') }}" class="img-fluid mb-4" alt="Lesson Banner">
    <p>{{ $lesson['content'] }}</p>
    <div class="mt-4">
        <a href="{{ route('microlearning.quiz') }}" class="btn btn-primary">Take Quiz</a>
    </div>
</div>
@endsection
