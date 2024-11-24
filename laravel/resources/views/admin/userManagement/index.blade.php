@extends('admin.layouts.main')
@section('container')
    {{-- @dd($datas); --}}
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
            {{-- @dd(Auth::user()); --}}

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
                        <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                            <i class="bi bi-dash-circle-fill fs-4"></i>
                            <div class="ms-3 fw-bold"> {{ session('error') }} </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
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
                                    {{-- <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td><span class="badge bg-danger-transparent">Not Verify</span></td>
                                            <td>
                                                <button class="btn btn-icon btn-sm btn-info-transparent rounded-pill"
                                                    data-bs-toggle="modal" data-bs-target="#modalView-1">
                                                    <i class="ri-eye-line"></i>
                                                </button>
                                                <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill"
                                                    data-bs-toggle="modal" data-bs-target="#modalUpdate-1">
                                                    <i class="ri-edit-line"></i>
                                                </button>

                                                <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill"
                                                    id="alert-confirm-1">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td><span class="badge bg-success-transparent">Verify</span></td>
                                            <td>
                                                <button class="btn btn-icon btn-sm btn-info-transparent rounded-pill"
                                                    data-bs-toggle="modal" data-bs-target="#modalView-2">
                                                    <i class="ri-eye-line"></i>
                                                </button>
                                                <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill"
                                                    data-bs-toggle="modal" data-bs-target="#modalUpdate-2">
                                                    <i class="ri-edit-line"></i>
                                                </button>

                                                <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill"
                                                    id="alert-confirm-2">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </td>
                                        </tr>

                                    </tbody> --}}
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
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        data-bs-dismiss="modal">Close</button>
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
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        data-bs-dismiss="modal">Close</button>
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
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        data-bs-dismiss="modal">Close</button>
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
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        data-bs-dismiss="modal">Close</button>
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
                            'content creator' => 'Content Creator',
                            'mobile-user' => 'Mobile User',
                        ];

                    @endphp
                    <div
                        class="modal-dialog modal-dialog-centered text-center {{ in_array('organization', $roles) ? 'modal-xl' : '' }}">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">View User - {{ $data->name }}</h6><button aria-label="Close"
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
                                                            value="{{ $data->icNo }}">
                                                        <label for="floatingInputprimary">Ic Number</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->name }}">
                                                        <label for="floatingInputprimary">Full Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-floating">
                                                        <input type="email" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->email }}">
                                                        <label for="floatingInputprimary">Email Address</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->telno }}">
                                                        <label for="floatingInputprimary">Phone Number</label>
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
                                                                value="{{ $data->org_name }}">
                                                            <label for="floatingInputprimary">Organization Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control"
                                                                id="floatingInputprimary" placeholder="name@example.com"
                                                                value="{{ $data->org_address }}">
                                                            <label for="floatingInputprimary">Organization Address</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control"
                                                                id="floatingInputprimary" placeholder="name@example.com"
                                                                value="{{ $data->org_state }}">
                                                            <label for="floatingInputprimary">Organization State</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <select class="form-select" id="floatingSelect"
                                                                aria-label="Floating label select example">
                                                                <option value="" disabled
                                                                    {{ $data->org_type == null ? 'selected' : '' }}>-
                                                                    Select -
                                                                </option>
                                                                <option value="1"
                                                                    {{ $data->org_type == 1 ? 'selected' : '' }}>Government
                                                                </option>
                                                                <option value="2"
                                                                    {{ $data->org_type == 2 ? 'selected' : '' }}>Company
                                                                </option>
                                                                <option value="3"
                                                                    {{ $data->org_type == 3 ? 'selected' : '' }}>Skill
                                                                    Training
                                                                    Vendor</option>
                                                                <option value="4"
                                                                    {{ $data->org_type == 4 ? 'selected' : '' }}>NGO
                                                                </option>
                                                                <option value="5"
                                                                    {{ $data->org_type == 5 ? 'selected' : '' }}>Content
                                                                    Creator</option>
                                                                <option value="6"
                                                                    {{ $data->org_type == 6 ? 'selected' : '' }}>Event
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
                                    <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Delete user Record">Delete</button>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            @endforeach

            @foreach ($datas as $data)
                <div class="modal fade" id="modalUpdate-{{ $data->id }}">
                    <div class="modal-dialog modal-dialog-centered text-center modal-xl">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Edit User - {{ $data->name }}</h6><button aria-label="Close"
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
                                                            value="{{ $data->name }}" name="name">
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
                                                            value="{{ $data->telno }}" name="telno">
                                                        <label for="floatingInputprimary">Phone Number</label>
                                                    </div>
                                                </div>

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
                                                            <input type="text" class="form-control"
                                                                id="floatingInputprimary" placeholder="name@example.com"
                                                                value="{{ $data->org_state }}" name="ostate">
                                                            <label for="floatingInputprimary">Organization State</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <select class="form-select" id="floatingSelect"
                                                                aria-label="Floating label select example" name="ostate">
                                                                <option value="" disabled
                                                                    {{ $data->org_type == null ? 'selected' : '' }}>-
                                                                    Select -
                                                                </option>
                                                                <option value="1"
                                                                    {{ $data->org_type == 1 ? 'selected' : '' }}>Government
                                                                </option>
                                                                <option value="2"
                                                                    {{ $data->org_type == 2 ? 'selected' : '' }}>Company
                                                                </option>
                                                                <option value="3"
                                                                    {{ $data->org_type == 3 ? 'selected' : '' }}>Skill
                                                                    Training
                                                                    Vendor</option>
                                                                <option value="4"
                                                                    {{ $data->org_type == 4 ? 'selected' : '' }}>NGO
                                                                </option>
                                                                <option value="5"
                                                                    {{ $data->org_type == 5 ? 'selected' : '' }}>Content
                                                                    Creator</option>
                                                                <option value="6"
                                                                    {{ $data->org_type == 6 ? 'selected' : '' }}>Event
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
                                    <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Delete user Record">Delete</button>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
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
                ajax: "{{ route('viewUser') }}",
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
