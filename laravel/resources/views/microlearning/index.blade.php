@extends('microlearning.layouts.app')

@section('title', 'Microlearning - Explore Content')

@section('content')
    <h1>Explore Content</h1>
    <form class="d-flex mb-4" method="GET" action="/microlearning">
        <input 
            class="form-control me-2" 
            type="search" 
            name="search" 
            placeholder="Search content..." 
            aria-label="Search" 
            value="{{ request('search') }}"
        >
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>

    <div class="row">
        @forelse ($contents as $content)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ $content['thumbnail'] }}" class="card-img-top" alt="Thumbnail">
                    <div class="card-body">
                        <h5 class="card-title">{{ $content['title'] }}</h5>
                        <a href="/content/{{ $content['id'] }}" class="btn btn-primary">View Content</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No content available.</p>
        @endforelse
    </div>
@endsection
