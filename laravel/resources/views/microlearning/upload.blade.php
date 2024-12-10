@extends('microlearning.layouts.app')

@section('title', 'Upload Content')

@section('content')
    <h1>Upload Content</h1>
    <form action="/microlearning/upload" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail (Image)</label>
            <input type="file" class="form-control" id="thumbnail" name="thumbnail" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content (Text/Video)</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
@endsection
