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
                                <div class="custom-form-group">
                                    <input type="text" class="form-control form-control-lg shadow-sm"
                                        placeholder="your keyword...." aria-label="Recipient's username">
                                    <div class="custom-form-btn bg-transparent p-0">
                                        <button class="btn btn-primary border-0" type="button"><i
                                                class="bi bi-search me-sm-2"></i> <span>Search</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
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
        </section>
        <!-- End:: Section-11 -->

        <div class="text-center landing-main-footer py-3 bg-white">
            <span class="text-dark fw-bold mb-0">All
                rights
                reserved Copyright © <span id="year">2025</span> xBug - Protected with Advanced Security
            </span>

        </div>

    </div>
    <script>
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
