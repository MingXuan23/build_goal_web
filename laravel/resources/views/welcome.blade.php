@extends('mainLayout')
@section('content')
    <div class="main-content landing-main px-0">

        <!-- Start:: Section-1 -->
        <div class="landing-banner" id="home">
            <section class="section">
                <div class="container main-banner-container pb-lg-0">
                    <div class="row">
                        <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8 mt-5">
                            <div class="py-lg-5">
                                <p class="landing-banner-heading mb-3">Manage Your Financial Future</span></p>
                                <div class="fs-16 mb-3 text-fixed-white op-7">We are dedicated to empowering users
                                    with comprehensive financial management tools, reinforcing our commitment to
                                    making personal finance accessible and efficient. Your trust fuels our drive to
                                    continuously enhance and simplify financial processes, providing a secure,
                                    reliable, and user-friendly experience for all.
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
                        <p class="text-muted fs-15 mb-5 fw-normal">Empower your financial future with our
                            comprehensive tools and intuitive services.</p>
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
                <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">ABOUT</span>
                </p>
                <h3 class="fw-semibold mb-2">Secure Your Financial Journey</h3>
                <div class="row justify-content-center">
                    <div class="col-xl-7">
                        <p class="text-muted fs-15 mb-3 fw-normal">Take control of your finances with innovative
                            tools designed to protect and grow your assets, offering clear insights into spending,
                            savings, and financial stability.</p>
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
                                        <p class=" text-muted">Gain full visibility into your financial health with
                                            detailed reports. Our comprehensive analysis provides a transparent view
                                            of your income, expenses, and savings trends.</p>
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
                                        <p class=" text-muted">Effortlessly monitor your expenditures and identify
                                            patterns. Gain deeper insights into your spending habits to make
                                            informed decisions for better financial management.</p>
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
                                        <p class=" text-muted">Uncover hidden information about your domain with
                                            our powerful DNS enumeration tool. Understand the intricacies of your
                                            network infrastructure for enhanced security planning.</p>
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
@endsection
