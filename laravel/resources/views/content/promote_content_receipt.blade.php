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
                <div class="">
                    <div class="container mt-5">
                        <div class="card">
                            <div class="">
                                @if ($transaction->status == 'Success')
                                    <div class="">
                                    @elseif($transaction->status == 'Pending')
                                        <div class="">
                                        @elseif($transaction->status == 'Failed')
                                            <div class="">
                                            @else
                                                <div class="">
                                @endif

                                <div class="d-flex justify-content-between align-items-center">
                                    @if ($transaction->status == 'Success')
                                        {{-- <h5 class="m-0 text-white fw-bold">Payment Success</h5> --}}
                                    @elseif($transaction->status == 'Pending')
                                        {{-- <h5 class="m-0 text-white fw-bold">Payment Processing</h5> --}}
                                    @elseif($transaction->status == 'Failed')
                                        {{-- <h5 class="m-0 text-white fw-bold">Payment Failed</h5> --}}
                                    @else
                                        {{-- <h5 class="m-0 text-white fw-bold">Payment Failed</h5> --}}
                                    @endif
                                    {{-- <svg width="30" height="30" viewBox="0 0 24 24" fill="white">
                                        <path
                                            d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z" />
                                    </svg> --}}

                                </div>
                            </div>

                            <div class="card-body">
                                <div class="order-summary p-4">
                                    @php
                                        if ($transaction->status == 'Success') {
                                            $bg = 'success';
                                            $a = 'PAYMENT SUCCESSFULL';
                                        } elseif ($transaction->status == 'Pending') {
                                            $bg = 'warning';
                                            $a = 'PAYMENT PENDING';
                                        } elseif ($transaction->status == 'Failed') {
                                            $bg = 'danger';
                                            $a = 'PAYMENT FAILED';
                                        }

                                    @endphp
                                    <button
                                        class="btn btn-{{ $bg }}-transparent fw-bold d-flex align-items-center ">{{ $a }}<span
                                            class="ms-2 badge badge-sm bg-{{ $bg }} text-sm">{{ $transaction->status }}</span></button>
                                    <div class="d-flex justify-content-end">
                                        {{-- <button
                                            class="mb-4 btn btn-{{ $bg }}-transparent fw-bold d-flex align-items-center ">PAYMENT
                                            SUCCESSFULL<span
                                                class="ms-2 badge badge-sm bg-{{ $bg }} text-sm">{{ $transaction->status }}</span></button> --}}
                                        <div class="text-center mt-3">
                                            <img src="https://directpay.my/assets/images/logo.jpg"
                                                class="img-fluid rounded" width="22" height="22">
                                        </div>
                                        <span class="fw-bold ms-1 mt-3">Provided by <span
                                                class="fw-bold text-primary">Direct
                                                Pay</span>
                                    </div>
                                    <hr>
                                    <h6 class="mt-4 fw-bold d-flex align-items-center ">PROMOTION
                                        SUMMARY</h6>

                                    <div class="mt-4 px-5">
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <div class="col-md-6">
                                                <p><strong>Content Name:</strong><br>{{ $content->name }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Transaction ID:</strong><br>{{ $transaction->transac_no }}
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Estimated
                                                        Reach:</strong><br>{{ number_format($cp_id->estimate_reach, 0) }}
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Selected States:</strong><br>
                                                    @foreach (json_decode($cp_id->target_audience) as $state)
                                                        {{ $state }},
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
<hr>
                                        <div class="d-flex justify-content-end align-items-end mt-3">
                                            <h6 class="fw-bold">AMOUNT PAID : </h6>
                                            <h6 class="fw-bold"> &nbsp; RM {{ number_format($transaction->amount, 2) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class=" d-flex align-items-center justify-content-center text-center">
                                    <span>Your transaction is <span class="fw-bold text-success">successfull</span></span>
                                </div>
                                <div class=" d-flex align-items-center justify-content-center text-center mt-1">
                                    <span>You will redirect to Home page in <span class="fw-bold xxx"> 8 </span>
                                        seconds
                                        or click the button below. Please Don't <span class="fw-bold">refresh</span> the
                                        page or <span class="fw-bold">back</span></span>
                                </div>
                                <div class=" d-flex align-items-center justify-content-center mb-3 mt-3">
                                    <a href="/" class="btn btn-success mt-2">Return Home Page</a>
                                </div>

                                <div class=" d-flex align-items-center justify-content-center">
                                    <div class="">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#5cb85c"
                                            class="">
                                            <path
                                                d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 6c1.4 0 2.8 1.1 2.8 2.5V11c.6 0 1.2.6 1.2 1.2v3.5c0 .7-.6 1.3-1.2 1.3H9.2c-.6 0-1.2-.6-1.2-1.2v-3.5c0-.7.6-1.3 1.2-1.3V9.5C9.2 8.1 10.6 7 12 7zm0 1c-.8 0-1.5.7-1.5 1.5V11h3V9.5c0-.8-.7-1.5-1.5-1.5z" />
                                        </svg>
                                        <span class="fw-bold">SSL SECURE PAYMENT</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center mb-3 text-center">
                                    <div class="">
                                        <span>Transaction is protected by 256-bit SSL encryption</span>
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
        let countdown = 8; // Waktu awal
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
