@extends('admin.layouts.main')
@section('container')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">Admin Main Dashbaord</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item text-warning"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Main Dashbaord</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->


        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xxl-5 col-xl-12">
                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="card custom-card hrm-main-card primary">
                            <div class="card-body">
                                <div class="d-flex align-items-top">
                                    <div class="me-3">
                                        <span class="avatar bg-primary">
                                            <i class="ri-team-line fs-18"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-semibold text-muted d-block mb-2">Total Employees</span>
                                        <h5 class="fw-semibold mb-2">22,124</h5>
                                        <p class="mb-0">
                                            <span class="badge bg-primary-transparent">This Month</span>
                                        </p>
                                    </div>
                                    <div>
                                        <span class="fs-14 fw-semibold text-success">+1.03%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="card custom-card hrm-main-card secondary">
                            <div class="card-body">
                                <div class="d-flex align-items-top">
                                    <div class="me-3">
                                        <span class="avatar bg-secondary">
                                            <i class="ri-user-unfollow-line fs-18"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-semibold text-muted d-block mb-2">Employees In Leave</span>
                                        <h5 class="fw-semibold mb-2">528</h5>
                                        <p class="mb-0">
                                            <span class="badge bg-secondary-transparent">This Month</span>
                                        </p>
                                    </div>
                                    <div>
                                        <span class="fs-14 fw-semibold text-success">+0.36%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="card custom-card  hrm-main-card warning">
                            <div class="card-body">
                                <div class="d-flex align-items-top">
                                    <div class="me-3">
                                        <span class="avatar bg-warning">
                                            <i class="ri-service-line fs-18"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-semibold text-muted d-block mb-2">Total Clients</span>
                                        <h5 class="fw-semibold mb-2">8,289</h5>
                                        <p class="mb-0">
                                            <span class="badge bg-warning-transparent">This Month</span>
                                        </p>
                                    </div>
                                    <div>
                                        <span class="fs-14 fw-semibold text-danger">-1.28%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="card custom-card  hrm-main-card danger">
                            <div class="card-body">
                                <div class="d-flex align-items-top">
                                    <div class="me-3">
                                        <span class="avatar bg-danger">
                                            <i class="ri-contacts-line fs-18"></i>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-semibold text-muted d-block mb-2">New Leads</span>
                                        <h5 class="fw-semibold mb-2">1,453</h5>
                                        <p class="mb-0">
                                            <span class="badge bg-danger-transparent">This Month</span>
                                        </p>
                                    </div>
                                    <div>
                                        <span class="fs-14 fw-semibold text-success">+4.25%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">Applicants Summary</div>
                            </div>
                            <div class="card-body">
                                <div class="row gy-md-0 gy-3">
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                        <div class="d-flex align-items-top">
                                            <div class="me-3">
                                                <span class="avatar avatar-rounded bg-light text-primary">
                                                    <i class="ti ti-files fs-18"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="d-block mb-1 text-muted">New Applicants</span>
                                                <h6 class="fw-semibold mb-0">2,981</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                        <div class="d-flex align-items-top">
                                            <div class="me-3">
                                                <span class="avatar avatar-rounded bg-light text-secondary">
                                                    <i class="ti ti-file-check fs-18"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="d-block mb-1 text-muted">Selected Candidates</span>
                                                <h6 class="fw-semibold mb-0">2,981</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                        <div class="d-flex align-items-top">
                                            <div class="me-3">
                                                <span class="avatar avatar-rounded bg-light text-warning">
                                                    <i class="ti ti-file-dislike fs-18"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="d-block mb-1 text-muted">Rejected Candidates</span>
                                                <h6 class="fw-semibold mb-0">2,981</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-7 col-xl-12 mt-3">
                <div class="card custom-card">
                    <div class="card-header justify-content-between align-items-center d-sm-flex d-block">
                        <div class="card-title mb-sm-0 mb-2">
                            Performance By Category
                        </div>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary-light btn-sm btn-wave">1W</button>
                            <button type="button" class="btn btn-primary-light btn-sm btn-wave">1M</button>
                            <button type="button" class="btn btn-primary-light btn-sm btn-wave">6M</button>
                            <button type="button" class="btn btn-primary btn-sm btn-wave">1Y</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="performanceReport"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->

        <!-- Start::row-2 -->
    
        <!--End::row-1 -->

    </div>
</div>
@endsection