@extends('layouts.main')

@section('title', 'Lessons')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Microlearning Lessons</h1>
    <div class="row g-4">
        @foreach($lessons as $lesson)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/lesson-thumbnail.png') }}" class="card-img-top" alt="Lesson Thumbnail">
                <div class="card-body">
                    <h5 class="card-title">{{ $lesson['title'] }}</h5>
                    <p class="card-text">{{ Str::limit($lesson['content'], 100) }}</p>
                    <a href="{{ route('microlearning.lesson', ['id' => $lesson['id']]) }}" class="btn btn-primary">Start Lesson</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
