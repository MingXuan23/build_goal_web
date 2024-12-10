@extends('admin.layouts.main')
@section('container')

    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">
            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">User Management</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Management</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Page Header Close -->


            <!-- Start::row-1 -->
            <div class="row">
                <div class="col-xl-12">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill fs-4"></i>
                            </svg>
                            <div class="ms-3 fw-bold"> {{ session('success') }} </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        @php
                            $errors = is_array(session('error')) ? session('error') : [session('error')];
                        @endphp

                        @foreach ($errors as $error)
                            <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                                <i class="bi bi-dash-circle-fill fs-4"></i>
                                <div class="ms-3 fw-bold"> {{ $error }} </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endforeach
                    @endif


                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">List All User </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-bordered table-hover text-nowrap w-100 data-table">
                                    <thead>

                                        <tr>
                                            <th>No.</th>
                                            <th>Ic No</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>e-kyc Status</th>
                                            <th>Account Status</th>
                                            {{-- <th>Organization Name</th> --}}
                                            <th>Email Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End::row-1 -->
            @foreach ($datas as $data)
                <div class="modal fade" id="modalRoleNames-{{ $data->id }}" tabindex="-1"
                    aria-labelledby="modalRoleNamesLabel-{{ $data->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Change Role - {{ $data->name }}</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form action="{{ route('updateRole', $data->id) }}" method="POST">
                                @csrf
                                <div class="modal-body text-start">
                                    <div class="col-sm-12">
                                        <h5 class="mb-3 fw-bold">Select Roles</h5>
                                        <!-- Checkbox untuk Role -->
                                        @foreach ($roles as $role)
                                            <div class="form-check mb-2 form-check-lg">
                                                <input class="form-check-input" type="checkbox" name="roles[]"
                                                    value="{{ $role->id }}" id="{{ $role->role }}-{{ $data->id }}"
                                                    @if (in_array($role->role, explode(',', $data->role_names))) checked @endif>
                                                <label class="form-check-label"
                                                    for="{{ $role->role }}-{{ $data->id }}">
                                                    {{ ucfirst(str_replace('_', ' ', $role->role)) }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary ">Update</button>
                                    <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach


            @foreach ($datas as $data)
                <div class="modal fade" id="modalEkyc-{{ $data->id }}">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Update e-kyc Status - {{ $data->name }}</h6><button
                                    aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('updateEkycStatus', $data->id) }}" method="POST">
                                @csrf
                                <div class="modal-body text-start">

                                    <div class="col-sm-12">
                                        <div class="form-floating">
                                            <select class="form-select" id="floatingSelect"
                                                aria-label="Floating label select example" name="status" required>
                                                <option value="1" @if ($data->ekyc_status == 1) selected @endif>
                                                    VERIFY</option>
                                                <option value="0" @if ($data->ekyc_status == 0) selected @endif>NOT
                                                    VERIFY</option>
                                            </select>
                                            <label for="floatingSelect">e-kyc Status</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary ">Update</button>
                                    <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            @endforeach

            @foreach ($datas as $data)
                <div class="modal fade" id="modalActive-{{ $data->id }}">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Update Account Status - {{ $data->name }}</h6><button
                                    aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('updateAccountStatus', $data->id) }}" method="POST">
                                @csrf
                                <div class="modal-body text-start">

                                    <div class="col-sm-12">
                                        <div class="form-floating">
                                            <select class="form-select" id="floatingSelect"
                                                aria-label="Floating label select example" name="status" required>
                                                <option value="1" @if ($data->active == 1) selected @endif>
                                                    ACTIVE</option>
                                                <option value="0" @if ($data->active == 0) selected @endif>
                                                    DISABLE</option>
                                            </select>
                                            <label for="floatingSelect">Account Status</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary ">Update</button>
                                    <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            @endforeach

            @foreach ($datas as $data)
                <div class="modal fade" id="modalEmailStatus-{{ $data->id }}">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Update Email Status - {{ $data->name }}</h6><button
                                    aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('updateEmailStatus', $data->id) }}" method="POST">
                                @csrf
                                <div class="modal-body text-start">

                                    <div class="col-sm-12">
                                        <div class="form-floating">
                                            <select class="form-select" id="floatingSelect"
                                                aria-label="Floating label select example" name="status" required>
                                                <option value="1" @if ($data->email_status == 'VERIFY') selected @endif>
                                                    VERIFY</option>
                                                <option value="0" @if ($data->email_status == 'NOT VERIFY') selected @endif>
                                                    NOT VERIFY</option>
                                            </select>
                                            <label for="floatingSelect">Email Status</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            @endforeach

            @foreach ($datas as $data)
                <div class="modal fade" id="modalView-{{ $data->id }}">
                    @php

                        $roles = explode(',', $data->role_names);
                        $availableRoles = [
                            'admin' => 'Admin',
                            'staff' => 'Staff',
                            'organization' => 'Organization',
                            'content-creator' => 'Content Creator',
                            'mobile-user' => 'Mobile User',
                        ];

                    @endphp
                    <div
                        class="modal-dialog modal-dialog-centered text-center {{ in_array('organization', $roles) ? 'modal-xl' : '' }}">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">View User - {{ $data->name }} ( {{ $data->role_names }} )</h6>
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('updateUser', $data->id) }}" method="POST">
                                @csrf
                                <div class="modal-body text-start">

                                    <div class="row p-2">
                                        <div class="col-md-{{ in_array('organization', $roles) ? '6' : '12' }}">
                                            <p class="fw-semibold mt-2">Personal Details</p>
                                            <hr>
                                            <div class="row gy-2">

                                                <div class="col-xl-12">
                                                    <div class="form-floating">
                                                        <input disabled type="number" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->icNo }}">
                                                        <label for="floatingInputprimary">Ic Number</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-floating">
                                                        <input disabled type="text" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->name }}">
                                                        <label for="floatingInputprimary">Full Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-floating">
                                                        <input disabled type="email" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->email }}">
                                                        <label for="floatingInputprimary">Email Address</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="form-floating">
                                                        <input disabled type="number" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->telno }}">
                                                        <label for="floatingInputprimary">Phone Number</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="form-floating">
                                                        <input disabled type="text" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ strtoupper($data->role_names) }}">
                                                        <label for="floatingInputprimary">Role</label>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>


                                        @if (in_array('admin', $roles))
                                            {{-- <div class="col-md-6">
                                                <p class="fw-bold mt-2">This user role in {{ $availableRoles['admin'] }}
                                                </p>
                                            </div> --}}
                                        @endif

                                        @if (in_array('staff', $roles))
                                            {{-- <div class="col-md-6">
                                                <p class="fw-bold mt-2">This user role in {{ $availableRoles['staff'] }}
                                                </p>
                                            </div> --}}
                                        @endif

                                        @if (in_array('organization', $roles))
                                            <div class="col-md-6">
                                                <p class="fw-semibold mt-2">Organization Details</p>
                                                <hr>
                                                <div class="row gy-2">

                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <input disabled type="text" class="form-control"
                                                                id="floatingInputprimary" placeholder="name@example.com"
                                                                value="{{ $data->org_name }}">
                                                            <label for="floatingInputprimary">Organization Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <input disabled type="text" class="form-control"
                                                                id="floatingInputprimary" placeholder="name@example.com"
                                                                value="{{ $data->org_address }}">
                                                            <label for="floatingInputprimary">Organization Address</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <select disabled class="form-select" id="floatingSelect"
                                                                aria-label="Floating label select example" name="ostate">
                                                                <option selected>- Select State -</option>
                                                                @foreach ($states as $state)
                                                                    <option value="{{ $state->name }}"
                                                                        @selected(old('ostate', $data->org_state) == $state->name)>
                                                                        {{ $state->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <label for="floatingSelect">State</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <select class="form-select" disabled id="floatingSelect"
                                                                aria-label="Floating label select example" name="otype">
                                                                <option value="" disabled
                                                                    {{ $data->org_type == null ? 'selected' : '' }}>-
                                                                    Select -
                                                                </option>
                                                                <option value="1"
                                                                    {{ $data->org_type === 'Government' ? 'selected' : '' }}>
                                                                    Government
                                                                </option>
                                                                <option value="2"
                                                                    {{ $data->org_type === 'Company' ? 'selected' : '' }}>
                                                                    Company
                                                                </option>
                                                                <option value="3"
                                                                    {{ $data->org_type === 'Skill Training Vendor' ? 'selected' : '' }}>
                                                                    Skill
                                                                    Training
                                                                    Vendor</option>
                                                                <option value="4"
                                                                    {{ $data->org_type === 'NGO' ? 'selected' : '' }}>NGO
                                                                </option>
                                                                <option value="5"
                                                                    {{ $data->org_type === 'Content Creator' ? 'selected' : '' }}>
                                                                    Content
                                                                    Creator</option>
                                                                <option value="6"
                                                                    {{ $data->org_type === 'Event Organizer' ? 'selected' : '' }}>
                                                                    Event
                                                                    Organizer</option>
                                                            </select>
                                                            <label for="floatingSelect">Organization Type</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if (in_array('content-creator', $roles) && !in_array('organization', $roles))
                                            <div class="col-xl-12 mt-2">
                                                <div class="form-floating">
                                                    <input disabled type="text" class="form-control"
                                                        id="floatingInputprimary" placeholder="name@example.com"
                                                        value="{{ $data->org_address }}" name="oaddress">
                                                    <label for="floatingInputprimary">Address</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 mt-2">
                                                <div class="form-floating">
                                                    <div class="form-floating">
                                                        <select disabled class="form-select " id="floatingSelect"
                                                            aria-label="Floating label select example" name="ostate">
                                                            <option selected>- Select State -</option>
                                                            @foreach ($states as $state)
                                                                <option value="{{ $state->name }}"
                                                                    @selected(old('ostate', $data->org_state) == $state->name)>
                                                                    {{ $state->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <label for="floatingSelect">State</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if (in_array('mobile-user', $roles))
                                            {{-- <div class="col-md-6">
                                                <p class="fw-bold mt-2">This user role in
                                                    {{ $availableRoles['mobile-user'] }}</p>
                                            </div> --}}
                                        @endif


                                    </div>

                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $data->id }}">
                                        Delete
                                    </button>
                                    <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>



                        </div>
                    </div>
                </div>
            @endforeach

            @foreach ($datas as $data)
                @php

                    $roles = explode(',', $data->role_names);

                @endphp
                <div class="modal fade" id="modalUpdate-{{ $data->id }}">
                    <div
                        class="modal-dialog modal-dialog-centered text-center {{ in_array('organization', $roles) ? 'modal-xl' : '' }}">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Edit User- {{ $data->name }}</h6><button aria-label="Close"
                                    class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('updateUser', $data->id) }}" method="POST">
                                @csrf
                                <div class="modal-body text-start">

                                    <div class="row p-2">
                                        <div class="col-md-{{ in_array('organization', $roles) ? '6' : '12' }}">
                                            <p class="fw-semibold mt-2">Personal Details</p>
                                            <hr>
                                            <div class="row gy-2">

                                                <div class="col-xl-12">
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->icNo }}" name="icno">
                                                        <label for="floatingInputprimary">Ic Number</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->name }}" name="fullname">
                                                        <label for="floatingInputprimary">Full Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-floating">
                                                        <input type="email" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->email }}" name="email">
                                                        <label for="floatingInputprimary">Email Address</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->telno }}" name="phoneno">
                                                        <label for="floatingInputprimary">Phone Number</label>
                                                    </div>
                                                </div>
                                                @if (!in_array('organization', $roles))
                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control"
                                                                id="floatingInputprimary" placeholder="name@example.com"
                                                                value="{{ $data->org_address }}" name="oaddress">
                                                            <label for="floatingInputprimary">Address</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <select class="form-select" id="floatingSelect"
                                                                aria-label="Floating label select example" name="ostate">

                                                                @foreach ($states as $state)
                                                                    <option value="{{ $state->name }}"
                                                                        @selected(old('ostate', $data->org_state) == $state->name)>
                                                                        {{ $state->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            <label for="floatingSelect">State</label>

                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-xl-12">
                                                    <div class="form-floating">
                                                        <input type="password" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="" name="password">
                                                        <label for="floatingInputprimary">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="form-floating">
                                                        <input type="password" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="" name="cpassword">
                                                        <label for="floatingInputprimary">Confirm Password</label>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>


                                        @if (in_array('admin', $roles))
                                            {{-- <div class="col-md-6">
                                                <p class="fw-bold mt-2">This user role in {{ $availableRoles['admin'] }}
                                                </p>
                                            </div> --}}
                                        @endif

                                        @if (in_array('staff', $roles))
                                            {{-- <div class="col-md-6">
                                                <p class="fw-bold mt-2">This user role in {{ $availableRoles['staff'] }}
                                                </p>
                                            </div> --}}
                                        @endif

                                        @if (in_array('organization', $roles))
                                            <div class="col-md-6">
                                                <p class="fw-semibold mt-2">Organization Details</p>
                                                <hr>
                                                <div class="row gy-2">

                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control"
                                                                id="floatingInputprimary" placeholder="name@example.com"
                                                                value="{{ $data->org_name }}" name="oname">
                                                            <label for="floatingInputprimary">Organization Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control"
                                                                id="floatingInputprimary" placeholder="name@example.com"
                                                                value="{{ $data->org_address }}" name="oaddress">
                                                            <label for="floatingInputprimary">Organization Address</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <select class="form-select " id="floatingSelect"
                                                                aria-label="Floating label select example" name="ostate">

                                                                @foreach ($states as $state)
                                                                    <option value="{{ $state->name }}"
                                                                        @selected(old('ostate', $data->org_state) == $state->name)>
                                                                        {{ $state->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            <label for="floatingSelect">State</label>

                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <select class="form-select" id="floatingSelect"
                                                                aria-label="Floating label select example" name="otype">

                                                                <option value="1"
                                                                    {{ $data->org_type === 'Government' ? 'selected' : '' }}>
                                                                    Government
                                                                </option>
                                                                <option value="2"
                                                                    {{ $data->org_type === 'Company' ? 'selected' : '' }}>
                                                                    Company
                                                                </option>
                                                                <option value="3"
                                                                    {{ $data->org_type === 'Skill Training Vendor' ? 'selected' : '' }}>
                                                                    Skill
                                                                    Training
                                                                    Vendor</option>
                                                                <option value="4"
                                                                    {{ $data->org_type === 'NGO' ? 'selected' : '' }}>NGO
                                                                </option>
                                                                <option value="5"
                                                                    {{ $data->org_type === 'Content Creator' ? 'selected' : '' }}>
                                                                    Content
                                                                    Creator</option>
                                                                <option value="6"
                                                                    {{ $data->org_type === 'Event Organizer' ? 'selected' : '' }}>
                                                                    Event
                                                                    Organizer</option>
                                                            </select>
                                                            <label for="floatingSelect">Organization Type</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if (in_array('content creator', $roles))
                                            {{-- <div class="col-md-6">
                                                <p class="fw-bold mt-2">This user role in
                                                    {{ $availableRoles['content creator'] }}</p>
                                            </div> --}}
                                        @endif

                                        @if (in_array('mobile-user', $roles))
                                            {{-- <div class="col-md-6">
                                                <p class="fw-bold mt-2">This user role in
                                                    {{ $availableRoles['mobile-user'] }}</p>
                                            </div> --}}
                                        @endif


                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary " data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Delete user Record">Update</button>
                                    <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            @endforeach

            @foreach ($datas as $data)
                <form action="{{ route('userDeleteAdmin', $data->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal fade" id="delete{{ $data->id }}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="deleteLabel">Delete Confirmation
                                    </h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="fw-bold text-muted">Are Sure to Delete Account for {{ $data->name }} with
                                        role {{ $data->role_names }} ? This action can't be undo !</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Confirm</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endforeach

        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: "{{ route('showUserAdmin') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'icNo',
                        name: 'icno',
                        // visible:false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: ((data, type, row) => {
                            return data.toUpperCase();
                        })

                    },
                    {
                        data: 'role_names',
                        name: 'role_names',

                    },
                    {
                        data: 'ekyc_status',
                        name: 'ekyc_status',

                    },
                    {
                        data: 'active',
                        name: 'active',

                    },
                    {
                        data: 'email_status',
                        name: 'email_status',
                    },
                    {
                        data: 'action',
                        name: 'action',
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: 'Copy Data',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'Export CSV',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Export Excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'Export PDF',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print Data',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            });
        })
    </script>
@endsection


{{-- <div class="d-flex justify-content-between"><span class="badge bg-' . $statusClass . '-transparent p-2 me-1">' .
        $messageActive . '</span><button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill "
        data-bs-toggle="modal" data-bs-target="#modalEkyc-' . $row->id . '">
        <i class="ri-edit-line"></i>
    </button>
</div> --}}
