
<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> xBuq | Register </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

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
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-sm-10 col-12">
                <form action="" method="post">
                    <div class="card custom-card">
                        <div class="card-body p-5">

                            <!-- <center>
                                <img src="./Html/assets/images/server4.jpg" alt="logo" class="" width="300px" height="255px">
                                <center> -->

                            <p class="h6 mt-0 fw-semibold text-center">CyberSecVault</p>
                            <!-- <p class="h5 fw-semibold mb-2 text-center ">Management System</p> -->
                            <p class="mb-4 text-muted op-7 fw-normal text-center">Register</p>

                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <input type="text" class="form-control form-control-lg" placeholder="FullName" name="fullname" required>
                                </div>
                                <div class="col-xl-12">
                                    <input type="text" class="form-control form-control-lg" placeholder="IC Number" name="icno" required>
                                </div>
                                <div class="col-xl-12">
                                    <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" required>
                                    <label for="" class=" text-muted">&nbsp;&nbsp;please use valid email </label>
                                </div>
                                <div class="col-xl-12">
                                    <input type="text" class="form-control form-control-lg" placeholder="Phone Number" name="phone" required>
                                </div>
                                <div class="col-xl-12">
                                    <input type="text" class="form-control form-control-lg" placeholder="Organization Name" name="job" required>
                                </div>
                                <div class="col-xl-12">
                                    <input type="text" class="form-control form-control-lg" placeholder="Username" name="username" required>
                                </div>
                                <div class="col-xl-12 ">
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" id="signin-password" placeholder="Password" name="password" required>
                                        <button class="btn btn-light" type="button" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" id="signin-password" placeholder="Confrim password" name="password1" required>
                                        <button class="btn btn-light" type="button" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                                    </div>
                                </div>
                                <center>
                                    <div class="col-md-12 col-sm-12 col-xl-12  d-grid">
                                        <div class="g-recaptcha" data-sitekey="6LdGRS8lAAAAAA8YQ0j2g6dWcykaaAIw2WnSRl1S"></div>
                                    </div>
                                </center>

                                <div class="col-md-12 d-grid ">
                                    <input type="submit" class="btn btn-primary-gradient btn-wave" name="register" value="Register" />
                                </div>
                                <div class="col-md-12 d-grid mt-1">
                                    <button type="button" class="btn btn-primary-gradient btn-wave"><a href="login.php" class="text-white">Back</a></button>
                                </div>

                                <center>
                                    <span class="text-muted mb-0">All
                                        rights
                                        reserved Copyright © <span id="year">2024</span> xBug. Protected with Advanced Security
                                    </span>
                                </center>


                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>


    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
    </script>
    <!-- Custom-Switcher JS -->
    <script src="assets/js/custom-switcher.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Show Password JS -->
    <script src="assets/js/show-password.js"></script>

</body>

</html>