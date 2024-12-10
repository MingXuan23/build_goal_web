@extends('microlearning.layouts.app')

@section('title', $content['title'])

@section('content')
    <h1>{{ $content['title'] }}</h1>
    <img src="{{ $content['thumbnail'] }}" class="img-fluid mb-3" alt="Thumbnail">
    <p>{{ $content['content'] }}</p>
    <a href="/microlearning" class="btn btn-secondary">Back to Main Page</a>
@endsection

