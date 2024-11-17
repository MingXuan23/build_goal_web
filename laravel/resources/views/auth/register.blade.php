<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="color" data-header-styles="light"
    data-menu-styles="color" data-toggled="close" style="--primary-rgb: 17,28,67;">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> xBug | register </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- Favicon -->
    <link rel="icon" href="../../assets/images/brand-logos/favicon.ico" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="../../assets/js/authentication-main.js"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="../../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Style Css -->
    <link href="../../assets/css/styles.min.css" rel="stylesheet">

    <!-- Icons Css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet">


    <link rel="stylesheet" href="../../assets/libs/swiper/swiper-bundle.min.css">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body class="bg-white">

    <!-- Start Switcher -->

    <!-- End Switcher -->

    <div class="row authentication mx-0">

        <div class="col-xxl-7 col-xl-7 col-lg-12">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-xxl-10 col-xl-7 col-lg-7 col-md-7 col-sm-8 col-12">
                    <div class="p-5">
                        <p class="h5 fw-bold mb-2">Sign Up</p>
                        <p class="mb-4 text-muted op-7 fw-normal ">Welcome & Join us by creating a free account !</p>
                        <div class="mb-3">
                            {{-- <a href="index.html">
                                <img src="../../assets/images/brand-logos/desktop-logo.png" alt="" class="authentication-brand desktop-logo">
                                <img src="../../assets/images/brand-logos/desktop-dark.png" alt="" class="authentication-brand desktop-dark">
                            </a> --}}
                        </div>
                        <div class="row">
                            
                            <div class="col-md-6">
                                <p class="fw-semibold mt-2">Personal Details</p>
                                <hr>
                                <div class="row gy-2">
                                    
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Ic Number</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Full Name</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Email Address</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Phone Number</label>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Confirm Password</label>
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
                                            <input type="text" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Organization Name</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Organization Address</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Organization State</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <select class="form-select" id="floatingSelect"
                                                aria-label="Floating label select example">
                                                <option selected>- Select -</option>
                                                <option value="1">Company</option>
                                                <option value="2">Skill Training Organization</option>
                                            </select>
                                            <label for="floatingSelect">Organization Type</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <center>
                                <div class="col-md-12 col-sm-12 col-xl-12 mt-3 d-grid">
                                    <div class="g-recaptcha" data-sitekey="6LdGRS8lAAAAAA8YQ0j2g6dWcykaaAIw2WnSRl1S"
                                        style="transform:scale(0.60);-webkit-transform:scale(0.90);transform-origin:0 0;-webkit-transform-origin:0 0;">
                                    </div>
                                </div>
                            </center>

                            <div class="col-md-12 d-grid ">
                                <input type="submit" class="btn btn-primary-gradient btn-wave" name="register"
                                    value="Register" />
                            </div>
                        </div>


                        <div class="text-center">
                            <p class="fs-12 text-muted mt-4">Already have an account? <a href="/login"
                                    class="text-primary">Sign In</a></p>
                        </div>
                        <center>
                            <span class="text-muted mb-0">All
                                rights
                                reserved Copyright © <span id="year">2024</span> xBug. Protected with Advanced
                                Security
                            </span>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-5 col-xl-5 col-lg-5 d-xl-block d-none px-0">
            <div class="authentication-cover">
                <div class="aunthentication-cover-content rounded">
                    <div class="swiper keyboard-control">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div
                                    class="text-fixed-white text-center p-5 d-flex align-items-center justify-content-center">
                                    <div>
                                        <div class="mb-5">
                                            <img src="../../assets/images/auth/register.jpg"
                                                class="authentication-image" alt="">
                                        </div>
                                        <h6 class="fw-semibold text-fixed-white">Sign Up</h6>
                                        <p class="fw-normal fs-14 op-7"> Lorem ipsum dolor sit amet, consectetur
                                            adipisicing elit. Ipsa eligendi expedita aliquam quaerat nulla voluptas
                                            facilis. Porro rem voluptates possimus, ad, autem quae culpa architecto,
                                            quam labore blanditiis at ratione.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="text-fixed-white text-center p-5 d-flex align-items-center justify-content-center">
                                    <div>
                                        <div class="mb-5">
                                            <img src="../../assets/images/auth/1.png" class="authentication-image"
                                                alt="">
                                        </div>
                                        <h6 class="fw-semibold text-fixed-white">Sign Up</h6>
                                        <p class="fw-normal fs-14 op-7"> Lorem ipsum dolor sit amet, consectetur
                                            adipisicing elit. Ipsa eligendi expedita aliquam quaerat nulla voluptas
                                            facilis. Porro rem voluptates possimus, ad, autem quae culpa architecto,
                                            quam labore blanditiis at ratione.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="text-fixed-white text-center p-5 d-flex align-items-center justify-content-center">
                                    <div>
                                        <div class="mb-5">
                                            <img src="../../assets/images/auth/3.jpg" class="authentication-image"
                                                alt="">
                                        </div>
                                        <h6 class="fw-semibold text-fixed-white">Sign Up</h6>
                                        <p class="fw-normal fs-14 op-7"> Lorem ipsum dolor sit amet, consectetur
                                            adipisicing elit. Ipsa eligendi expedita aliquam quaerat nulla voluptas
                                            facilis. Porro rem voluptates possimus, ad, autem quae culpa architecto,
                                            quam labore blanditiis at ratione.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    <!-- Bootstrap JS -->
    <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Swiper JS -->
    <script src="../../assets/libs/swiper/swiper-bundle.min.js"></script>

    <!-- Internal Sing-Up JS -->
    <script src="../../assets/js/authentication.js"></script>

    <!-- Show Password JS -->
    <script src="../../assets/js/show-password.js"></script>

</body>

</html>
