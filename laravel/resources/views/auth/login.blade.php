<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="color" data-header-styles="light"
    data-menu-styles="color" data-toggled="close" style="--primary-rgb: 17,28,67;">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> xBug | Login </title>
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



    {{--  --}}
    {{--  --}}
    {{--  --}}

    <link rel="icon" href="assets/images/brand-logos/favicon.ico" type="image/x-icon">

    <!-- Choices JS -->
    <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

    <!-- Main Theme Js -->
    <script src="assets/js/main.js"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Style Css -->
    <link href="assets/css/styles.min.css" rel="stylesheet">

    <!-- Icons Css -->
    <link href="assets/css/icons.css" rel="stylesheet">

    <!-- Node Waves Css -->
    <link href="assets/libs/node-waves/waves.min.css" rel="stylesheet">

    <!-- Simplebar Css -->
    <link href="assets/libs/simplebar/simplebar.min.css" rel="stylesheet">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="assets/libs/@simonwep/pickr/themes/nano.min.css">

    <!-- Choices Css -->
    <link rel="stylesheet" href="assets/libs/choices.js/public/assets/styles/choices.min.css">


    <!-- Prism CSS -->
    <link rel="stylesheet" href="assets/libs/prismjs/themes/prism-coy.min.css">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


</head>

<body>

    <!-- Start Switcher -->

    <!-- End Switcher -->

    <div class="container">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-sm-10 col-12">
                <form action="" method="post">

                </form>

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
                @if (session()->has('errorEkyc'))
                    <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                        <i class="bi bi-dash-circle-fill fs-4"></i>
                        <div class="ms-3"> {!! session('errorEkyc') !!} </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <div class="card custom-card">
                    <div class="card-body">

                        <div class="p-3">
                            <div class="mb-3">
                                {{-- <a href="index.html">
                                <img src="../../assets/images/brand-logos/desktop-logo.png" alt="" class="authentication-brand desktop-logo">
                                <img src="../../assets/images/brand-logos/desktop-dark.png" alt="" class="authentication-brand desktop-dark">
                            </a> --}}
                            </div>
                            <p class="h5 fw-semibold mb-2">Sign In</p>
                            <p class="mb-4 text-muted op-7 fw-normal ">Hii, Welcome back !</p>
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="row gy-2">
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="email"
                                                class="form-control  @error('email') is-invalid @enderror"
                                                id="floatingInputprimary" placeholder="name@example.com" name="email" value="{{ old('email') }}">
                                            <label for="floatingInputprimary">Email Address</label>
                                            @error('email')
                                                <span class="mb-1 text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="password"
                                                class="form-control  @error('password') is-invalid @enderror"
                                                id="floatingInputprimary" placeholder="name@example.com"
                                                name="password">
                                            <label for="floatingInputprimary">Password</label>
                                            @error('password')
                                                <span class="mb-1 text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <span class="fs-12 text-muted mt-5">Forget your password? <a
                                                class="modal-effect mb-3 text-primary fw-bold"
                                                href="/reset-password">Reset now</a></span>
                                    </div>

                                    <center>
                                        <div class="col-md-12 col-sm-12 col-xl-12  d-grid">
                                            <div class="g-recaptcha"
                                                data-sitekey="6LdGRS8lAAAAAA8YQ0j2g6dWcykaaAIw2WnSRl1S"
                                                style="transform:scale(0.60);-webkit-transform:scale(0.90);transform-origin:0 0;-webkit-transform-origin:0 0;">
                                            </div>
                                        </div>
                                    </center>

                                    <div class="col-md-12 d-grid ">
                                        <input type="submit" class="btn btn-primary-gradient btn-wave"
                                            name="register" value="Sign In">
                                        </input>
                                    </div>
                                </div>
                            </form>

                            <div class="text-center">
                                <p class="fs-12 text-muted mt-4">Dont have an account? <a
                                        class="modal-effect mb-3 text-primary fw-bold" data-bs-effect="effect-sign"
                                        data-bs-toggle="modal" href="#optionType">Sign Up</a></p>

                            </div>
                            <center>
                                <span class="text-muted mb-0">All
                                    rights
                                    reserved Copyright © <span id="year">2024</span> xBug. Protected with
                                    Advanced Security
                                </span>
                            </center>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="optionType" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title fw-bold">Register Options</h6>
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-start">
                            <p class="text-muted">
                                Please select the type of account you would like to register for.
                                Choose <strong>Organization</strong> if you represent a company or entity.
                                Select <strong>Content Creator</strong> if you are an individual looking to showcase
                                your creative work.
                            </p>

                            <div class="d-grid gap-2">
                                <a class="btn btn-outline-primary" href='/organization-register'>
                                    Register as Organization
                                </a>
                                <a class="btn btn-outline-success" href='/content-creator-register'>
                                    Register as Content Creator
                                </a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        </div>
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





    {{--  --}}
    {{--  --}}
    {{--  --}}

    <!-- Popper JS -->
    <script src="assets/libs/@popperjs/core/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Defaultmenu JS -->
    <script src="assets/js/defaultmenu.min.js"></script>

    <!-- Node Waves JS-->
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- Sticky JS -->
    <script src="assets/js/sticky.js"></script>

    <!-- Simplebar JS -->
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/js/simplebar.js"></script>

    <!-- Color Picker JS -->
    <script src="assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>



    <!-- Custom-Switcher JS -->
    <script src="assets/js/custom-switcher.min.js"></script>

    <!-- Prism JS -->
    <script src="assets/libs/prismjs/prism.js"></script>
    <script src="assets/js/prism-custom.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/custom.js"></script>
</body>

</html>
