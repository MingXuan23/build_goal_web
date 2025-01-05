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
        <div class="row justify-content-center mb-5">
            <div class="col-xl-12">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="text-center p-3 faq-header mb-4">
                            <h5 class="mb-1 fw-semibold mt-1">F.A.Q's</h5>
                            <h4 class="mb-1 fw-semibold">Frequently Asked Questions</h4>
                            <p class="fs-15 text-muted op-7">We have shared some of the most frequently asked questions to
                                help you out! </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="col-xl-10">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <div class="card-title">
                                        General Topics ?
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="accordion accordion-customicon1 accordion-primary" id="accordionFAQ1">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2One">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapsecustomicon2One" aria-expanded="true"
                                                    aria-controls="collapsecustomicon2One">
                                                    What does xBUG do?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2One" class="accordion-collapse collapse show"
                                                aria-labelledby="headingcustomicon2One" data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    xBUG is a service that serves as a financial advisor or planner
                                                        that could help
                                                        you generate more income to achieve your dream lifestyle.
                                                    <!-- <code>.accordion-body</code>, though the transition does limit overflow. -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2Two">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Two"
                                                    aria-expanded="false" aria-controls="collapsecustomicon2Two">
                                                    Who is xBUG for?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2Two" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon2Two" data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    xBUG is ideal for individuals, freelancers, small businesses,
                                                        and anyone looking to stay on top of their finances.
                                                    <!-- <code>.accordion-body</code>, though the transition does limit overflow. -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2Three">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Three"
                                                    aria-expanded="false" aria-controls="collapsecustomicon2Three">
                                                    Can I use xBUG with 0 financial knowledge?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2Three" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon2Three" data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    Of course! Even for novices, XBUG is made to be simple and easy
                                                        to use.
                                                        It helps you easily understand and manage your finances by breaking
                                                        down difficult financial topics into understandable, actionable
                                                        insights.
                                                        XBUG helps you every step of the way, whether you're creating a
                                                        budget, keeping track of your spending, or making financial
                                                        plans.
                                                    <!-- <code>.accordion-body</code>, though the transition does limit overflow. -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2Four">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Four"
                                                    aria-expanded="false" aria-controls="collapsecustomicon2Four">
                                                    Is xBUG Secure?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2Four" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon2Four" data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    <strong>Yes!</strong> XBUG uses advanced encryption protocols to ensure
                                                    your data is safe and secure.
                                                    <!-- <code>.accordion-body</code>, though the transition does limit overflow. -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <div class="card-title">
                                        Customer Support ?
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="accordion accordion-customicon1 accordion-primary" id="accordionFAQ3">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon3One">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon3One"
                                                    aria-expanded="false" aria-controls="collapsecustomicon3One">
                                                    Does xBUG store my bank credentials?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon3One" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon3One" data-bs-parent="#accordionFAQ3">
                                                <div class="accordion-body">
                                                    No, xBUG connects to your financial institutions via secure APIs
                                                        and doesn't save your private login credentials.
                                                        <!-- <code>.accordion-body</code>, though the transition does limit overflow. -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon3Two">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapsecustomicon3Two" aria-expanded="true"
                                                    aria-controls="collapsecustomicon3Two">
                                                    How do I sign up an account?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon3Two" class="accordion-collapse collapse show"
                                                aria-labelledby="headingcustomicon3Two" data-bs-parent="#accordionFAQ3">
                                                <div class="accordion-body">
                                                    Simply click the <a href="/login">sign in</a> button to log in
                                                        to your account or click <a
                                                            href="/verify-user-organization">here</a> to register.
                                                    <!-- <code>.accordion-body</code>, though the transition does limit overflow. -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon3Three">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon3Three"
                                                    aria-expanded="false" aria-controls="collapsecustomicon3Three">
                                                    As an Organization, how do I monitor my contents?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon3Three" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon3Three" data-bs-parent="#accordionFAQ3">
                                                <div class="accordion-body">
                                                    xBUG provides a simple yet functional service that allows you to
                                                        monitor your contents through real time data.
                                                    <!-- <code>.accordion-body</code>, though the transition does limit overflow. -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon3Four">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon3Four"
                                                    aria-expanded="false" aria-controls="collapsecustomicon3Four">
                                                    How do I reset my password?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon3Four" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon3Four" data-bs-parent="#accordionFAQ3">
                                                <div class="accordion-body">
                                                   Having trouble logging in? Reset your password <a
                                                            href="/reset-password">here</a>.
                                                        <!-- <code>.accordion-body</code>, though the transition does limit overflow. -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-xl-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <div class="card-title">
                                        Still Have Questions ?
                                        <span class="subtitle fw-normal text-muted d-block fs-12">
                                            You can post your questions here,our support team is always active.
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row gy-3">
                                        <div class="col-xl-6">
                                            <label for="user-name" class="form-label">Your Name</label>
                                            <input type="text" class="form-control form-control-light" id="user-name"
                                                placeholder="Enter Your Name">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="user-email" class="form-label">Email Id</label>
                                            <input type="text" class="form-control form-control-light" id="user-email"
                                                placeholder="Enter Email">
                                        </div>
                                        <div class="col-xl-12">
                                            <label for="text-area" class="form-label">Textarea</label>
                                            <textarea class="form-control form-control-light" placeholder="Enter your question here" id="text-area"
                                                rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary btn-wave float-end">Send</button>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

        </div>

        {{-- <div class="text-center landing-main-footer py-3 bg-white">
            <span class="text-dark mb-0">All rights reserved Copyright © <span id="year">2025</span> xBug - Protected
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

        gsap.from("h4", {
            opacity: 0, // Mulai dengan transparan
            y: -20, // Geser sedikit dari atas
            duration: 1, // Durasi animasi 1 detik
            delay: 0.2, // Delay sedikit setelah halaman dimuat
            ease: "power3.out", // Easing halus
        });
        gsap.from("h5", {
            opacity: 0, // Mulai dengan transparan
            y: -20, // Geser sedikit dari atas
            duration: 1, // Durasi animasi 1 detik
            delay: 0.2, // Delay sedikit setelah halaman dimuat
            ease: "power3.out", // Easing halus
        });

        // // Animasi untuk paragraf p
        // gsap.from("p", {
        //     opacity: 0, // Mulai dengan transparan
        //     y: 20, // Geser sedikit dari bawah
        //     duration: 1, // Durasi animasi 1 detik
        //     delay: 0.5, // Delay sedikit setelah judul h4 muncul
        //     ease: "power3.out", // Easing halus
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
