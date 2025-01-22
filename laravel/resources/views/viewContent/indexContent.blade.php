@extends('mainLayout')
@section('content')
    <div class="main-content landing-main px-0">
        <div class="landing-banner" id="home">
            <section class="section pb-0 bg-light p-0">
                <div class="container main-banner-container">
                    <div class="row justify-content-center text-center">
                        <div class="col-xxl-7 col-xl-7 col-lg-8">
                            <div class="">
                                <h6 class="landing-banner-heading mb-3 text-primary mt-5"><span
                                        class="fw-bold text-primary">{{ $countContent }}+ </span>Content available</h6>
                                <p class="fs-18 mb-5 op-8 fw-normal text-fixed-primary">Register &amp; get free access to
                                    create your content and <br>submit your content with few easy steps. Browse Content Top
                                    Categories</p>
                                    <form action="{{ route('search') }}" method="GET">
                                        <div class="custom-form-group">
                                            <input type="text" name="keyword" class="form-control form-control-lg shadow-sm"
                                                placeholder="your keyword...." value="{{ request('keyword') }}">
                                            <div class="custom-form-btn bg-transparent p-0">
                                                <button class="btn btn-primary border-0" type="submit">
                                                    <i class="bi bi-search me-sm-2"></i> <span>Search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @if(!empty($keyword))
        <section class="section bg-light m-0" id="search-results">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-8 col-xl-12 col-lg-12 col-md-12 col-sm-12
                    ">
                    <h4 class="text-center fw-bold">Search Results for "{{ $keyword }}"</h4>

                @if($results->isEmpty())
                    <p class="text-center text-muted">No results found for "{{ $keyword }}".</p>
                @else
                    <div class="row">
                                <!-- Pagination Links -->
                    <div class="d-flex justify-content-end mt-4">
                        <ul class="pagination pagination-sm">
                        {{ $results->appends(['keyword' => $keyword])->links() }}<!-- Display pagination links -->
                        </ul>
                    </div>
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
                                    <div class="d-flex align-items-center justify-content-center card-img-top bg-primary text-white"
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
                                        <span class="badge bg-success fw-bold">Blockchain Verified</span>
                                        <p class="text-muted d-block mt-2" style="font-size: 11px;">
                                            This result has been recorded on the Blockchain Network through a smart contract to ensure its authenticity and integrity.
                                        </p>
                                    @endif
                                </div>
                                <div class="card-footer text-end">
                                @if ($result->content_type_id == 1 || $result->content_type_id == 4 || $result->content_type_id == 5)
                                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contentModal"
                                        onclick="showContentPreview({{ json_encode($result->result ?? '') }}, {{ json_encode($result->name) }}, {{ json_encode($result->desc) }}, {{ json_encode($result->enrollment_price) }}, {{ json_encode($result->participant_limit) }}, {{ json_encode($result->place) }}, {{ json_encode($result->link) }},{{ json_encode($result->updated_at) }},{{ json_encode($result->tx_hash) }},{{ json_encode($result->block_no) }})">
                                        Read More
                                    </a>
                                @elseif ($result->content_type_id == 2)
                                    <a href="{{ url('/view-content/' . $microLearningSlug . '/' . str_replace(' ', '~', $result->name)) }}" class="btn btn-primary">
                                        Read More
                                    </a>
                                @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                     <!-- Pagination Links -->
                     <div class="d-flex justify-content-end mt-4">
                        <ul class="pagination pagination-sm">
                             {{ $results->appends(['keyword' => $keyword])->links() }} <!-- Display pagination links -->
                        </ul>
                    </div>
                    </div>
                @endif
            </div>
        </section>
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
        @else
        <section class="section section-bg p-0  bg-light m-0" id="jobs">
            <div class="container">
                {{-- <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-1">
                    <div>
                        <p class="fs-12 fw-semibold mb-1 ms-5">Find jobs</p>
                        <h3 class="fw-semibold mb-0 ms-5">Browse Content Top Categories</h3>
                        <span class="text-muted fs-15 fw-normal d-block mb-2 ms-5">The best type for content and most popular</span>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-5">
                        <div class="card custom-card border p-4">
                            <div class="row g-0">
                                <div class="col-md-3 col-4 ">
                                    <img src="../assets/images/course-tranning.svg" style="width: 400px; height: 150px;"
                                        class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-9 col-8 my-auto">
                                    <div class="card-body">

                                        <h5 class="card-title fw-semibold">Course and Training</h5>
                                        <p><span class="text-default fw-semibold">{{ $countContents_CourseTraining }}
                                                Content</span> available</p>
                                        <a class="text-primary fw-semibold"
                                            href="{{ url('/view-content/' . $courseAndTrainingSlug) }}">
                                            Explore now for Course and Training
                                            <i class="ri-arrow-right-s-line align-middle transform-arrow lh-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card custom-card border p-4">
                            <div class="row g-0">
                                <div class="col-md-3 col-4">
                                    <img src="../assets/images/microLearning-resource.svg"
                                        style="width: 400px; height: 150px;" class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-9 col-8 my-auto">
                                    <div class="card-body">
                                        <h5 class="card-title fw-semibold">MicroLearning Resource</h5>
                                        <p><span class="text-default fw-semibold">{{ $countContents_MicroLearning }}
                                                Content</span> available</p>
                                        <a class="text-primary fw-semibold"
                                            href="{{ url('/view-content/' . $microLearningSlug) }}">
                                            Explore now for MicroLearning Resource
                                            <i class="ri-arrow-right-s-line align-middle transform-arrow lh-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-5">
                        <div class="card custom-card border p-4">
                            <div class="row g-0">
                                <div class="col-md-3 col-4">
                                    <img src="../assets/images/event.png" style="width: 400px; height: 150px;"
                                        class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-9 col-8 my-auto">
                                    <div class="card-body">
                                        <h5 class="card-title fw-semibold">Event</h5>
                                        <p><span class="text-default fw-semibold">{{ $countContents_Event }}
                                                active</span>
                                            event</p>
                                        <a class="text-primary fw-semibold"
                                            href="{{ url('/view-content/' . $eventSlug) }}">Explore now for Event<i
                                                class="ri-arrow-right-s-line align-middle transform-arrow lh-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card custom-card border p-4">
                            <div class="row g-0">
                                <div class="col-md-3 col-4">
                                    <img src="../assets/images/job.png" style="width: 400px; height: 150px;"
                                        class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-9 col-8 my-auto">
                                    <div class="card-body">
                                        <h5 class="card-title fw-semibold">Job Offering</h5>
                                        <p><span class="text-default fw-semibold">{{ $countContents_JobOffer }}
                                                Jobs</span>
                                            available</p>
                                        <a class="text-primary fw-semibold"
                                            href="{{ url('/view-content/' . $jobOfferingSlug) }}">Explore Jobs<i
                                                class="ri-arrow-right-s-line align-middle transform-arrow lh-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">

                    </div>
                </div>
            </div>
        </section>@endif
        <!-- End:: Section-11 -->

        {{-- <div class="text-center landing-main-footer py-3 bg-white">
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
        document.addEventListener("DOMContentLoaded", function() {

            gsap.from(".text-primary", {
                duration: 1.5,
                opacity: 0,
                y: 50,
                ease: "power4.out",
                delay: 0.5
            });
            // Animasi untuk setiap card
            gsap.from(".card", {
                opacity: 0, // Mulai dengan opacity 0
                y: 50, // Mulai dari posisi 50px lebih rendah
                stagger: 0.3, // Stagger untuk memberikan efek delay antara elemen
                duration: 5, // Durasi animasi setiap elemen
                ease: "power3.out", // Easing untuk memberikan efek smooth
            });

            gsap.from(".text-fixed-primary", {
                opacity: 0, // Mulai dari transparan
                y: 20, // Geser sedikit ke bawah
                duration: 0.3, // Durasi animasi
                delay: 0.5, // Delay sedikit setelah halaman dimuat
                ease: "power3.out", // Jenis easing untuk animasi yang lebih halus
            });
        });
    </script>
@endsection
