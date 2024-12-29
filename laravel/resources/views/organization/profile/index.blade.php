@extends('organization.layouts.main')
@section('container')
    {{-- @dd($datas); --}}
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">
            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Profile</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Page Header Close -->
            <!-- Start::row-1 -->
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                    </svg>
                    <div class="ms-3"> {{ session('success') }} </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                    <i class="bi bi-dash-circle-fill fs-4"></i>
                    <div class="ms-3"> {{ session('error') }} </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-body p-0">
                                            <div class="">
                                                <div class="">
                                                    <ul class="nav nav-tabs nav-tabs-header mb-0 d-sm-flex d-block d-flex p-2 align-items-center justify-content-start"
                                                        role="tablist">
                                                        <li class="nav-item m-1">
                                                            <a class="nav-link active" id="your-tab" data-bs-toggle="tab"
                                                                href="#your" role="tab" aria-controls="your"
                                                                aria-selected="true">Personal Details</a>
                                                        </li>
                                                        <li class="nav-item m-1">
                                                            <a class="nav-link " id="organization-tab" data-bs-toggle="tab"
                                                                href="#organization" role="tab"
                                                                aria-controls="organization"
                                                                aria-selected="true">Organization
                                                                Details</a>
                                                        </li>
                                                        <li class="nav-item m-1">
                                                            <a class="nav-link " id="ekyc-tab" data-bs-toggle="tab"
                                                                href="#ekyc" role="tab" aria-controls="ekyc"
                                                                aria-selected="true">e-KYC Detail</a>
                                                        </li>
                                                        <li class="nav-item m-1">
                                                            <a class="nav-link" id="change-password-tab"
                                                                data-bs-toggle="tab" href="#change-password" role="tab"
                                                                aria-controls="change-password" aria-selected="false">Change
                                                                Password</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (Auth::user()->ekyc_status === 0)
                                    <div class="col-md-12 mb-3">
                                        <div class="alert alert-solid-danger alert-dismissible fade show" role="alert">
                                            <i class="bi bi-exclamation-lg"></i>Your account has not been verified because
                                            you have not completed the eKYC process. Go to<span class="fw-bold text-light">
                                                Dashboard</span> to complete your eKYC..
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-12">
                                    <div class="tab-content task-tabs-container">

                                        <div class="tab-pane fade show active" id="your" role="tabpanel"
                                            aria-labelledby="your-tab">

                                            <form action="{{ route('updateProfilePersonalDetailOrganization') }}"
                                                method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card custom-card overflow-hidden">
                                                            <div class="card-body p-0">
                                                                <div
                                                                    class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                                                                    <div>
                                                                        <span
                                                                            class="avatar avatar-xxl avatar-rounded online me-3">
                                                                            <img src="../../assets/images/user/avatar-1.jpg"
                                                                                alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex-fill main-profile-info">
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-between">
                                                                            <h6
                                                                                class="fw-bold mb-1 text-fixed-white mt-3 p-3">
                                                                                {{ $datas[0]->name }}
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="p-4 border-bottom border-block-end-dashed">
                                                                    <span>
                                                                        <div class="col-md-12">
                                                                            <div class="row">
                                                                                <div class="col-md-8">
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="text"
                                                                                            class="form-control @error('icNo') is-invalid @enderror"
                                                                                            id="floatingInput"
                                                                                            placeholder="Ic Number"
                                                                                            value="{{ $datas[0]->icNo }}"
                                                                                            name="icNo" readonly>
                                                                                        <label for="floatingInput">Ic
                                                                                            Number</label>
                                                                                        @error('icNo')
                                                                                            <span
                                                                                                class="mb-1 text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="text"
                                                                                            class="form-control @error('name') is-invalid @enderror"
                                                                                            id="floatingInput"
                                                                                            placeholder="Full Name"
                                                                                            value="{{ $datas[0]->name }}"
                                                                                            name="name" readonly>
                                                                                        <label for="floatingInput">Full
                                                                                            Name</label>
                                                                                        @error('name')
                                                                                            <span
                                                                                                class="mb-1 text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3 mb-3">
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="email"
                                                                                            class="form-control @error('email') is-invalid @enderror"
                                                                                            id="floatingInput"
                                                                                            placeholder="Email Address"
                                                                                            value="{{ $datas[0]->email }}"
                                                                                            name="email">
                                                                                        <label for="floatingInput">Email
                                                                                            address</label>
                                                                                        @error('email')
                                                                                            <span
                                                                                                class="mb-1 text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3 mb-3">
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="number"
                                                                                            class="form-control @error('telno') is-invalid @enderror"
                                                                                            id="floatingInput"
                                                                                            placeholder="Phone Number"
                                                                                            value="{{ $datas[0]->telno }}"
                                                                                            name="telno">
                                                                                        <label for="floatingInput">Phone
                                                                                            Number</label>
                                                                                        @error('telno')
                                                                                            <span
                                                                                                class="mb-1 text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3 mb-3">
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            id="floatingInput"
                                                                                            placeholder="Full Name"
                                                                                            value="{{ $datas[0]->active == 1 ? 'Active' : 'Inactive' }}"
                                                                                            disabled>
                                                                                        <label for="floatingInput">Account
                                                                                            Status</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3 mb-3">
                                                                                    <div class="form-floating mb-3">
                                                                                        @php
                                                                                            // Data peran
                                                                                            $rolesMap = [
                                                                                                1 => 'admin',
                                                                                                2 => 'organization',
                                                                                                3 => 'content creator',
                                                                                                5 => 'mobile user',
                                                                                            ];
                                                                                            $userRoles = is_string(
                                                                                                Auth::user()->role,
                                                                                            )
                                                                                                ? json_decode(
                                                                                                    Auth::user()->role,
                                                                                                    true,
                                                                                                )
                                                                                                : Auth::user()->role;
                                                                                            if (!is_array($userRoles)) {
                                                                                                $userRoles = [];
                                                                                            }
                                                                                            $roleNames = array_map(
                                                                                                fn($role) => $rolesMap[
                                                                                                    $role
                                                                                                ] ?? 'unknown',
                                                                                                $userRoles,
                                                                                            );
                                                                                            $rolesDisplay = implode(
                                                                                                ', ',
                                                                                                $roleNames,
                                                                                            );
                                                                                        @endphp
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            id="floatingInput"
                                                                                            placeholder="Phone Number"
                                                                                            value="{{ $rolesDisplay }}"
                                                                                            disabled readonly>
                                                                                        <label
                                                                                            for="floatingInput">Role</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="row">
                                                                                <div class="col-md-8">
                                                                                </div>
                                                                                <div class="col-md-2 text-end">
                                                                                </div>
                                                                                <div class="text-end col-md-2">
                                                                                    <button type="button"
                                                                                        class="btn btn-success"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#updatePersonalDetailModal">Update</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="updatePersonalDetailModal" tabindex="-1"
                                                    aria-labelledby="exampleModalSmLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title" id="exampleModalLabel1">Update
                                                                    Confirmation
                                                                </h6>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are sure to update your Information?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>

                                        <div class="tab-pane fade" id="organization" role="tabpanel"
                                            aria-labelledby="organization-tab">

                                            <form action="{{ route('updateProfileOrganizationDetail') }}" method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card custom-card overflow-hidden">
                                                            <div class="card-body p-0">
                                                                <div
                                                                    class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                                                                    <div>
                                                                        <span
                                                                            class="avatar avatar-xxl avatar-rounded online me-3">
                                                                            <img src="../../assets/images/user/avatar-1.jpg"
                                                                                alt="">
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex-fill main-profile-info">
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-between">
                                                                            <h6
                                                                                class="fw-bold mb-1 text-fixed-white mt-3 p-3">
                                                                                {{ $datas[0]->name }}
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="p-4 border-bottom border-block-end-dashed">
                                                                    <span>
                                                                        <div class="col-md-12">
                                                                            <div class="row">
                                                                                <div class="col-md-8">
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="text"
                                                                                            class="form-control @error('oname') is-invalid @enderror"
                                                                                            id="floatingInput"
                                                                                            placeholder="Full Name"
                                                                                            value="{{ $datas[0]->org_name }}"
                                                                                            name="oname">
                                                                                        <label
                                                                                            for="floatingInput">Organization
                                                                                            Name</label>
                                                                                        @error('oname')
                                                                                            <span
                                                                                                class="mb-1 text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="text"
                                                                                            class="form-control @error('odesc') is-invalid @enderror"
                                                                                            id="floatingInput"
                                                                                            placeholder="Full Name"
                                                                                            value="{{ $datas[0]->org_desc }}"
                                                                                            name="odesc">
                                                                                        <label
                                                                                            for="floatingInput">Organization
                                                                                            Description</label>
                                                                                        @error('odesc')
                                                                                            <span
                                                                                                class="mb-1 text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="form-floating">
                                                                                        <select
                                                                                            class="form-select @error('ostate') is-invalid @enderror"
                                                                                            id="floatingSelect"
                                                                                            aria-label="Floating label select example"
                                                                                            name="ostate">
                                                                                            <option selected>- Select State
                                                                                                -</option>
                                                                                            @foreach ($states as $state)
                                                                                                <option
                                                                                                    value="{{ $state->name }}"
                                                                                                    @if ($datas[0]->state == $state->name) selected @endif>
                                                                                                    {{ $state->name }}
                                                                                                </option>
                                                                                            @endforeach

                                                                                        </select>
                                                                                        <label
                                                                                            for="floatingSelect">State</label>
                                                                                        @error('ostate')
                                                                                            <span
                                                                                                class="mb-1 text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-8 mb-3">
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="text"
                                                                                            class="form-control @error('oname') is-invalid @enderror"
                                                                                            id="floatingInput"
                                                                                            placeholder="Full Name"
                                                                                            value="{{ $datas[0]->org_address }}"
                                                                                            name="oaddress">
                                                                                        <label
                                                                                            for="floatingInput">Organization
                                                                                            Address</label>
                                                                                        @error('oname')
                                                                                            <span
                                                                                                class="mb-1 text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            id="floatingInput"
                                                                                            placeholder="Full Name"
                                                                                            value="{{ $datas[0]->org_status == 1 ? 'Active' : 'Inactive' }}"
                                                                                            disabled>
                                                                                        <label
                                                                                            for="floatingInput">Organization
                                                                                            Status</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-8 mb-3">
                                                                                    <div class="form-floating">
                                                                                        <select
                                                                                            class="form-select @error('otype') is-invalid @enderror"
                                                                                            id="floatingSelect"
                                                                                            aria-label="Floating label select example"
                                                                                            name="otype">
                                                                                            <option value="" disabled
                                                                                                {{ $datas[0]->org_type == null ? 'selected' : '' }}>
                                                                                                -
                                                                                                Select -
                                                                                            </option>
                                                                                            <option value="1"
                                                                                                {{ $datas[0]->org_type === 'Government' ? 'selected' : '' }}>
                                                                                                Government
                                                                                            </option>
                                                                                            <option value="2"
                                                                                                {{ $datas[0]->org_type === 'Company' ? 'selected' : '' }}>
                                                                                                Company
                                                                                            </option>
                                                                                            <option value="3"
                                                                                                {{ $datas[0]->org_type === 'Skill Training Vendor' ? 'selected' : '' }}>
                                                                                                Skill
                                                                                                Training
                                                                                                Vendor</option>
                                                                                            <option value="4"
                                                                                                {{ $datas[0]->org_type === 'NGO' ? 'selected' : '' }}>
                                                                                                NGO
                                                                                            </option>
                                                                                            <option value="5"
                                                                                                {{ $datas[0]->org_type === 'Content Creator' ? 'selected' : '' }}>
                                                                                                Content
                                                                                                Creator</option>
                                                                                            <option value="6"
                                                                                                {{ $datas[0]->org_type === 'Event Organizer' ? 'selected' : '' }}>
                                                                                                Event
                                                                                                Organizer</option>
                                                                                        </select>
                                                                                        <label
                                                                                            for="floatingSelect">Organization
                                                                                            Type</label>
                                                                                        @error('otype')
                                                                                            <span
                                                                                                class="mb-1 text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="row">
                                                                                <div class="col-md-8">
                                                                                </div>
                                                                                <div class="col-md-2 text-end">
                                                                                </div>
                                                                                <div class="text-end col-md-2">
                                                                                    <button type="button"
                                                                                        class="btn btn-success"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#updateOrganizationModal">Update</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="updateOrganizationModal" tabindex="-1"
                                                    aria-labelledby="exampleModalSmLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title" id="exampleModalLabel1">Update
                                                                    Confirmation
                                                                </h6>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are sure to update your Information?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>

                                        <div class="tab-pane fade" id="ekyc" role="tabpanel"
                                            aria-labelledby="ekyc-tab">
                                            <div class="row" id="tasks-container">
                                                <div class="col-xl-12 task-card">
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-12 ">
                                                            <ul class="list-unstyled mb-0 notification-container">
                                                                <li class="">
                                                                    <div class="card custom-card un-read">
                                                                        <div class="card-body p-3">
                                                                            <a href="javascript:void(0);">
                                                                                <div
                                                                                    class="d-flex align-items-top mt-0 flex-wrap">
                                                                                    <div class="row">
                                                                                        <div class="col-md-1">
                                                                                            <div
                                                                                                class="lh-1 d-flex justify-content-center align-items-center mt-3">
                                                                                                <span
                                                                                                    class="avatar avatar-md online avatar-rounded">
                                                                                                    <img alt="avatar"
                                                                                                        src="../../assets/images/user/avatar-1.jpg">
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-11">
                                                                                            <div class="flex-fill">
                                                                                                <div
                                                                                                    class="d-flex align-items-center">
                                                                                                    <div class="row">
                                                                                                        <div
                                                                                                            class="col-md-12">
                                                                                                            @if (Auth::user()->ekyc_status === 0)
                                                                                                                <div
                                                                                                                    class="mt-sm-0 mt-2">
                                                                                                                    <p
                                                                                                                        class="mb-0 fs-14 fw-semibold">
                                                                                                                        {{ Auth::user()->name }}
                                                                                                                    </p>
                                                                                                                    <p
                                                                                                                        class="mb-0 text-muted">
                                                                                                                        To
                                                                                                                        ensure
                                                                                                                        a
                                                                                                                        secure
                                                                                                                        and
                                                                                                                        seamless
                                                                                                                        experience,
                                                                                                                        we
                                                                                                                        require
                                                                                                                        users
                                                                                                                        to
                                                                                                                        complete
                                                                                                                        eKYC
                                                                                                                        (Electronic
                                                                                                                        Know
                                                                                                                        Your
                                                                                                                        Customer)
                                                                                                                        verification.
                                                                                                                        This
                                                                                                                        process
                                                                                                                        involves
                                                                                                                        a
                                                                                                                        quick
                                                                                                                        and
                                                                                                                        easy
                                                                                                                        upload
                                                                                                                        of
                                                                                                                        your
                                                                                                                        identification
                                                                                                                        documents
                                                                                                                        and
                                                                                                                        facial
                                                                                                                        recognition
                                                                                                                        to
                                                                                                                        verify
                                                                                                                        your
                                                                                                                        identity.
                                                                                                                        Click
                                                                                                                        start
                                                                                                                        button
                                                                                                                        at
                                                                                                                        Dashboard
                                                                                                                        Page
                                                                                                                        to
                                                                                                                        get
                                                                                                                        started
                                                                                                                        and
                                                                                                                        enhance
                                                                                                                        your
                                                                                                                        security.
                                                                                                                    </p>
                                                                                                                    <span
                                                                                                                        class="mb-0 d-block text-muted fs-12 mt-2">
                                                                                                                        <span
                                                                                                                            class="badge bg-danger-transparent fw-semibold fs-12">Pending...</span>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            @else
                                                                                                                <div
                                                                                                                    class="mt-sm-0 mt-2">
                                                                                                                    <p
                                                                                                                        class="mb-0 fs-14 fw-semibold">
                                                                                                                        {{ Auth::user()->name }}
                                                                                                                    </p>
                                                                                                                    <p
                                                                                                                        class="mb-0 text-muted">
                                                                                                                        Congratulations!
                                                                                                                        Your
                                                                                                                        eKYC
                                                                                                                        verification
                                                                                                                        is
                                                                                                                        successfully
                                                                                                                        completed.
                                                                                                                        Your
                                                                                                                        identity
                                                                                                                        has
                                                                                                                        been
                                                                                                                        verified
                                                                                                                        for
                                                                                                                        a
                                                                                                                        secure
                                                                                                                        and
                                                                                                                        seamless
                                                                                                                        experience.
                                                                                                                    </p>
                                                                                                                    <p class="mb-0 mt-1 text-muted text-wrap"
                                                                                                                        style="word-break: break-word;">
                                                                                                                        <span
                                                                                                                            class="fw-bold text-success">eKYC
                                                                                                                            SIGNATURE:
                                                                                                                        </span><span
                                                                                                                            class="text-muted fw-semibold"><br>
                                                                                                                            {!! nl2br(e(Auth::user()->ekyc_signature)) !!}</span>
                                                                                                                    </p>
                                                                                                                    <span
                                                                                                                        class="mb-0 mt-1 d-block text-muted fs-12">
                                                                                                                        <span
                                                                                                                            class="badge bg-success-transparent fw-semibold fs-12">Verified</span>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            @endif
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
                                        </div>

                                        <div class="tab-pane fade" id="change-password" role="tabpanel"
                                            aria-labelledby="change-password-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card custom-card overflow-hidden">
                                                        <div class="card-body p-0">
                                                            <div
                                                                class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                                                                <div>
                                                                    <span
                                                                        class="avatar avatar-xxl avatar-rounded online me-3">
                                                                        <img src="../../assets/images/user/avatar-1.jpg"
                                                                            alt="">
                                                                    </span>
                                                                </div>
                                                                <div class="flex-fill main-profile-info">
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-between">
                                                                        <h6 class="fw-bold mb-1 text-fixed-white mt-3 p-3">
                                                                            {{ Auth::user()->name }}
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="p-4 border-bottom border-block-end-dashed">
                                                                <form action="{{ route('updatePasswordOrganization') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-12 mb-3">
                                                                                <div class="form-floating">
                                                                                    <input type="password"
                                                                                        class="form-control @error('current_password') is-invalid @enderror"
                                                                                        id="floatingPassword"
                                                                                        placeholder="Password"
                                                                                        name="current_password">
                                                                                    <label for="floatingPassword">Current
                                                                                        Password</label>
                                                                                    @error('current_password')
                                                                                        <span
                                                                                            class="mb-1 text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 mb-3">
                                                                                <div class="form-floating">
                                                                                    <input type="password"
                                                                                        class="form-control @error('password') is-invalid @enderror"
                                                                                        id="floatingPassword"
                                                                                        placeholder="Password"
                                                                                        name="password">
                                                                                    <label
                                                                                        for="floatingPassword">Password</label>
                                                                                    @error('password')
                                                                                        <span
                                                                                            class="mb-1 text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 mb-3">
                                                                                <div class="form-floating">
                                                                                    <input type="password"
                                                                                        class="form-control @error('cpassword') is-invalid @enderror"
                                                                                        id="floatingPassword"
                                                                                        placeholder="Password"
                                                                                        name="cpassword">
                                                                                    <label for="floatingPassword">Confirm
                                                                                        Password</label>
                                                                                    @error('cpassword')
                                                                                        <span
                                                                                            class="mb-1 text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-8">
                                                                            </div>
                                                                            <div class="col-md-2 text-end">
                                                                            </div>
                                                                            <div class="text-end col-md-2">
                                                                                <button type="button"
                                                                                    class="btn btn-success"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#changePasswordModal">Change
                                                                                    Password</button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal fade" id="changePasswordModal"
                                                                            tabindex="-1"
                                                                            aria-labelledby="exampleModalSmLabel"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog modal-sm">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h6 class="modal-title"
                                                                                            id="exampleModalLabel1">Update
                                                                                            Confirmation
                                                                                        </h6>
                                                                                        <button type="button"
                                                                                            class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        Are sure to update your information?
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                            class="btn btn-danger"
                                                                                            data-bs-dismiss="modal">Close</button>
                                                                                        <button type="submit"
                                                                                            class="btn btn-success">Confirm</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End::row-1 -->
            </div>
        </div>
    </div>
    <script>
        document.getElementById('startButton').addEventListener('click', function() {
            window.location.href = "/organization/card-verification";
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash;

            if (hash) {
                const tab = document.querySelector(`a[href="${hash}"]`);
                if (tab) {
                    const bootstrapTab = new bootstrap.Tab(tab);
                    bootstrapTab.show();
                }
            }

            const tabLinks = document.querySelectorAll('a[data-bs-toggle="tab"]');
            tabLinks.forEach(tabLink => {
                tabLink.addEventListener('shown.bs.tab', function(event) {
                    history.pushState(null, '', event.target.getAttribute('href'));
                });
            });
        });
    </script>
@endsection
