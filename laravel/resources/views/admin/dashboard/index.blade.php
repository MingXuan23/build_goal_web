@extends('admin.layouts.main')
@section('container')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">Main Dashbaord</h1>
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
            <div class="col-xxl-7 col-xl-12">
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
        <div class="row">
            <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            Jobs Summary
                        </div>
                    </div>
                    <div class="card-body py-4 px-0">
                        <div id="jobs-summary"></div>
                    </div>
                    <div class="card-footer p-4 my-2">
                        <div class="row row-cols-12">
                            <div class="col p-0">
                                <div class="text-center">
                                    <span class="text-muted fs-12 mb-1 hrm-jobs-legend published d-inline-block ms-2">Published
                                    </span>
                                    <div><span class="fs-16 fw-semibold">1,624</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col p-0">
                                <div class="text-center">
                                    <span class="text-muted fs-12 mb-1 hrm-jobs-legend private d-inline-block ms-2">Private
                                    </span>
                                    <div><span class="fs-16 fw-semibold">1,267</span></div>
                                </div>
                            </div>
                            <div class="col p-0">
                                <div class="text-center">
                                    <span class="text-muted fs-12 mb-1 hrm-jobs-legend closed d-inline-block ms-2">Closed
                                    </span>
                                    <div><span class="fs-16 fw-semibold">1,153</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col p-0">
                                <div class="text-center">
                                    <span class="text-muted fs-12 mb-1 hrm-jobs-legend onhold d-inline-block ms-2">On Hold
                                    </span>
                                    <div><span class="fs-16 fw-semibold">1,153</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Upcoming Events</div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled timeline-widget mb-0 my-3">
                            <li class="timeline-widget-list">
                                <div class="d-flex align-items-top">
                                    <div class="me-5 text-center">
                                        <span class="d-block fs-20 fw-semibold text-primary">02</span>
                                        <span class="d-block fs-12 text-muted">Mon</span>
                                    </div>
                                    <div class="d-flex flex-wrap flex-fill align-items-top justify-content-between">
                                        <div>
                                            <p class="mb-1 text-truncate timeline-widget-content text-wrap">You have an announcement - Ipsum Est Diam Eirmod</p>
                                            <p class="mb-0 fs-12 lh-1 text-muted">10:00AM<span class="badge bg-primary-transparent ms-2">Announcement</span></p>
                                        </div>
                                        <div class="dropdown">
                                            <a aria-label="anchor" href="javascript:void(0);" class="p-2 fs-16 text-muted" data-bs-toggle="dropdown">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-widget-list">
                                <div class="d-flex align-items-top">
                                    <div class="me-5 text-center">
                                        <span class="d-block fs-20 fw-semibold text-primary">15</span>
                                        <span class="d-block fs-12 text-muted">Sun</span>
                                    </div>
                                    <div class="d-flex flex-wrap flex-fill align-items-top justify-content-between">
                                        <div>
                                            <p class="mb-1 text-truncate timeline-widget-content text-wrap">National holiday - Vero Jayanti</p>
                                            <p class="mb-0 fs-12 lh-1 text-muted"><span class="badge bg-warning-transparent">Holiday</span></p>
                                        </div>
                                        <div class="dropdown">
                                            <a aria-label="anchor" href="javascript:void(0);" class="p-2 fs-16 text-muted" data-bs-toggle="dropdown">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-widget-list">
                                <div class="d-flex align-items-top">
                                    <div class="me-5 text-center">
                                        <span class="d-block fs-20 fw-semibold text-primary">23</span>
                                        <span class="d-block fs-12 text-muted">Mon</span>
                                    </div>
                                    <div class="d-flex flex-wrap flex-fill align-items-top justify-content-between">
                                        <div>
                                            <p class="mb-1 text-truncate timeline-widget-content text-wrap">John pup birthday - Team Member</p>
                                            <p class="mb-4 fs-12 lh-1 text-muted">09:00AM<span class="badge bg-success-transparent ms-2">Birthday</span></p>
                                            <p class="mb-1 text-truncate timeline-widget-content text-wrap">Amet sed no dolor kasd - Et Dolores Tempor Erat</p>
                                            <p class="mb-0 fs-12 lh-1 text-muted">04:00PM<span class="badge bg-primary-transparent ms-2">Announcement</span></p>
                                        </div>
                                        <div class="dropdown">
                                            <a aria-label="anchor" href="javascript:void(0);" class="p-2 fs-16 text-muted" data-bs-toggle="dropdown">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-widget-list">
                                <div class="d-flex align-items-top">
                                    <div class="me-5 text-center">
                                        <span class="d-block fs-20 fw-semibold text-primary">31</span>
                                        <span class="d-block fs-12 text-muted">Tue</span>
                                    </div>
                                    <div class="d-flex flex-wrap flex-fill align-items-top justify-content-between">
                                        <div>
                                            <p class="mb-1 text-truncate timeline-widget-content text-wrap">National Holiday - Dolore Ipsum</p>
                                            <p class="mb-0 fs-12 lh-1 text-muted"><span class="badge bg-warning-transparent">Holiday</span></p>
                                        </div>
                                        <div class="dropdown">
                                            <a aria-label="anchor" href="javascript:void(0);" class="p-2 fs-16 text-muted" data-bs-toggle="dropdown">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xxl-5 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Clients</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">Client</th>
                                        <th scope="col">Mail</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center lh-1">
                                                <div class="me-3">
                                                    <span class="avatar avatar-rounded">
                                                        <img src="../assets/images/faces/2.jpg" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="d-block fw-semibold mb-1">Diana Aise</span>
                                                    <span class="d-block text-muted fs-12">C.E.O</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td>diana.1116@demo.com</td>
                                        <td><div class="dropdown">
                                            <a href="javascript:void(0);" class="btn btn-outline-light btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                Active<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Active</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Inactive</a></li>
                                            </ul>
                                        </div>
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <button aria-label="button" type="button" class="btn btn-sm btn-primary-light btn-icon"><i class="ri-pencil-line"></i></button>
                                                <button aria-label="button" type="button" class="btn btn-sm btn-success-light btn-icon"><i class="ri-delete-bin-line"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center lh-1">
                                                <div class="me-3">
                                                    <span class="avatar avatar-rounded">
                                                        <img src="../assets/images/faces/8.jpg" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="d-block fw-semibold mb-1">Rose Mary</span>
                                                    <span class="d-block text-muted fs-12">C.E.O</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td>rose756@demo.com</td>
                                        <td><div class="dropdown">
                                            <a href="javascript:void(0);" class="btn btn-outline-light btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                Active<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Active</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Inactive</a></li>
                                            </ul>
                                        </div>
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <button aria-label="button" type="button" class="btn btn-sm btn-primary-light btn-icon"><i class="ri-pencil-line"></i></button>
                                                <button aria-label="button" type="button" class="btn btn-sm btn-success-light btn-icon"><i class="ri-delete-bin-line"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center lh-1">
                                                <div class="me-3">
                                                    <span class="avatar avatar-rounded">
                                                        <img src="../assets/images/faces/13.jpg" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="d-block fw-semibold mb-1">Gretchen Iox</span>
                                                    <span class="d-block text-muted fs-12">Manager</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td>gretchen.1.25@demo.com</td>
                                        <td><div class="dropdown">
                                            <a href="javascript:void(0);" class="btn btn-outline-light btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                Active<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Active</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Inactive</a></li>
                                            </ul>
                                        </div>
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <button aria-label="button" type="button" class="btn btn-sm btn-primary-light btn-icon"><i class="ri-pencil-line"></i></button>
                                                <button aria-label="button" type="button" class="btn btn-sm btn-success-light btn-icon"><i class="ri-delete-bin-line"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center lh-1">
                                                <div class="me-3">
                                                    <span class="avatar avatar-rounded">
                                                        <img src="../assets/images/faces/11.jpg" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="d-block fw-semibold mb-1">Gray Noal</span>
                                                    <span class="d-block text-muted fs-12">Manager</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td>gray12gray@demo.com</td>
                                        <td><div class="dropdown">
                                            <a href="javascript:void(0);" class="btn btn-outline-light btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                Active<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Active</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Inactive</a></li>
                                            </ul>
                                        </div>
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <button aria-label="button" type="button" class="btn btn-sm btn-primary-light btn-icon"><i class="ri-pencil-line"></i></button>
                                                <button aria-label="button" type="button" class="btn btn-sm btn-success-light btn-icon"><i class="ri-delete-bin-line"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="border-bottom-0">
                                            <div class="d-flex align-items-center lh-1">
                                                <div class="me-3">
                                                    <span class="avatar avatar-rounded">
                                                        <img src="../assets/images/faces/5.jpg" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="d-block fw-semibold mb-1">Isa Bella</span>
                                                    <span class="d-block text-muted fs-12">C.E.O</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td class="border-bottom-0">isa158@demo.com</td>
                                        <td class="border-bottom-0"><div class="dropdown">
                                            <a href="javascript:void(0);" class="btn btn-outline-light btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                Active<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Active</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">In Active</a></li>
                                            </ul>
                                        </div>
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="btn-list">
                                                <button aria-label="button" type="button" class="btn btn-sm btn-primary-light btn-icon"><i class="ri-pencil-line"></i></button>
                                                <button aria-label="button" type="button" class="btn btn-sm btn-success-light btn-icon"><i class="ri-delete-bin-line"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->

    </div>
</div>
@endsection