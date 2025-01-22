@extends('mainLayout')
@section('content')
    <div class="main-content landing-main px-0">
        <div class="landing-banner" id="home">
            <section class="section pb-0 bg-light">
                <div class="container main-banner-container">
                    <div class="row justify-content-center text-center">
                        <div class="col-xxl-7 col-xl-7 col-lg-8">
                            <div class="">
                                @if ($contentTypeId == 1)
                                    <h6 class="landing-banner-heading mb-3 text-primary"><span
                                            class="text-primary fw-bold ">{{ $countContents_CourseTraining }}+
                                        </span>Contents for Course and Training</h6>
                                    <p class="fs-18 mb-5 op-8 fw-normal text-fixed-primary" id="animate-text">Register &amp;
                                        get free
                                        access to create your content and <br>submit your content with few easy
                                        steps. Browse Content Top
                                        Categories</p>
                                        <form action="{{ route('showContentDetail', ['slug' => str_replace(' ', '-', $contentType)]) }}" method="GET">
                                            <div class="custom-form-group">
                                                <input type="text" name="keyword" class="form-control form-control-lg shadow-sm"
                                                    placeholder="Search within {{ $contentType }}" value="{{ request('keyword') }}">
                                                <div class="custom-form-btn bg-transparent p-0">
                                                    <button class="btn btn-primary border-0" type="submit">
                                                        <i class="bi bi-search me-sm-2"></i> <span>Search</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                @elseif($contentTypeId == 2)
                                    <h6 class="landing-banner-heading mb-3 text-primary"><span
                                            class=" fw-bold text-primary">{{ $countContents_MicroLearning }}+
                                        </span>Contents for MicroLearning Resource</h6>
                                    <p class="fs-18 mb-5 op-8 fw-normal text-fixed-primary" id="animate-text">Register &amp;
                                        get free
                                        access to create your content and <br>submit your content with few easy
                                        steps. Browse Content Top
                                        Categories</p>
                                        <form action="{{ route('showContentDetail', ['slug' => str_replace(' ', '-', $contentType)]) }}" method="GET">
                                            <div class="custom-form-group">
                                                <input type="text" name="keyword" class="form-control form-control-lg shadow-sm"
                                                    placeholder="Search within {{ $contentType }}" value="{{ request('keyword') }}">
                                                <div class="custom-form-btn bg-transparent p-0">
                                                    <button class="btn btn-primary border-0" type="submit">
                                                        <i class="bi bi-search me-sm-2"></i> <span>Search</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                @elseif($contentTypeId == 5)
                                    <h6 class="landing-banner-heading mb-3 text-primary"><span
                                            class=" fw-bold text-primary">{{ $countContents_Event }}+
                                        </span>Contents for Event</h6>
                                    <p class="fs-18 mb-5 op-8 fw-normal text-fixed-primary" id="animate-text">Register &amp;
                                        get free
                                        access to create your content and <br>submit your content with few easy
                                        steps. Browse Content Top
                                        Categories</p>
                                        <form action="{{ route('showContentDetail', ['slug' => str_replace(' ', '-', $contentType)]) }}" method="GET">
                                            <div class="custom-form-group">
                                                <input type="text" name="keyword" class="form-control form-control-lg shadow-sm"
                                                    placeholder="Search within {{ $contentType }}" value="{{ request('keyword') }}">
                                                <div class="custom-form-btn bg-transparent p-0">
                                                    <button class="btn btn-primary border-0" type="submit">
                                                        <i class="bi bi-search me-sm-2"></i> <span>Search</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                @elseif($contentTypeId == 4)
                                    <h6 class="landing-banner-heading mb-3 text-primary"><span
                                            class="text fw-bold text-primary">{{ $countContents_JobOffer }}+
                                        </span>Contents for Job and Offering</h6>
                                    <p class="fs-18 mb-5 op-8 fw-normal text-fixed-primary" id="animate-text">Register &amp;
                                        get free
                                        access to create your content and <br>submit your content with few easy
                                        steps. Browse Content Top
                                        Categories</p>
                                        <form action="{{ route('showContentDetail', ['slug' => str_replace(' ', '-', $contentType)]) }}" method="GET">
                                            <div class="custom-form-group">
                                                <input type="text" name="keyword" class="form-control form-control-lg shadow-sm"
                                                    placeholder="Search within {{ $contentType }}" value="{{ request('keyword') }}">
                                                <div class="custom-form-btn bg-transparent p-0">
                                                    <button class="btn btn-primary border-0" type="submit">
                                                        <i class="bi bi-search me-sm-2"></i> <span>Search</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @if(!empty($keyword))
        <section class="section bg-light m-0" id="search-results">
            <div class="container">
                <h5 class="text-center fw-bold">Search Results for "{{ $keyword }}"</h5>

                @if($results->isEmpty())
                    <p class="text-center text-muted">No results found for "{{ $keyword }}".</p>
                @else
                    <div class="row">
                        @foreach($results as $result)
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card custom-card d-flex h-100 border border-primary-2"
                                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                        <!-- Display image or fallback -->
                                        @if ($result->image)
                                            <img src="{{ asset('storage/' . $result->image) }}" class="card-img-top"
                                                alt="{{ $result->name }}"
                                                onerror="console.log('Image failed to load:', this.src);"
                                                style="height: 180px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-resul$result-center card-img-top bg-primary text-white"
                                                style="height: 180px; font-size: 48px; font-weight: bold;">
                                                {{ strtoupper(substr($result->name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div class="card-body">
                                            <span class="card-text text-muted mb-2">Last updated
                                                {{ \Carbon\Carbon::parse($result->created_at)->diffForHumans() }}</span>
                                            <h6 class="card-title fw-semibold">{{ $result->name }}</h6>
                                            <p class="card-text text-muted">{{ $result->content_type_name }}</p>

                                            @if (($result->tx_hash != null || $result->tx_hash != '') && $result->status_contract == 1)
                                                <span class="badge bg-success fw-bold">Blockchain
                                                    Verified</span>
                                                <p class="text-muted d-block mt-2" style="font-size: 11px;">
                                                    This result has been recorded on the Blockchain Network through a smart contract to ensure its authenticity and integrity.
                                                </p>
                                      
                                            @endif






                                        </div>
                                        <div class="card-footer text-end">
                                            <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#contentModal"
                                                onclick="showContentPreview({{ json_encode($result->result ?? '') }}, {{ json_encode($result->name) }}, {{ json_encode($result->desc) }}, {{ json_encode($result->enrollment_price) }}, {{ json_encode($result->participant_limit) }}, {{ json_encode($result->place) }}, {{ json_encode($result->link) }},{{ json_encode($result->updated_at) }},{{ json_encode($result->tx_hash) }},{{ json_encode($result->block_no) }})">
                                                Read More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
        @else
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-8 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="row g-3 mt-2">
                        @foreach ($contents as $content)
                            @if ($contentTypeId == 2)
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card custom-card d-flex h-100 border border-primary-2"
                                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                        <!-- Display image or fallback -->
                                        @if ($content->image)
                                            <img src="{{ asset('storage/' . $content->image) }}" class="card-img-top"
                                                {{-- alt="{{ $content->name }}" --}}
                                                onerror="console.log('Image failed to load:', this.src);"
                                                style="height: 180px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center card-img-top bg-primary text-white"
                                                style="height: 180px; font-size: 48px; font-weight: bold;">
                                                {{ strtoupper(substr($content->name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div class="card-body">
                                            <span class="card-text text-muted mb-2">Last updated
                                                {{ \Carbon\Carbon::parse($content->created_at)->diffForHumans() }}</span>
                                            <h6 class="card-title fw-semibold">{{ $content->name }}</h6>
                                            <p class="card-text text-muted">{{ $content->content_type_name }}</p>

                                            @if (($content->tx_hash != null || $content->tx_hash != '') && $content->status_contract == 1)
                                            <span class="badge bg-success fw-bold">Blockchain
                                                Verified</span>
                                            <p class="text-muted d-block mt-2" style="font-size: 11px;">
                                                This content has been recorded on the Blockchain Network through a smart contract to ensure its authenticity and integrity.
                                            </p>
                                  
                                        @endif

                                        </div>
                                        <div class="card-footer text-end">
                                            <a href="{{ url('/view-content/' . $microLearningSlug . '/' . str_replace(' ', '~', $content->name)) }}"
                                                class="btn btn-primary">
                                                Read More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card custom-card d-flex h-100 border border-primary-2"
                                        style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                        <!-- Display image or fallback -->
                                        @if ($content->image)
                                            <img src="{{ asset('storage/' . $content->image) }}" class="card-img-top"
                                                alt="{{ $content->name }}"
                                                onerror="console.log('Image failed to load:', this.src);"
                                                style="height: 180px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center card-img-top bg-primary text-white"
                                                style="height: 180px; font-size: 48px; font-weight: bold;">
                                                {{ strtoupper(substr($content->name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div class="card-body">
                                            <span class="card-text text-muted mb-2">Last updated
                                                {{ \Carbon\Carbon::parse($content->created_at)->diffForHumans() }}</span>
                                            <h6 class="card-title fw-semibold">{{ $content->name }}</h6>
                                            <p class="card-text text-muted">{{ $content->content_type_name }}</p>

                                            @if (($content->tx_hash != null || $content->tx_hash != '') && $content->status_contract == 1)
                                                <span class="badge bg-success fw-bold">Blockchain
                                                    Verified</span>
                                                <p class="text-muted d-block mt-2" style="font-size: 11px;">
                                                    This content has been recorded on the Blockchain Network through a smart contract to ensure its authenticity and integrity.
                                                </p>
                                      
                                            @endif


                                            <!-- <a href="javascript:void(0);"
                                                                                   class="btn btn-primary"
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-target="#contentModal"
                                                                                   onclick="showContentPreview('{{ $content->content }}', '{{ $content->name }}', '{{ $content->desc }},''{{ $content->enrollment_price }}','{{ $content->participant_limit }}','{{ $content->place }}','{{ $content->link }}')">
                                                                                   Read More
                                                                                </a> -->




                                        </div>
                                        <div class="card-footer text-end">
                                            <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#contentModal"
                                                onclick="showContentPreview({{ json_encode($content->content ?? '') }}, {{ json_encode($content->name) }}, {{ json_encode($content->desc) }}, {{ json_encode($content->enrollment_price) }}, {{ json_encode($content->participant_limit) }}, {{ json_encode($content->place) }}, {{ json_encode($content->link) }},{{ json_encode($content->updated_at) }},{{ json_encode($content->tx_hash) }},{{ json_encode($content->block_no) }})">
                                                Read More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>@endif


        
        <!-- Modal for Read More -->
        <div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="contentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="contentModalLabel">Content Details</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalContent">
                        <!-- Content preview will be dynamically inserted here -->
                    </div>
                    {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div> --}}
                </div>
            </div>
        </div>


        <!-- End:: Section-11 -->
        {{-- <div class="text-center landing-main-footer py-3 bg-light">
            <span class="text-dark fw-bold mb-0">All
                rights
                reserved Copyright © <span id="year">2025</span> xBug - Protected with Advanced Security
            </span>
        </div> --}}
    </div>
    <script>
        

        function showContentPreview(formattedContent, title, description, price, participant_limit, place, link, updatedAt,
            txHash, blockNo) {
            // Update the modal title
            document.getElementById('contentModalLabel').innerText = 'CONTENT INFORMATION';

            // Bangun konten preview
            let contentHtml = `
                <div class="p-3">
                    <h4 class="text-center fw-bold">${title}</h4>
                    <p><em>${description}</em></p>
                    <hr>
                    <p><strong>Price:</strong> ${price && price != 0 ? `RM${price}` : 'Free'}</p>
                    <p><strong>Participant Limit:</strong> ${participant_limit || 'Unlimited'}</p>
                    <p><strong>Place:</strong> ${place || 'N/A'}</p>
                    <div class="text-start">
                        ${txHash && blockNo ? `
                                    <span class="badge bg-success-transparent fw-bold">Blockchain Verified</span>
                                    <p class="text-muted mt-2" style="font-size: 11px;">
                                        This content was added to the smart contract on 
                                        <strong>${updatedAt}</strong>, at block number 
                                        <a href="https://sepolia.etherscan.io/block/${blockNo}" target="_blank" class="text-primary">
                                            <strong>${blockNo}</strong>
                                        </a>, ensuring its authenticity and integrity for this specific content.
                                    </p>
                                    <p style="font-size: 11px;">
                                        <a href="https://sepolia.etherscan.io/tx/${txHash}" target="_blank" class="text-primary">
                                            <strong>View Blockchain Transaction</strong>
                                        </a>
                                    </p>
                                ` : ''}
                    </div>
                    <hr>
                </div>
            `;


            // Format bagian konten
            const contentSections = formattedContent.split('\n\n');
            contentSections.forEach((section, index) => {
                const headerMatch = section.match(/\*\*\*(.*?)\*\*\*/); // Match header dalam ***
                if (headerMatch) {
                    const header = headerMatch[1]; // Ekstrak header
                    const body = section.replace(/\*\*\*(.*?)\*\*\*/, '').trim(); // Hapus header dan ekstrak body

                    // Tambahkan bagian yang diformat ke preview
                    contentHtml += `
            <div class="preview-section">
                <h2>Step ${index + 1}: ${header}</h2>
                <p>${body}</p>
            </div>
        `;
                }
            });

            // Tambahkan link eksternal jika disediakan
            if (link) {
                const youtubeMatch = link.match(
                    /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/);
                if (youtubeMatch) {
                    const videoId = youtubeMatch[1]; // Extract the YouTube video ID
                    contentHtml += `
            <hr>
            <div class="text-center">
                <iframe width="100%" height="315" 
                        src="https://www.youtube.com/embed/${videoId}" 
                        frameborder="0" allowfullscreen>
                </iframe>
            </div>
        `;
                } else {
                    contentHtml += `
            <hr>
            <p><strong>Interested? Click this button to learn more </strong><p>
            <p class="text-end"><a href="${link}" target="_blank" class="btn btn-primary">Learn More</a></p>
        `;
                }
            }

            // Masukkan konten ke dalam modal
            document.getElementById('modalContent').innerHTML = contentHtml;
        }
    </script>
    <script>
        gsap.from(".text-primary", {
            duration: 1.5,
            opacity: 0,
            y: 50,
            ease: "power4.out",
            delay: 0.5
        });
        gsap.from("#animate-text", {
            duration: 1.5, // Animation duration
            x: -100, // Slide in from left (x axis)
            opacity: 0, // Start from fully transparent
            ease: "power2.out", // Easing function for smooth animation
        });
        // Ensure the DOM is fully loaded before executing the script
        document.addEventListener('DOMContentLoaded', function() {
            // Select all elements with the class 'custom-card'
            const cards = document.querySelectorAll('.custom-card');

            // Initialize the IntersectionObserver
            const observer = new IntersectionObserver((entries, observerInstance) => {
                entries.forEach(entry => {
                    const card = entry.target;
                    const cardImage = card.querySelector('.card-img-top');

                    if (entry.isIntersecting) {
                        // If the card is in the viewport

                        // Show the image (in case it was previously hidden)
                        if (cardImage) {
                            cardImage.style.display = 'block';
                        }

                        // Animate the card using GSAP
                        gsap.fromTo(card, {
                            opacity: 0,
                            y: 30,
                            scale: 0.9
                        }, {
                            opacity: 1,
                            y: 0,
                            scale: 1,
                            duration: 1,
                            ease: "power3.out",
                            overwrite: 'auto' // Ensures animations don't stack
                        });

                    } else {
                        // If the card is out of the viewport

                        // Hide the image
                        if (cardImage) {
                            cardImage.style.display = 'none';
                        }

                        // Optional: Reset GSAP animations to allow re-animation upon re-entry
                        gsap.set(card, {
                            opacity: 0,
                            y: 30,
                            scale: 0.9
                        });
                    }
                });
            }, {
                threshold: 0.1 // Adjust this value based on when you want the animation to trigger
            });

            // Observe each card
            cards.forEach(card => {
                observer.observe(card);
            });
        });
    </script>
@endsection
