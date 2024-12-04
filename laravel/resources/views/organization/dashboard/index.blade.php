@extends('organization.layouts.main')
@section('container')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">
            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Organization Main Dashboard</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Main Dashboard</li>
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
            @if (session()->has('errorEkyc'))
                <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                    <i class="bi bi-dash-circle-fill fs-4"></i>
                    <div class="ms-3"> {{ session('errorEkyc') }} </div>
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
            @if (Auth::user()->ekyc_status === 0)
                <div class="row" id="tasks-container">
                    <div class="col-xl-12 task-card">
                        <div class="row justify-content-center">
                            <div class="col-md-12 ">
                                <ul class="list-unstyled mb-0 notification-container">
                                    <li>
                                        <div class="card custom-card un-read">
                                            <div class="card-body p-3">
                                                <a href="javascript:void(0);">
                                                    <div class="d-flex align-items-top mt-0 flex-wrap">
                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                <div
                                                                    class="lh-1 d-flex justify-content-center align-items-center mt-3">
                                                                    <span class="avatar avatar-md online avatar-rounded">
                                                                        <img alt="avatar"
                                                                            src="../../assets/images/user/avatar-1.jpg">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-11">
                                                                <div class="flex-fill">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="row">
                                                                            <div class="col-md-10">
                                                                                <div class="mt-sm-0 mt-2">
                                                                                    <p class="mb-0 fs-14 fw-semibold">
                                                                                        {{ Auth::user()->name }}</p>
                                                                                    <p class="mb-0 text-muted">Before you
                                                                                        continue, we
                                                                                        require users to complete eKYC
                                                                                        (Electronic Know Your Customer)
                                                                                        verification. This process involves
                                                                                        a
                                                                                        quick and easy upload of your
                                                                                        identification documents and facial
                                                                                        recognition to verify your identity.
                                                                                        This is for ensure a
                                                                                        secure and seamless experience in
                                                                                        our system.
                                                                                        Click start button to get started
                                                                                        and
                                                                                        enhance your security.</p>
                                                                                    <span
                                                                                        class="mb-0 d-block text-muted fs-12 mt-1"><span
                                                                                            class="badge bg-danger-transparent fw-bold fs-12">Pending...</span></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="text-end col-md-2">
                                                                                <div class="ms-auto mt-4">
                                                                                    <button type="button" id="startButton"
                                                                                        class="btn btn-success btn-wave">
                                                                                        <span id="StartText">Start</span>
                                                                                        <img id="loadingGif" class="d-none"
                                                                                            src="../../asset1/images/loading.gif"
                                                                                            alt="Loading..." width="35"
                                                                                            height="35">
                                                                                        <span id="loadingText"
                                                                                            class="d-none">Loading...</span>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal fade" id="qrModal"
                                                                                data-bs-backdrop="static"
                                                                                data-bs-keyboard="false" tabindex="-1"
                                                                                aria-labelledby="qrModalLabel"
                                                                                aria-hidden="true">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h6 class="modal-title"
                                                                                                id="qrModalLabel">
                                                                                                e-KYC Generated Code
                                                                                            </h6>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div
                                                                                            class="modal-body d-flex align-items-center justify-content-center p-3">
                                                                                            <div class="row ">
                                                                                                <div class="col-md-6 ">
                                                                                                    <div id="qrcode"
                                                                                                        class="w-100 text-center d-flex align-items-center justify-content-center">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="col-md-6 d-flex align-items-center justify-content-center">
                                                                                                    <span
                                                                                                        class="text-muted">Scan
                                                                                                        Qr Code using your
                                                                                                        mobile phone device
                                                                                                        for continue the
                                                                                                        e-KYC verification
                                                                                                        process</span>
                                                                                                </div>
                                                                                            </div>


                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-danger"
                                                                                                data-bs-dismiss="modal">Close</button>

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
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">Content Summary</div>
                            </div>
                            <div class="card-body">
                                <div class="row gy-md-0 gy-3">
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                        <div class="d-flex align-items-top">
                                            <div class="me-3">
                                                <span class="avatar avatar-rounded bg-light text-primary">
                                                    <i class="ti ti-files fs-18"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="d-block mb-1 text-muted">Contents Proposed</span>
                                                <h6 class="fw-semibold mb-0">{{ $proposedContents }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                        <div class="d-flex align-items-top">
                                            <div class="me-3">
                                                <span class="avatar avatar-rounded bg-light text-success">
                                                    <i class="ti ti-file-check fs-18"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="d-block mb-1 text-muted">Approved Contents</span>
                                                <h6 class="fw-semibold mb-0 text-success">{{ $approvedContents }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                        <div class="d-flex align-items-top">
                                            <div class="me-3">
                                                <span class="avatar avatar-rounded bg-light text-danger">
                                                    <i class="ti ti-file-dislike fs-18"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="d-block mb-1 text-muted">Rejected Contents</span>
                                                <h6 class="fw-semibold mb-0 text-danger">{{ $rejectedContents }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            @endif
            <!--End::row-1 -->
        </div>
    </div>
    {{-- <script>
        document.getElementById('startButton').addEventListener('click', function() {
            window.location.href = "/organization/card-verification";
        });
    </script> --}}
    @php
        $encryptedParams = Crypt::encryptString(json_encode(['id' => Auth::user()->id, 'icNo' => Auth::user()->icNo]));
    @endphp

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
        document.getElementById('startButton').addEventListener('click', async function() {

            const startButton = document.getElementById('startButton');
            const loadingText = document.getElementById('loadingText');
            const StartText = document.getElementById('StartText');
            const loadingGif = document.getElementById('loadingGif');

            startButton.disabled = true;
            loadingText.classList.remove('d-none');
            StartText.classList.add('d-none');
            loadingGif.classList.remove('d-none');
            await sleep(3000);
            const response = await fetch('/check-mobile');
            const data = await response.json();

            if (data.is_mobile) {

                window.location.href = `/card-verification/{{ $encryptedParams }}`;
            } else {
                const qrResponse = await fetch('/generate-qrcode');
                const qrData = await qrResponse.json();
                console.log(qrData.url);

                document.getElementById('qrcode').innerHTML = '';

                const qrCodeElement = document.getElementById('qrcode');
                new QRCode(qrCodeElement, {
                    text: qrData.url,
                    width: 200,
                    height: 200,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });

                // Show modal
                const qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
                qrModal.show();
            }

            startButton.disabled = false;
            loadingText.classList.add('d-none');
            StartText.classList.remove('d-none');
            loadingGif.classList.add('d-none');
        });
    </script>
@endsection
