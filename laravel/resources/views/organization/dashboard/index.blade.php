@extends('organization.layouts.main')
@section('container')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">
            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Organization Main Dashboard</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Main Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Page Header Close -->
            <!-- Start::row-1 -->
            @if (session()->has('errorEkyc'))
                <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                    <i class="bi bi-dash-circle-fill fs-4"></i>
                    <div class="ms-3"> {{ session('errorEkyc') }} </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (Auth::user()->ekyc_status === 0)
                <div class="row" id="tasks-container">
                    <div class="col-xl-12 task-card">
                        <div class="row justify-content-center">
                            <div class="col-md-12 ">
                                <ul class="list-unstyled mb-0 notification-container">
                                    <li>
                                        <div class="card custom-card un-read">
                                            <div class="card-body p-3">
                                                <a href="javascript:void(0);">
                                                    <div class="d-flex align-items-top mt-0 flex-wrap">
                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                <div
                                                                    class="lh-1 d-flex justify-content-center align-items-center mt-3">
                                                                    <span class="avatar avatar-md online avatar-rounded">
                                                                        <img alt="avatar"
                                                                            src="../../assets/images/user/avatar-1.jpg">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-11">
                                                                <div class="flex-fill">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="row">
                                                                            <div class="col-md-10">
                                                                                <div class="mt-sm-0 mt-2">
                                                                                    <p class="mb-0 fs-14 fw-semibold">
                                                                                        {{ Auth::user()->name }}</p>
                                                                                    <p class="mb-0 text-muted">Before you
                                                                                        continue, we
                                                                                        require users to complete eKYC
                                                                                        (Electronic Know Your Customer)
                                                                                        verification. This process involves
                                                                                        a
                                                                                        quick and easy upload of your
                                                                                        identification documents and facial
                                                                                        recognition to verify your identity.
                                                                                        This is for ensure a
                                                                                        secure and seamless experience in
                                                                                        our system.
                                                                                        Click start button to get started
                                                                                        and
                                                                                        enhance your security.</p>
                                                                                    <span
                                                                                        class="mb-0 d-block text-muted fs-12 mt-1"><span
                                                                                            class="badge bg-danger-transparent fw-bold fs-12">Pending...</span></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="text-end col-md-2">
                                                                                <div class="ms-auto mt-4">
                                                                                    <button type="button"
                                                                                        class="btn btn-success btn-wave">Start</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">Content Summary</div>
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
                                                <span class="d-block mb-1 text-muted">Contents Proposed</span>
                                                <h6 class="fw-semibold mb-0">4</h6>
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
                                                <span class="d-block mb-1 text-muted">Approved Contents</span>
                                                <h6 class="fw-semibold mb-0 text-info">4</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                        <div class="d-flex align-items-top">
                                            <div class="me-3">
                                                <span class="avatar avatar-rounded bg-light text-danger">
                                                    <i class="ti ti-file-dislike fs-18"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="d-block mb-1 text-muted">Rejected Contents</span>
                                                <h6 class="fw-semibold mb-0 text-danger">0</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">

                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">Approved Content</div>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-nowrap">
                                    <thead class="table-borderless">
                                        <tr>
                                            <th scope="col">Content ID</th>
                                            <th scope="col">Content Name</th>
                                            <th scope="col">Approved</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Harshrath</th>
                                            <td>#5182-3467</td>
                                            <td>24 May 2022</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary-light">Promote</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Zozo Hadid</th>
                                            <td>#5182-3412</td>
                                            <td>02 July 2022</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary-light">Promote</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Martiana</th>
                                            <td>#5182-3423</td>
                                            <td>15 April 2022</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary-light">Promote</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Alex Carey</th>
                                            <td>#5182-3456</td>
                                            <td>17 March 2022</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary-light">Promote</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            @endif
            <!--End::row-1 -->
        </div>
    </div>
@endsection
