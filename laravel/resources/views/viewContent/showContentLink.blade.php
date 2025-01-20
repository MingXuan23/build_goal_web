@extends('mainLayout')

@section('content')
<div class="main-content landing-main px-0">
<div class="landing-banner" id="home">
            <section class="section pb-0 bg-light">
                <div class="container" style="padding: 11px">
                    <div class="row justify-content-center text-center">
                        
                    </div>
                </div>
            </section>
        </div>
    <div class="container d-flex justify-content-center mt-4">
        <div class="card custom-card bg-white-transparent shadow-xl"
            style="width: 100%; max-width: 600px; border: 2px solid rgb(0, 0, 0); border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <!-- Card Header -->
            <div class="card-header justify-content-between m-0">
                <div class="card-title text-center">
                    {{ $contents->name }}
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Display image or fallback -->
                @if ($contents->image)
                    <img src="{{ asset('storage/' . $contents->image) }}" class="card-img-top"
                        alt="{{ $contents->name }}" onerror="console.log('Image failed to load:', this.src);"
                        style="object-fit: cover;">
                @else
                    <div class="d-flex align-items-center justify-content-center card-img-top bg-primary text-white mb-3"
                        style="height: 200px; font-size: 48px; font-weight: bold;">
                        {{ strtoupper(substr($contents->name, 0, 1)) }}
                    </div>
                @endif

                <!-- Content Information -->
                <p class="text-muted mb-2 mt-2">{{ $contents->content_type_name }}</p>
                <p class="text-muted"><em>{{ $contents->desc }}</em></p>

                <!-- Dynamic Content -->
                <div id="formattedContent" class="content-preview mt-3">
    @php
        // Split content into sections by delimiter ***
        $contentSections = explode("***", $contents->content);

        // Remove empty sections caused by leading or trailing ***
        $contentSections = array_filter($contentSections, fn($section) => trim($section) !== '');
    @endphp

    @foreach ($contentSections as $index => $section)
        @php
            // Trim whitespace from the section
            $section = trim($section);

            // Check if the section is a header
            if ($index % 2 === 1) {
                $header = $section;
                $body = isset($contentSections[$index + 1]) ? trim($contentSections[$index + 1]) : null;
            } else {
                $header = null;
                $body = $section;
            }
        @endphp

        @if ($header)
            <div class="preview-section">
                <h6 class="fw-bold">Step {{ ($index  + 1)/2 }}: {{ $header }}</h6>
                @if ($body)
                    <p>{{ $body }}</p>
                @endif
            </div>
        @else
            <p>{{ $section }}</p>
        @endif
    @endforeach

    <!-- Embed Button or Iframe for Link -->
    @if ($contents->link)
        @php
            // Check if the link is a YouTube URL
            preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/', $contents->link, $youtubeMatch);
        @endphp

        @if ($youtubeMatch)
            <!-- Embed YouTube Iframe -->
            <div class="text-center mt-4">
                <iframe width="100%" height="315"
                    src="https://www.youtube.com/embed/{{ $youtubeMatch[1] }}"
                    frameborder="0" allowfullscreen>
                </iframe>
            </div>
        @else
            <!-- Display External Link Button -->
            <div class="text-center mt-4">
                <p><strong>Interested? Click the button below to learn more:</strong></p>
                <a href="{{ $contents->link }}" target="_blank" class="btn btn-primary">Learn More</a>
            </div>
        @endif
    @endif
</div>


            <!-- Card Footer -->
            <div class="card-footer text-center">
                <span class="text-muted">Last updated
                    {{ \Carbon\Carbon::parse($contents->created_at)->diffForHumans() }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
