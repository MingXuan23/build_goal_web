@extends('mainLayout')

@section('content')
    <div class="main-content landing-main px-0 bg-light d-flex flex-column">

        <div class="landing-banner">
            <section class="section pb-0 bg-light">
                <div class="container" style="padding: 11px">
                    <div class="row justify-content-center text-center">
                    </div>
                </div>
            </section>
        </div>

        <!-- Start::row-1 -->
        <div class="container flex-grow-1">
            <div class="row mb-5">
                <div class="col-xl-12">
                    <h5 class="fw-bold text-center mt-4">Promote Your Content in our Platform App</h5>
                    <p class="text-muted text-center">Choose plan that suits best for your business needs, Our plans scales
                        with you based on your needs</p>
                </div>
                <div class="col-xl-12">
                    <div class="tab-content" id="myTabContent1">
                        <div class="tab-pane show active p-0 border-0" id="pricing-monthly1-pane" role="tabpanel"
                            aria-labelledby="pricing-monthly1" tabindex="0">
                            <div class="row">
                                <!-- Premium Package -->
                                <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-3">
                                    <div class="card custom-card overflow-hidden d-flex h-100">
                                        <div class="card-body p-0">
                                            <div class="px-1 py-2 bg-success op-3"></div>
                                            <div class="p-4">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="fs-18 fw-semibold">Basic Package</div>
                                                    <div>
                                                        <span class="badge bg-success-transparent">For Small
                                                            Campaigns</span>
                                                    </div>
                                                </div>
                                                <div class="fs-25 fw-bold mb-1">RM 1.00<sub
                                                        class="text-muted fw-semibold fs-11 ms-1">/ Per Content</sub></div>
                                                <div class="mb-1 text-muted">The perfect choice for startups and small
                                                    brands to begin their journey to success. Reach the right audience with
                                                    ease and make your mark in the digital world.</div>
                                                <div class="fs-12 mb-3"><u>One Time Payment</u></div>
                                                <ul class="list-unstyled mb-0">
                                                    <li class="d-flex align-items-center mb-3">
                                                        <span class="me-2">
                                                            <i class="ri-checkbox-circle-line fs-15 text-success"></i>
                                                        </span>
                                                        <span><strong class="me-1 d-inline-block">50</strong>Estimated
                                                            Users</span>
                                                    </li>
                                                    <li class="d-grid">
                                                        <a href="/login" class="btn btn-light btn-wave">Choose Plan</a>
                                                    </li>
                                                </ul>
                                                <p class="mt-3 text-muted">Start small, think big. Grow your brand step by
                                                    step with precision and purpose.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Professional Package -->
                                <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-3">
                                    <div class="card custom-card overflow-hidden border border-primary d-flex h-100">
                                        <div class="card-body p-0 text-bold">
                                            <div class="px-1 py-2 bg-primary op-5"></div>
                                            <div class="p-4">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="fs-18 fw-semibold">Professional Package</div>
                                                    <div>
                                                        <span class="badge bg-primary-transparent">For Growing
                                                            Campaigns</span>
                                                    </div>
                                                </div>
                                                <div class="fs-25 fw-bold mb-1">RM 200.00<sub
                                                        class="text-muted fw-semibold fs-11 ms-1">/ Per Content</sub></div>
                                                <div class="mb-1 text-muted">Tailored for businesses ready to scale their
                                                    campaigns and expand their market reach. Take your brand to the next
                                                    level with confidence and creativity.</div>
                                                <div class="fs-12 mb-3"><u>One Time Payment</u></div>
                                                <ul class="list-unstyled mb-0">
                                                    <li class="d-flex align-items-center mb-3">
                                                        <span class="me-2">
                                                            <i class="ri-checkbox-circle-line fs-15 text-success"></i>
                                                        </span>
                                                        <span><strong class="me-1 d-inline-block">100</strong>Estimated
                                                            Users</span>
                                                    </li>
                                                    <li class="d-grid">
                                                        <a href="/login" class="btn btn-primary btn-wave">Choose Plan</a>
                                                    </li>
                                                </ul>
                                                <p class="mt-3 text-muted">Amplify your message and reach new heights.
                                                    Empower your business with innovative solutions that unlock real
                                                    potential.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Growth Package -->
                                <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-3">
                                    <div class="card custom-card overflow-hidden d-flex h-100">
                                        <div class="card-body p-0">
                                            <div class="px-1 py-2 bg-success op-3"></div>
                                            <div class="p-4">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="fs-18 fw-semibold">Growth Package</div>
                                                    <div>
                                                        <span class="badge bg-success-transparent">For Expanding
                                                            Brands</span>
                                                    </div>
                                                </div>
                                                <div class="fs-25 fw-bold mb-1">RM 300.00<sub
                                                        class="text-muted fw-semibold fs-11 ms-1">/ Per Content</sub></div>
                                                <div class="mb-1 text-muted">The ultimate choice for businesses on a growth
                                                    trajectory. Connect with a broader audience, enhance engagement, and
                                                    create an unforgettable experience.</div>
                                                <div class="fs-12 mb-3"><u>One Time Payment</u></div>
                                                <ul class="list-unstyled mb-0">
                                                    <li class="d-flex align-items-center mb-3">
                                                        <span class="me-2">
                                                            <i class="ri-checkbox-circle-line fs-15 text-success"></i>
                                                        </span>
                                                        <span><strong class="me-1 d-inline-block">150</strong>Estimated
                                                            Users</span>
                                                    </li>
                                                    <li class="d-grid">
                                                        <a href="/login" class="btn btn-light btn-wave">Choose Plan</a>
                                                    </li>
                                                </ul>
                                                <p class="mt-3 text-muted">Expand your reach, amplify your voice, and leave
                                                    a lasting impression in your industry.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Enterprise Package -->
                                <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-3">
                                    <div class="card custom-card overflow-hidden d-flex h-100">
                                        <div class="card-body p-0">
                                            <div class="px-1 py-2 bg-success op-3"></div>
                                            <div class="p-4">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="fs-18 fw-semibold">Enterprise Package</div>
                                                    <div>
                                                        <span class="badge bg-success-transparent">For Large
                                                            Enterprises</span>
                                                    </div>
                                                </div>
                                                <div class="fs-25 fw-bold mb-1">RM 400.00<sub
                                                        class="text-muted fw-semibold fs-11 ms-1">/ Per Content</sub></div>
                                                <div class="mb-1 text-muted">The elite choice for large corporations looking
                                                    to dominate the market. Reach thousands of users effortlessly and leave
                                                    a powerful impression that echoes across industries.</div>
                                                <div class="fs-12 mb-3"><u>One Time Payment</u></div>
                                                <ul class="list-unstyled mb-0">
                                                    <li class="d-flex align-items-center mb-3">
                                                        <span class="me-2">
                                                            <i class="ri-checkbox-circle-line fs-15 text-success"></i>
                                                        </span>
                                                        <span><strong class="me-1 d-inline-block">200</strong>Estimated
                                                            Users</span>
                                                    </li>
                                                    <li class="d-grid">
                                                        <a href="/login" class="btn btn-light btn-wave">Choose Plan</a>
                                                    </li>
                                                </ul>
                                                <p class="mt-3 text-muted">Make an impact that lasts. Elevate your business
                                                    to its highest potential with unmatched reach and support.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End:: row-1 -->
        </div>

        {{-- <div class="text-center landing-main-footer py-3 bg-white">
            <span class="text-dark fw-bold mb-0">All rights reserved Copyright © <span id="year">2025</span> xBug -
                Protected
                with Advanced Security</span>
        </div> --}}

    </div>

    <script>
        gsap.from(".text-primary", {
            duration: 1.5,
            opacity: 0,
            y: 50,
            ease: "power4.out",
            delay: 0.5
        });

        gsap.from("h5", {
            opacity: 0, // Mulai dari transparan
            y: 30, // Geser sedikit ke bawah
            duration: 1.2, // Durasi animasi
            delay: 0.3, // Delay setelah elemen lain muncul
            ease: "power3.out", // Jenis easing untuk transisi halus
        });

        // // Animasi untuk paragraf p
        // gsap.from("p", {
        //     opacity: 0, // Mulai dari transparan
        //     y: 20, // Geser sedikit ke bawah
        //     duration: 1.2, // Durasi animasi
        //     delay: 0.6, // Delay setelah judul muncul
        //     ease: "power3.out", // Jenis easing
        // });

        gsap.from(".custom-card", {
            opacity: 0, // Mulai dengan transparan
            y: 30, // Pergeseran ke bawah
            scale: 0.9, // Mulai dengan sedikit lebih kecil
            duration: 1.8, // Durasi animasi 1 detik
            delay: 0.3, // Jeda sedikit setelah halaman dimuat
            ease: "power3.out", // Easing halus
        });
    </script>
@endsection
