@extends('staff.layouts.main')
@section('container')
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
                                <div class="col-md-12">
                                    <div class="tab-content task-tabs-container">
                                        <div class="tab-pane fade show active" id="your" role="tabpanel"
                                            aria-labelledby="your-tab">
                                            <form action="{{ route('updateProfilePersonalDetailStaff') }}" method="post">
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
                                                                                {{ Auth::user()->name }}
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
                                                                                            value="{{ Auth::user()->icNo }}"
                                                                                            name="icNo">
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
                                                                                            class="form-control  @error('name') is-invalid @enderror"
                                                                                            id="floatingInput"
                                                                                            placeholder="Full Name"
                                                                                            value="{{ Auth::user()->name }}"
                                                                                            name="name">
                                                                                        <label for="floatingInput">Full
                                                                                            Name</label>
                                                                                        @error('name')
                                                                                            <span
                                                                                                class="mb-1 text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="email"
                                                                                            class="form-control  @error('email') is-invalid @enderror"
                                                                                            id="floatingInput"
                                                                                            placeholder="Email Address"
                                                                                            value="{{ Auth::user()->email }}"
                                                                                            name="email">
                                                                                        <label for="floatingInput">Email
                                                                                            address</label>
                                                                                        @error('email')
                                                                                            <span
                                                                                                class="mb-1 text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="number"
                                                                                            class="form-control  @error('telno') is-invalid @enderror"
                                                                                            id="floatingInput"
                                                                                            placeholder="Phone Number"
                                                                                            value="{{ Auth::user()->telno }}"
                                                                                            name="telno">
                                                                                        <label for="floatingInput">Phone
                                                                                            Number</label>
                                                                                        @error('telno')
                                                                                            <span
                                                                                                class="mb-1 text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="form-floating mb-3 ">
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            id="floatingInput"
                                                                                            placeholder="Full Name"
                                                                                            value="{{ Auth::user()->active == 1 ? 'Active' : 'Inactive' }}"
                                                                                            disabled>
                                                                                        <label for="floatingInput">Account
                                                                                            Status</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="text"
                                                                                            class="form-control @error('address') is-invalid @enderror"
                                                                                            id="floatingInput"
                                                                                            placeholder="Full Name"
                                                                                            value="{{ $datas[0]->org_address }}"
                                                                                            name="address">
                                                                                        <label
                                                                                            for="floatingInput">Address</label>
                                                                                        @error('address')
                                                                                            <span
                                                                                                class="mb-1 text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="form-floating">
                                                                                        <select
                                                                                            class="form-select @error('state') is-invalid @enderror"
                                                                                            id="floatingSelect"
                                                                                            aria-label="Floating label select example"
                                                                                            name="state">
                                                                                            <option value=""
                                                                                                selected>- Select State -
                                                                                            </option>
                                                                                            <option value="pahang"
                                                                                                @selected($datas[0]->org_state == 'pahang')>
                                                                                                Pahang
                                                                                            </option>
                                                                                            <option value="perak"
                                                                                                @selected($datas[0]->org_state == 'perak')>
                                                                                                Perak
                                                                                            </option>
                                                                                            <option value="terengganu"
                                                                                                @selected($datas[0]->org_state == 'terengganu')>
                                                                                                Terengganu</option>
                                                                                            <option value="perlis"
                                                                                                @selected($datas[0]->org_state == 'perlis')>
                                                                                                Perlis
                                                                                            </option>
                                                                                            <option value="selangor"
                                                                                                @selected($datas[0]->org_state == 'selangor')>
                                                                                                Selangor</option>
                                                                                            <option value="negeri_sembilan"
                                                                                                @selected($datas[0]->org_state == 'negeri_sembilan')>
                                                                                                Negeri Sembilan</option>
                                                                                            <option value="johor"
                                                                                                @selected($datas[0]->org_state == 'johor')>
                                                                                                Johor
                                                                                            </option>
                                                                                            <option value="kelantan"
                                                                                                @selected($datas[0]->org_state == 'kelantan')>
                                                                                                Kelantan</option>
                                                                                            <option value="kedah"
                                                                                                @selected($datas[0]->org_state == 'kedah')>
                                                                                                Kedah
                                                                                            </option>
                                                                                            <option value="pulau_pinang"
                                                                                                @selected($datas[0]->org_state == 'pulau_pinang')>
                                                                                                Pulau Pinang</option>
                                                                                            <option value="melaka"
                                                                                                @selected($datas[0]->org_state == 'melaka')>
                                                                                                Melaka
                                                                                            </option>
                                                                                            <option value="sabah"
                                                                                                @selected($datas[0]->org_state == 'sabah')>
                                                                                                Sabah
                                                                                            </option>
                                                                                            <option value="sarawak"
                                                                                                @selected($datas[0]->org_state == 'sarawak')>
                                                                                                Sarawak</option>
                                                                                        </select>
                                                                                        <label
                                                                                            for="floatingSelect">State</label>
                                                                                        @error('state')
                                                                                            <span
                                                                                                class="mb-1 text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="form-floating mb-3">
                                                                                        @php
                                                                                            // Data peran
                                                                                            $rolesMap = [
                                                                                                1 => 'admin',
                                                                                                2 => 'staff',
                                                                                                3 => 'organization',
                                                                                                4 => 'content creator',
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
                                                                                        data-bs-target="#updateModal">Update</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="updateModal" tabindex="-1"
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
                                                                <form action="{{ route('updatePasswordStaff') }}"
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
