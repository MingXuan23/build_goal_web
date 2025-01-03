@extends('admin.layouts.main')
@section('container')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">
            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Add New User Admin</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New User</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Page Header Close -->

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
                    <div class="ms-3"> {!! session('error') !!} </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- Start::row-1 -->
            <form action="{{ route('addUserAdmin') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between m-0 col-md-12">
                            <div class="card-title col-md-12">
                                Add New User Admin
                            </div>
                        </div>
                        <div class="card-body col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="fw-semibold mt-2">Personal Details</p>
                                    <hr>
                                    <div class="row gy-2">
                                        <div class="col-xl-6">
                                            <div class="form-floating">
                                                <input type="number" class="form-control @error('icNo') is-invalid @enderror"
                                                    id="floatingInputprimary" placeholder="name@example.com" name="icNo"
                                                    value="{{ old('icNo') }}">
                                                <label for="floatingInputprimary">Ic Number</label>
                                                @error('icNo')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-floating">
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    id="floatingInputprimary" placeholder="name@example.com" name="name"
                                                    value="{{ old('name') }}">
                                                <label for="floatingInputprimary">Full Name</label>
                                                @error('name')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-floating">
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="floatingInputprimary" placeholder="name@example.com" name="email"
                                                    value="{{ old('email') }}">
                                                <label for="floatingInputprimary">Email Address</label>
                                                @error('email')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-floating">
                                                <input type="number"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    id="floatingInputprimary" placeholder="name@example.com" name="phone"
                                                    value="{{ old('phone') }}">
                                                <label for="floatingInputprimary">Phone Number</label>
                                                @error('phone')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="form-floating">
                                                <input type="text"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    id="floatingInputprimary" placeholder="name@example.com" name="address"
                                                    value="{{ old('address') }}">
                                                <label for="floatingInputprimary">Address</label>
                                                @error('address')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="form-floating">
                                                <select class="form-select @error('state') is-invalid @enderror"
                                                    id="floatingSelect" aria-label="Floating label select example"
                                                    name="state">
                                                    <option selected>- Select State -</option>
                                                    @foreach ($states as $state)
                                                        <option value="{{ $state->name }}" @selected(old('state') == $state->name)>
                                                            {{ $state->name }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="floatingSelect">State</label>
                                                @error('state')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-xl-12">
                                            <div class="form-floating">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="floatingInputprimary" placeholder="name@example.com"
                                                    name="password">
                                                <label for="floatingInputprimary">Password</label>
                                                @error('password')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="form-floating">
                                                <input type="password"
                                                    class="form-control @error('cpassword') is-invalid @enderror"
                                                    id="floatingInputprimary" placeholder="name@example.com"
                                                    name="cpassword">
                                                <label for="floatingInputprimary">Confirm Password</label>
                                                @error('cpassword')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
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
                                        <div class="col-md-2 text-end">
                                            <button type="submit" class="btn btn-success mt-5 px-4" name="AddAdmin">Add
                                                New Admin</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--End::row-1 -->
        </div>
    </div>
@endsection
