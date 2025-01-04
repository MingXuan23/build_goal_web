<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed"
    data-theme-mode="color" style="--primary-rgb: 17,28,67;">

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
                                <a class="side-menu__item" href="/#home">
                                    <span class="side-menu__label">Home</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="/#about" class="side-menu__item">
                                    <span class="side-menu__label">About</span>
                                </a>
                            </li>
                            <li class="slide">
                                <a href="/view-content" class="side-menu__item">
                                    <span class="side-menu__label">Content</span>
                                </a>
                            </li>
                            <li class="slide">
                                <a href="/jobstreet" class="side-menu__item">
                                    <span class="side-menu__label">Discover</span>
                                </a>
                            </li>
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
                                        class="mt-2 me-2 fw-bold text-primary">{{ implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 2)) }}</span>
                                    @if (in_array(1, $roles))
                                        {{-- Admin --}}
                                        <a href="/admin/dashboard" class="btn btn-wave btn-primary">
                                            Admin Dashboard
                                        </a>
                                    @elseif (in_array(2, $roles))
                                        {{-- Organization --}}
                                        <a href="/organization/dashboard" class="btn btn-wave btn-primary">
                                            Organization Dashboard
                                        </a>
                                    @elseif (in_array(3, $roles))
                                        {{-- Content Creator --}}
                                        <a href="/creator/dashboard" class="btn btn-wave btn-primary">
                                            Content Creator Dashboard
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

</body>

</html>
