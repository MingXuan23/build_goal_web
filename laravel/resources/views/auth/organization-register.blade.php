<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="color" data-header-styles="light"
    data-menu-styles="color" data-toggled="close" style="--primary-rgb: 17,28,67;">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> xBug | Register </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- Favicon -->
    <link rel="icon" href="assets/images/brand-logos/favicon.ico" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="assets/js/authentication-main.js"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Style Css -->
    <link href="assets/css/styles.min.css" rel="stylesheet">

    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>

    </style>

</head>

<body>

    <!-- Start Switcher -->

    <!-- End Switcher -->

    <div class="container mt-3">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-md-8">

                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                        <i class="bi bi-dash-circle-fill fs-4"></i>
                        <div class="ms-3"> {{ session('error') }} </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card custom-card">
                    <div class="card-body">

                        <div class="p-3">
                            <p class="h5 fw-bold mb-2">Sign Up for Organization</p>
                            <p class="mb-4 text-muted op-7 fw-normal ">Welcome & Join us by creating a free account
                                !</p>
                            <div class="mb-3">
                                {{-- <a href="index.html">
                                        <img src="../../assets/images/brand-logos/desktop-logo.png" alt="" class="authentication-brand desktop-logo">
                                        <img src="../../assets/images/brand-logos/desktop-dark.png" alt="" class="authentication-brand desktop-dark">
                                    </a> --}}
                            </div>
                            <form action="{{ route('createOrganizationRegister') }}" method="post">
                                @csrf
                                <div class="row">

                                    <div class="col-md-6">
                                        <p class="fw-semibold mt-2">Personal Details</p>
                                        <hr>
                                        <div class="row gy-2">
                                            <div class="col-xl-12">
                                                <div class="form-floating">
                                                    <input type="number"
                                                        class="form-control @error('icno') is-invalid @enderror"
                                                        id="floatingInputprimary" placeholder="name@example.com"
                                                        name="icno" value="{{ old('icno') }}">
                                                    <label for="floatingInputprimary">Ic Number</label>
                                                    @error('icno')
                                                        <span class="mb-1 text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-floating">
                                                    <input type="text"
                                                        class="form-control @error('fullname') is-invalid @enderror"
                                                        id="floatingInputprimary" placeholder="name@example.com"
                                                        name="fullname" value="{{ old('fullname') }}">
                                                    <label for="floatingInputprimary">Full Name</label>
                                                    @error('fullname')
                                                        <span class="mb-1 text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-floating">
                                                    <input type="number"
                                                        class="form-control @error('phoneno') is-invalid @enderror"
                                                        id="floatingInputprimary" placeholder="name@example.com"
                                                        name="phoneno" value="{{ old('phoneno') }}">
                                                    <label for="floatingInputprimary">Phone Number</label>
                                                    @error('phoneno')
                                                        <span class="mb-1 text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <div class="form-floating">
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror @error('cpassword') is-invalid @enderror"
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
                                    <div class="col-md-6">
                                        <p class="fw-semibold mt-2">Organization Details</p>
                                        <hr>
                                        <div class="row gy-2">

                                            <div class="col-xl-12">
                                                <div class="form-floating">
                                                    <input type="text"
                                                        class="form-control @error('oname') is-invalid @enderror"
                                                        id="floatingInputprimary" placeholder="name@example.com"
                                                        name="oname" value="{{ old('oname') }}">
                                                    <label for="floatingInputprimary">Organization Name</label>
                                                    @error('oname')
                                                        <span class="mb-1 text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-floating">
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="floatingInputprimary" placeholder="name@example.com"
                                                        name="email" value="{{ old('email') }}">
                                                    <label for="floatingInputprimary">Organization Email Address</label>
                                                    @error('email')
                                                        <span class="mb-1 text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-floating">
                                                    <input type="text"
                                                        class="form-control @error('oaddress') is-invalid @enderror"
                                                        id="floatingInputprimary" placeholder="name@example.com"
                                                        name="oaddress" value="{{ old('oaddress') }}">
                                                    <label for="floatingInputprimary">Organization Address</label>
                                                    @error('oaddress')
                                                        <span class="mb-1 text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-floating">
                                                    <select class="form-select @error('ostate') is-invalid @enderror" 
                                                        id="floatingSelect" 
                                                        aria-label="Floating label select example" 
                                                        name="ostate">
                                                        <option selected>- Select State -</option>
                                                        <option value="pahang" @selected(old('ostate') == 'pahang')>Pahang</option>
                                                        <option value="perak" @selected(old('ostate') == 'perak')>Perak</option>
                                                        <option value="terengganu" @selected(old('ostate') == 'terengganu')>Terangganu</option>
                                                        <option value="perlis" @selected(old('ostate') == 'perlis')>Perlis</option>
                                                        <option value="selangor" @selected(old('ostate') == 'selangor')>Selangor</option>
                                                        <option value="negeri_sembilan" @selected(old('ostate') == 'negeri_sembilan')>Negeri Sembilan</option>
                                                        <option value="johor" @selected(old('ostate') == 'johor')>Johor</option>
                                                        <option value="kelantan" @selected(old('ostate') == 'kelantan')>Kelantan</option>
                                                        <option value="kedah" @selected(old('ostate') == 'kedah')>Kedah</option>
                                                        <option value="pulau_pinang" @selected(old('ostate') == 'pulau_pinang')>Pulau Pinang</option>
                                                        <option value="melaka" @selected(old('ostate') == 'melaka')>Melaka</option>
                                                        <option value="sabah" @selected(old('ostate') == 'sabah')>Sabah</option>
                                                        <option value="sarawak" @selected(old('ostate') == 'sarawak')>Sarawak</option>
                                                    </select>
                                                    <label for="floatingSelect">State</label>
                                                    @error('ostate')
                                                        <span class="mb-1 text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-floating">
                                                    <select class="form-select @error('otype') is-invalid @enderror"
                                                        id="floatingSelect" aria-label="Floating label select example"
                                                        name="otype">
                                                        <option selected>- Select -</option>
                                                        @foreach ($organization_types as $ot)
                                                            <option value="{{ $ot->id }}" @selected(old('otype') == $ot->id)>{{ $ot->type }}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="floatingSelect">Organization Type</label>
                                                    @error('otype')
                                                        <span class="mb-1 text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <center>
                                        <div class="col-md-12 col-sm-12 col-xl-12 mt-3 d-grid">
                                            <div class="g-recaptcha"
                                                data-sitekey="6LdGRS8lAAAAAA8YQ0j2g6dWcykaaAIw2WnSRl1S"
                                                style="transform:scale(0.60);-webkit-transform:scale(0.90);transform-origin:0 0;-webkit-transform-origin:0 0;">
                                            </div>
                                        </div>
                                    </center>

                                    <div class="col-md-12 d-grid ">
                                        <input type="submit" class="btn btn-primary-gradient btn-wave"
                                            name="register" value="Register" />
                                    </div>
                                </div>
                            </form>


                            <div class="text-center">
                                <p class="fs-12 text-muted mt-4">Already have an account? <a href="/login"
                                        class="text-primary fw-bold">Sign In</a></p>
                            </div>
                            <center>
                                <span class="text-muted mb-0">All
                                    rights
                                    reserved Copyright © <span id="year">2024</span> xBug. Protected with
                                    Advanced
                                    Security
                                </span>
                            </center>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    <!-- Custom-Switcher JS -->
    <script src="assets/js/custom-switcher.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Show Password JS -->
    <script src="assets/js/show-password.js"></script>

</body>

</html>
