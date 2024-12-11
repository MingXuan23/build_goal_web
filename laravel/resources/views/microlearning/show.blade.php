@extends('microlearning.layouts.app')

@section('title', 'Microlearning - Content Details')

@section('content')
    <div class="container">
        <h1>{{ $content->name }}</h1>
        <img src="{{ asset($content->image) }}" alt="{{ $content->name }}" class="img-fluid mb-4">
        <p><strong>Type:</strong> {{ $content->content_type_name }}</p>
        <p>{{ $content->desc }}</p>
        <p><a href="{{ $content->link }}" target="_blank" rel="noopener noreferrer">{{ $content->link }}</a></p>

        <a href="/microlearning" class="btn btn-secondary">Back to Explore</a>
    </div>
@endsection
