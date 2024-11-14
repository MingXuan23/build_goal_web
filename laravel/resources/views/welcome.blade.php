<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed" data-theme-mode="light">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> xBug </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">

    <!-- Favicon -->
    <link rel="icon" href="assets/images/brand-logos/favicon.ico" type="image/x-icon">

    <!-- Bootstrap Css -->
    <link id="style" href="assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Style Css -->
    <link href="assets/css/styles.css" rel="stylesheet">

    <!-- Icons Css -->
    <link href="assets/css/icons.css" rel="stylesheet">

    <!-- Node Waves Css -->
    <link href="assets/libs/node-waves/waves.min.css" rel="stylesheet">

    <!-- SwiperJS Css -->
    <link rel="stylesheet" href="assets/libs/swiper/swiper-bundle.min.css">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="assets/libs/@simonwep/pickr/themes/nano.min.css">

    <!-- Choices Css -->
    <link rel="stylesheet" href="assets/libs/choices.js/public/assets/styles/choices.min.css">

    <script>
        if (localStorage.ynexlandingdarktheme) {
            document.querySelector("html").setAttribute("data-theme-mode", "dark")
        }
        if (localStorage.ynexlandingrtl) {
            document.querySelector("html").setAttribute("dir", "rtl")
            document.querySelector("#style")?.setAttribute("href", "../assets/libs/bootstrap/css/bootstrap.rtl.min.css");
        }
    </script>


</head>

