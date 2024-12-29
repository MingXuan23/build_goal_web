<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="color" data-header-styles="light"
    data-menu-styles="color" data-toggled="close" style="--primary-rgb: 17,28,67;">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> xBug </title>
    <meta name="Description" content="xBug">
    <meta name="Author" content="xBug Inc">
    <meta name="keywords" content="xBug, xBug Content, xbug">
    <!-- Favicon -->
    <link rel="icon" href="../assets/images/logo.ico" type="image/x-icon">
    <!-- Bootstrap Css -->
    <link id="style" href="../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Style Css -->

    <link href="../assets/css/styles.min.css" rel="stylesheet">

</head>

<body>
    <!-- Start Switcher -->

    <!-- Loader -->
    <!-- Loader -->
    <div class="page">
        <!-- app-header -->
        <!-- End::app-sidebar -->
        <div class="container mt-5 my-5">
            <div class="row">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <div class="text-center mt-4">
                                <img src="https://directpay.my/assets/images/logo.jpg" class="img-fluid rounded"
                                    width="22" height="22">
                            </div>
                            <span class=" ms-1 mt-4">Provided by <span class="fw-bold text-primary me-4">Direct
                                    Pay</span>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('assets/images/failed_transaction.png') }}" alt="" width="200"
                                height="200">
                        </div>

                        <div class=" d-flex align-items-center justify-content-center text-center">
                            <span>Your transaction is <span class="fw-bold ">unsuccessfull</span></span>
                        </div>
                        <div class=" d-flex align-items-center justify-content-center text-center mt-1">
                            <span>You will redirect to Home page in <span class="fw-bold xxx"> 10 </span> seconds
                                or click the button below. Please Don't <span class="fw-bold">refresh</span> the
                                page or <span class="fw-bold">back</span></span>
                        </div>
                        <div class=" d-flex align-items-center justify-content-center mb-3 mt-3">
                            <a href="/" class="btn btn-success mt-2">Return Home Page</a>
                        </div>
                        <div class="mt-3 d-flex align-items-center justify-content-center">
                            <div class="">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="#5cb85c" class="">
                                    <path
                                        d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 6c1.4 0 2.8 1.1 2.8 2.5V11c.6 0 1.2.6 1.2 1.2v3.5c0 .7-.6 1.3-1.2 1.3H9.2c-.6 0-1.2-.6-1.2-1.2v-3.5c0-.7.6-1.3 1.2-1.3V9.5C9.2 8.1 10.6 7 12 7zm0 1c-.8 0-1.5.7-1.5 1.5V11h3V9.5c0-.8-.7-1.5-1.5-1.5z" />
                                </svg>
                                <span class="fw-bold">SSL SECURE PAYMENT</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center mb-4">
                            <div class="">
                                <span>Transaction is protected by 256-bit SSL encryption</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- Footer start -->
        <footer class="footer mt-auto py-3 bg-white text-center">
            <div class="container">
                <span class="mb-0 fw-semibold"><span class="text-muted">All
                        rights
                        reserved Copyright © </span><span id="year" class="text-muted">2024</span><span
                        class="fw-bold"> xBug</span> <span class="text-muted">Protected with Advanced
                        Security</span>
                </span>
            </div>
        </footer>

        <!-- Footer End -->
    </div>
    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
    </div>
    <script>
        let countdown = 10; // Waktu awal
        const countdownElement = document.querySelector('.xxx'); // Elemen nomor yang akan bergerak

        // Fungsi untuk menghitung mundur
        const interval = setInterval(() => {
            countdown--; // Kurangi angka
            if (countdownElement) {
                countdownElement.textContent = countdown; // Perbarui angka di HTML
            }

            if (countdown === 0) {
                clearInterval(interval); // Hentikan interval ketika mencapai 0
                window.location.href = "/"; // Arahkan ke halaman "/"
            }
        }, 1000); // Perbarui setiap detik
    </script>
</body>

</html>
