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
        @if ($contents->isEmpty())
            <p>No content available.</p>
        @else
            @foreach ($contents as $content)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset($content->image) }}" class="card-img-top" alt="Content Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $content->name }}</h5>
                            <a href="/content/{{ $content->id }}" class="btn btn-primary">View Content</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