<body class="landing-body">


    <div class="landing-page-wrapper">

        <!-- Start::app-sidebar -->
        <aside class="app-sidebar sticky" id="sidebar">

            <div class="container-xl">
                <!-- Start::main-sidebar -->
                <div class="main-sidebar">

                    <!-- Start::nav -->
                    <nav class="main-menu-container nav nav-pills sub-open">
                        <div class="landing-logo-container">
                            <div class="horizontal-logo">
                                <a href="index.html" class="header-logo">
                                    <h4 class="text-primary fw-bold">xBug</h4>
                                </a>
                            </div>
                        </div>
                        <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                            </svg></div>
                        <ul class="main-menu">
                            <!-- Start::slide -->
                            <li class="slide">
                                <a class="side-menu__item" href="#home">
                                    <span class="side-menu__label">Home</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#about" class="side-menu__item">
                                    <span class="side-menu__label">About</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                        
                            <!-- End::slide -->

                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                            </svg></div>
                        <div class="d-lg-flex d-none">
                            <div class="btn-list d-lg-flex d-none mt-lg-2 mt-xl-0 mt-0">

                                <a href="/login" class="btn btn-wave btn-primary">
                                    log In
                                </a>
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
        <div class="main-content landing-main px-0">

            <!-- Start:: Section-1 -->
            <div class="landing-banner" id="home">
                <section class="section">
                    <div class="container main-banner-container pb-lg-0">
                        <div class="row">
                            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8 mt-5">
                                <div class="py-lg-5">
                                    <p class="landing-banner-heading mb-3">Manage Your Financial Future</span></p>
                                    <div class="fs-16 mb-3 text-fixed-white op-7">We are dedicated to empowering users with comprehensive financial management tools, reinforcing our commitment to making personal finance accessible and efficient. Your trust fuels our drive to continuously enhance and simplify financial processes, providing a secure, reliable, and user-friendly experience for all.
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-4">
                                <div class="text-end landing-main-image landing-heading-img">
                                    <img src="/assets/images/landing-page/3.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- End:: Section-1 -->

            <!-- Start:: Section-2 -->
            <section class="section section-bg " id="statistics">
                <div class="container text-center position-relative">
                    <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">STATISTICS</span></p>
                    <h3 class="fw-semibold mb-2">More than 10+ financial transactions managed daily.</h3>
                    <div class="row justify-content-center">
                        <div class="col-xl-7">
                            <p class="text-muted fs-15 mb-5 fw-normal">Empower your financial future with our comprehensive tools and intuitive services.</p>
                        </div>
                    </div>
                    <div class="row  g-2 justify-content-center">
                        <div class="col-xl-12">
                            <div class="row justify-content-center">
                                <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                                    <div class="p-3 text-center rounded-2 bg-white border">
                                        <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                                            <i class='fs-24 bx bx-spreadsheet'></i>
                                        </span>
                                        <h3 class="fw-semibold mb-0 text-dark">12+</h3>
                                        <p class="mb-1 fs-14 op-7 text-muted ">
                                            Total Accounts Managed
                                        </p>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                                    <div class="p-3 text-center rounded-2 bg-white border">
                                        <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                                            <i class='fs-24 bx bx-user-circle'></i>
                                        </span>
                                        <h3 class="fw-semibold mb-0 text-dark">10+</h3>
                                        <p class="mb-1 fs-14 op-7 text-muted ">
                                            Budget Plans Created Today
                                        </p>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
                                    <div class="p-3 text-center rounded-2 bg-white border">
                                        <span class="mb-3 avatar avatar-lg avatar-rounded bg-primary-transparent">
                                            <i class='fs-24 bx bx-calendar'></i>
                                        </span>
                                        <h3 class="fw-semibold mb-0 text-dark">150+</h3>
                                        <p class="mb-1 fs-14 op-7 text-muted ">
                                            Financial Entries Processed Today
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-2 -->

            <!-- Start:: Section-3 -->
            <section class="section " id="about">
                <div class="container text-center">
                    <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">ABOUT</span></p>
                    <h3 class="fw-semibold mb-2">Secure Your Financial Journey</h3>
                    <div class="row justify-content-center">
                        <div class="col-xl-7">
                            <p class="text-muted fs-15 mb-3 fw-normal">Take control of your finances with innovative tools designed to protect and grow your assets, offering clear insights into spending, savings, and financial stability.</p>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center mx-0">
                        <div class="col-xxl-5 col-xl-5 col-lg-5 customize-image text-center">
                            <div class="text-lg-end">
                                <img src="/assets/images/landing-page/1.png" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-6 pt-5 pb-0 px-lg-2 px-5 text-start">

                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="d-flex">
                                        <span>
                                            <i class='bx bxs-badge-check text-primary fs-18'></i>
                                        </span>
                                        <div class="ms-2">
                                            <h6 class="fw-semibold mb-0">Financial Reports</h6>
                                            <p class=" text-muted">Gain full visibility into your financial health with detailed reports. Our comprehensive analysis provides a transparent view of your income, expenses, and savings trends.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="d-flex">
                                        <span>
                                            <i class='bx bxs-badge-check text-primary fs-18'></i>
                                        </span>
                                        <div class="ms-2">
                                            <h6 class="fw-semibold mb-0">Budget Planner</h6>
                                            <p class=" text-muted">Effortlessly monitor your expenditures and identify patterns. Gain deeper insights into your spending habits to make informed decisions for better financial management.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="d-flex">
                                        <span>
                                            <i class='bx bxs-badge-check text-primary fs-18'></i>
                                        </span>
                                        <div class="ms-2">
                                            <h6 class="fw-semibold mb-0">DNS Enumeration</h6>
                                            <p class=" text-muted">Uncover hidden information about your domain with our powerful DNS enumeration tool. Understand the intricacies of your network infrastructure for enhanced security planning.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-3 -->




            <!-- End:: Section-11 -->

            <div class="text-center landing-main-footer py-3 bg-light">
                <span class="text-dark  mb-0">All
                    rights
                    reserved Copyright © <span id="year">2024</span> xBug - Protected with Advanced Security
                </span>

            </div>

        </div>
        <!-- End::app-content -->

    </div>

    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>

    <!-- Popper JS -->
    <script src="assets/libs/@popperjs/core/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Color Picker JS -->
    <script src="assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>

    <!-- Choices JS -->
    <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

    <!-- Swiper JS -->
    <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

    <!-- Defaultmenu JS -->
    <script src="assets/js/defaultmenu.min.js"></script>

    <!-- Internal Landing JS -->
    <script src="assets/js/landing.js"></script>

    <!-- Node Waves JS-->
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- Sticky JS -->
    <script src="assets/js/sticky.js"></script>

</body>

</html>