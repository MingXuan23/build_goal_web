<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed"
    data-theme-mode="color" style="--primary-rgb: 0,25,84;">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> xBug </title>
    <meta name="Description" content="xBug">
    <meta name="Author" content="xBug Inc">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/logo.ico') }}" type="image/x-icon">

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">

    <!-- Node Waves Css -->
    <link href="{{ asset('assets/libs/node-waves/waves.min.css') }}" rel="stylesheet">

    <!-- SwiperJS Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.0/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.0/ScrollTrigger.min.js"></script>



    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/@simonwep/pickr/themes/nano.min.css') }}">

    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}">

    <script>
        if (localStorage.ynexlandingdarktheme) {
            document.querySelector("html").setAttribute("data-theme-mode", "dark")
        }
        if (localStorage.ynexlandingrtl) {
            document.querySelector("html").setAttribute("dir", "rtl")
            document.querySelector("#style")?.setAttribute("href",
                "{{ asset('assets/libs/bootstrap/css/bootstrap.rtl.min.css') }}");
        }
    </script>


</head>

<body class="landing-body">


    <div class="landing-page-wrapper">

        <!-- Start::app-sidebar -->
        <header class="app-header">

            <!-- Start::main-header-container -->
            <div class="main-header-container container-fluid">

                <!-- Start::header-content-left -->
                <div class="header-content-left">

                    <!-- Start::header-element -->
                    <div class="header-element">
                        <div class="horizontal-logo d-flex justify-content-center align-items-center">
                            <a href="#" class="header-logo">
                                <img src="{{ asset('assets/images/logo.png') }}" width="55" height="50"
                                    alt="logo"></img>
                            </a>
                        </div>
                    </div>
                    <!-- End::header-element -->

                    <!-- Start::header-element -->
                    <div class="header-element">
                        <!-- Start::header-link -->
                        <a href="javascript:void(0);" class="sidemenu-toggle header-link" data-bs-toggle="sidebar">
                            <span class="open-toggle">
                                <i class="ri-menu-3-line fs-20"></i>
                            </span>
                        </a>
                        <!-- End::header-link -->
                    </div>
                    <!-- End::header-element -->

                </div>
                <!-- End::header-content-left -->

                <!-- Start::header-content-right -->
                <div class="header-content-right">

                    <!-- Start::header-element -->
                    <div class="header-element align-items-center">
                        <!-- Start::header-link|switcher-icon -->
                        <div class="btn-list d-lg-none d-block">


                            @if (Auth::check())
                                @php
                                    $roles = json_decode(Auth::user()->role, true); // Decode JSON string to array
                                @endphp
                                <span
                                    class="mt-2 me-2 fw-bold text-primary">{{ implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 1)) }}</span>
                                @if (in_array(1, $roles))
                                    {{-- Admin --}}
                                    <a href="/admin/dashboard" class="btn btn-wave btn-primary">
                                        Dashboard
                                    </a>
                                @elseif (in_array(2, $roles))
                                    {{-- Organization --}}
                                    <a href="/organization/dashboard" class="btn btn-wave btn-primary">
                                        Dashboard
                                    </a>
                                @elseif (in_array(3, $roles))
                                    {{-- Content Creator --}}
                                    <a href="/creator/dashboard" class="btn btn-wave btn-primary">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="/login" class="btn btn-wave btn-primary">
                                        Sign In
                                    </a>
                                @endif
                            @else
                                <a href="/login" class="btn btn-wave btn-primary">
                                    Sign In
                                </a>
                            @endif

                        </div>
                        <!-- End::header-link|switcher-i    con -->
                    </div>
                    <!-- End::header-element -->

                </div>
                <!-- End::header-content-right -->

            </div>
            <!-- End::main-header-container -->

        </header>

        <aside class="app-sidebar sticky" id="sidebar">

            <div class="container-xl">
                <!-- Start::main-sidebar -->
                <div class="main-sidebar">

                    <!-- Start::nav -->
                    <nav class="main-menu-container nav nav-pills sub-open">
                        <div class="landing-logo-container">
                            <div class="horizontal-logo">
                                <a href="index.html" class="header-logo">
                                    <img src="{{ asset('assets/images/logo.png') }}" width="55" height="50"
                                        alt="logo"></img>
                                </a>
                            </div>
                        </div>
                        <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                                width="24" height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                            </svg></div>
                        <ul class="main-menu">
                            <!-- Start::slide -->
                            <li class="slide">
                                <a class="side-menu__item" href="/">
                                    <span class="side-menu__label text-primary fw-bold">Home</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="/#about" class="side-menu__item">
                                    <span class="side-menu__label text-primary fw-bold">About</span>
                                </a>
                            </li>
                            <li class="slide">
                                <a href="/view-content" class="side-menu__item">
                                    <span class="side-menu__label text-primary fw-bold">Content</span>
                                </a>
                            </li>
                            <li class="slide">
                                <a href="/price" class="side-menu__item">
                                    <span class="side-menu__label text-primary fw-bold">Price</span>
                                </a>
                            </li>
                            <li class="slide">
                                <a href="/faq" class="side-menu__item">
                                    <span class="side-menu__label text-primary fw-bold">Faq's</span>
                                </a>
                            </li>
                            {{-- <li class="slide">
                                <a href="/jobstreet" class="side-menu__item">
                                    <span class="side-menu__label">Discover</span>
                                </a>
                            </li> --}}
                            <!-- End::slide -->
                            <!-- Start::slide -->

                            <!-- End::slide -->

                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                                </path>
                            </svg></div>
                        <div class="d-lg-flex d-none">
                            <div class="btn-list d-lg-flex d-none mt-lg-2 mt-xl-0 mt-0">

                                @if (Auth::check())
                                    @php
                                        $roles = json_decode(Auth::user()->role, true); // Decode JSON string to array
                                    @endphp
                                    <span
                                        class="side-menu__label mt-3 fw-bold text-primary">{{ implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 2)) }}</span>
                                    @if (in_array(1, $roles))
                                        {{-- Admin --}}
                                        <div class="side-menu__item">
                                            <a href="/admin/dashboard" class="btn btn-primary px-3 py-2">
                                                Admin Dashboard
                                            </a>
                                        </div>
                                    @elseif (in_array(2, $roles))
                                        {{-- Organization --}}
                                        <div class="side-menu__item">
                                            <a href="/organization/dashboard" class="btn btn-primary px-3 py-2">
                                                Organization Dashboard
                                            </a>
                                        </div>
                                    @elseif (in_array(3, $roles))
                                        {{-- Content Creator --}}
                                        <div class="side-menu__item">
                                            <a href="/content-creator/dashboard" class="btn btn-primary px-3 py-2">
                                                Content Creator Dashboard
                                            </a>
                                        </div>
                                    @else
                                        <a href="/login" class="btn btn-wave btn-primary">
                                            Sign In
                                        </a>
                                    @endif
                                @else
                                    <a href="/login" class="btn btn-wave btn-primary">
                                        Sign In
                                    </a>
                                @endif


                            </div>
                        </div>
                    </nav>
                    <!-- End::nav -->

                </div>
                <!-- End::main-sidebar -->
            </div>

        </aside>
        <!-- End::app-sidebar -->

        <!-- Start::app-content -->
        @yield('content')
        <!-- End::app-content -->
        <section class="section landing-footer text-fixed-dark bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-12 mb-md-0 mb-3">
                        <div class="px-4">
                            <p class="fw-semibold mb-3"><a href="index.html"><img
                                        src="{{ asset('assets/images/logo.png') }}" alt=""
                                        style="width: 50px;"></a></p>
                            <p class="mb-2 op-6 fw-normal text-dark">
                                With xBUG, you have the tools to manage finances effectively while setting and
                                achieving goals. This platform empowers both individuals and organizations to grow
                                strategically and reach their full potential.
                            </p>
                            <p class="mb-0 op-6 fw-normal text-dark">All rights
                                reserved Copyright © <span id="year">2025</span> <span
                                    class="fw-bold">xBUG</span> - Protected with Advanced
                                Security</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-12 text-dark">
                        <div class="px-4">
                            <h6 class="fw-semibold mb-3 text-fixed-dark">PAGES</h6>
                            <ul class="list-unstyled op-6 fw-normal landing-footer-list">
                                <li>
                                    <a href="{{ route('showContentDetail', 'Course-and-Training') }}"
                                        class="text-fixed-dark">Course and Training</a>
                                </li>
                                <li>
                                    <a href="{{ route('showContentDetail', 'Event') }}"
                                        class="text-fixed-dark">Event</a>
                                </li>
                                <li>
                                    <a href="{{ route('showContentDetail', 'Job-Offering') }}"
                                        class="text-fixed-dark">Job Offering</a>
                                </li>
                                <li>
                                    <a href="{{ route('showContentDetail', 'MicroLearning-Resource') }}"
                                        class="text-fixed-dark">MicroLearning Resource</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-12 text-dark">
                        <div class="px-4">
                            <h6 class="fw-semibold text-fixed-dark">INFO</h6>
                            <ul class="list-unstyled op-6 fw-normal landing-footer-list">
                                <li>
                                    <a href="{{ route('home') }}" class="text-fixed-dark">Home</a>
                                </li>
                                <li>
                                    <a href="{{ route('viewLogin') }}" class="text-fixed-dark">Login</a>
                                </li>
                                <li>
                                    <a href="{{ route('viewVerifyUserOrganization') }}"
                                        class="text-fixed-dark">Register</a>
                                </li>
                                <li>
                                    <a href="{{ route('home') }}/#about" class="text-fixed-dark">About</a>
                                </li>
                                <li>
                                    <a href="{{ route('price') }}" class="text-fixed-dark">Price</a>
                                </li>
                                <li>
                                    <a href="{{ route('faq') }}" class="text-fixed-dark">Faq's</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="px-4">
                            <h6 class="fw-semibold text-fixed-dark">CONTACT</h6>
                            <ul class="list-unstyled fw-normal landing-footer-list">
                                <li>
                                    <a href="javascript:void(0);" class="text-fixed-dark op-6"><i
                                            class="ri-home-4-line me-1 align-middle"></i> MyKL Tower, 62250,
                                        Putrajaya</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="text-fixed-dark op-6"><i
                                            class="ri-mail-line me-1 align-middle"></i> info@xbug.online</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="text-fixed-dark op-6"><i
                                            class="ri-phone-line me-1 align-middle"></i> +(60)-1920 1831</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="text-fixed-dark op-6"><i
                                            class="ri-printer-line me-1 align-middle"></i> +(60) 1293 123</a>
                                </li>
                                <li class="mt-3">
                                    <p class="mb-2 fw-semibold op-8">FOLLOW US ON :</p>
                                    <div class="mb-0">
                                        <div class="btn-list">
                                            <button
                                                class="btn btn-sm btn-icon btn-primary-light btn-wave waves-effect waves-light">
                                                <i class="ri-facebook-line fw-bold"></i>
                                            </button>
                                            <button
                                                class="btn btn-sm btn-icon btn-secondary-light btn-wave waves-effect waves-light">
                                                <i class="ri-twitter-x-line fw-bold"></i>
                                            </button>
                                            <button
                                                class="btn btn-sm btn-icon btn-warning-light btn-wave waves-effect waves-light">
                                                <i class="ri-instagram-line fw-bold"></i>
                                            </button>
                                            <button
                                                class="btn btn-sm btn-icon btn-success-light btn-wave waves-effect waves-light">
                                                <i class="ri-github-line fw-bold"></i>
                                            </button>
                                            <button
                                                class="btn btn-sm btn-icon btn-danger-light btn-wave waves-effect waves-light">
                                                <i class="ri-youtube-line fw-bold"></i>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>

    <!-- Popper JS -->
    <script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

    <!-- Choices JS -->
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

    <!-- Swiper JS -->
    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Defaultmenu JS -->
    <script src="{{ asset('assets/js/defaultmenu.min.js') }}"></script>

    <!-- Internal Landing JS -->
    <script src="{{ asset('assets/js/landing.js') }}"></script>

    <!-- Node Waves JS-->
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Sticky JS -->
    <script src="{{ asset('assets/js/sticky.js') }}"></script>
    <script>
        gsap.from("section .container .row .col-md-4 img", {
            opacity: 0,
            y: -50,
            duration: 1.5,
            delay: 0.3
        });

        // Animasi untuk deskripsi teks di footer
        gsap.from("section .container .row .col-md-4 p", {
            opacity: 0,
            x: -100,
            duration: 1,
            stagger: 0.2, // Memberikan efek stagger ke setiap elemen <p>
            delay: 0.5
        });

        // Animasi untuk bagian 'PAGES' dan 'INFO'
        gsap.from("section .container .row .col-md-2 h6, section .container .row .col-md-2 ul", {
            opacity: 0,
            x: 100,
            duration: 1,
            stagger: 0.3,
            delay: 0.7
        });

        // Animasi untuk bagian 'CONTACT'
        gsap.from("section .container .row .col-md-4 h6, section .container .row .col-md-4 ul", {
            opacity: 0,
            x: -100,
            duration: 1,
            stagger: 0.3,
            delay: 1
        });

        // Animasi untuk tombol sosial media
        gsap.from("section .container .row .col-md-4 .btn-list button", {
            opacity: 0,
            y: 50,
            duration: 0.8,
            stagger: 0.1,
            delay: 1.3
        });

        // Animasi untuk tahun (footer copyright)
        gsap.from("#year", {
            opacity: 0,
            y: 20,
            duration: 1,
            delay: 1.5
        });
    </script>
</body>

</html>
