@extends('organization.layouts.main')
@section('container')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container" data-intro="This is your main dashboard, here you can see all the important information about your organization" data-step="18">
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
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card custom-card">
                                    <div class="card-body p-0">
                                        <div class="row g-0">
                                            <div class="col-xl-3 border-end border-inline-end-dashed">
                                                <div class="d-flex flex-wrap align-items-top p-4">
                                                    <div class="me-3 lh-1">
                                                        <span class="avatar avatar-md avatar-rounded bg-primary shadow-sm">
                                                            <i class="ti ti-files fs-18"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-fill mt-1">
                                                        <h5 class="fw-semibold mb-1">{{ $proposedContents }}</h5>
                                                        <p class="text-muted mb-0 fs-12">Total Contents</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 border-end border-inline-end-dashed">
                                                <div class="d-flex flex-wrap align-items-top p-4">
                                                    <div class="me-3 lh-1">
                                                        <span class="avatar avatar-md avatar-rounded bg-success shadow-sm">
                                                            <i class="ti ti-file-check fs-18"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-fill mt-1">
                                                        <h5 class="fw-semibold mb-1">{{ $approvedContents }}</h5>
                                                        <p class="text-muted mb-0 fs-12">Approved Contents</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 border-end border-inline-end-dashed">
                                                <div class="d-flex flex-wrap align-items-top p-4">
                                                    <div class="me-3 lh-1">
                                                        <span class="avatar avatar-md avatar-rounded bg-warning shadow-sm">
                                                            <i class="ti ti-file fs-18"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-fill mt-1">
                                                        <h5 class="fw-semibold mb-1">{{ $pendingContents }}</h5>
                                                        <p class="text-muted mb-0 fs-12">Pending Contents</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="d-flex flex-wrap align-items-top p-4">
                                                    <div class="me-3 lh-1">
                                                        <span class="avatar avatar-md avatar-rounded bg-danger shadow-sm ">
                                                            <i class="ti ti-file-dislike fs-18"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-fill mt-1">
                                                        <h5 class="fw-semibold mb-1">{{ $rejectedContents }}</h5>
                                                        <p class="text-muted mb-0 fs-12">Rejected Contents</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                        <div class="card p-3">
                            <div class="card-body p-0">
                                <!-- Tombol untuk memilih jenis transaksi -->
                                <div class="d-flex justify-content-between mb-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <div class="input-group">
                                                        <label for="start_date" class="form-label mt-2 me-2">Start
                                                            Date:</label>
                                                        <div class="input-group-text text-muted">
                                                            <i class="ri-calendar-line"></i>
                                                        </div>
                                                        <input type="text" class="form-control" id="start_date"
                                                            placeholder="Choose start date">
                                                    </div>
                                                </div>

                                                <div class="me-3">
                                                    <div class="input-group">
                                                        <label for="end_date" class="form-label mt-2 me-2">End
                                                            Date:</label>
                                                        <div class="input-group-text text-muted">
                                                            <i class="ri-calendar-line"></i>
                                                        </div>
                                                        <input type="text" class="form-control" id="end_date"
                                                            placeholder="Choose end date">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary mx-2 mt-1 btn-sm"
                                                            id="filterBtn">Filter</button>
                                                        <button class="btn btn-light mx-2 mt-1 btn-sm"
                                                            id="viewWeekly">Weekly</button>
                                                        <button class="btn btn-light mx-2 mt-1 btn-sm"
                                                            id="viewMonthly">Monthly</button>
                                                        <button class="btn btn-light mx-2 mt-1 btn-sm"
                                                            id="viewYearly">Yearly</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Container untuk grafik -->
                                <div id="chart-container">
                                    <canvas id="transactionChart" width="185" height="90"></canvas>
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
        $encryptedParams = Auth::user()->icNo;
    @endphp

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
    <script>
        $(document).ready(function() {
            let chartInstance = null;

            // Function to load chart data
            function loadChartData(viewType = 'Daily', startDate = '', endDate = '') {
                $.ajax({
                    url: '/organization/dashboard/transaction-data',
                    method: 'GET',
                    data: {
                        view_type: viewType,
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        // Data dari server
                        const labels = response.dates; // X-axis dates
                        const successData = mapTransactionsToDates(labels, response
                            .successTransactions);
                        const pendingData = mapTransactionsToDates(labels, response
                            .pendingTransactions);
                        const failedData = mapTransactionsToDates(labels, response.failedTransactions);

                        // Prepare data object for Chart.js
                        const data = {
                            labels: labels,
                            datasets: [{
                                    label: 'Success Transactions',
                                    data: successData,
                                    borderColor: 'rgba(54, 162, 235, 1)', // Blue
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    fill: false,
                                    borderWidth: 1.5,
                                },
                                {
                                    label: 'Pending Transactions',
                                    data: pendingData,
                                    borderColor: 'rgba(255, 205, 86, 1)', // Yellow
                                    backgroundColor: 'rgba(255, 205, 86, 0.2)',
                                    fill: false,
                                    borderWidth: 1.5,
                                },
                                {
                                    label: 'Failed Transactions',
                                    data: failedData,
                                    borderColor: 'rgba(255, 99, 132, 1)', // Red
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    fill: false,
                                    borderWidth: 1.5,
                                }
                            ]
                        };

                        // Prepare config object for Chart.js
                        const config = {
                            type: 'line',
                            data: data,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Transaction Overview'
                                    }
                                },
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Dates'
                                        },
                                        ticks: {
                                            autoSkip: true,
                                            maxRotation: 45,
                                            minRotation: 45
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Total Transactions'
                                        },
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1,
                                            callback: function(value) {
                                                return Math.round(value);
                                            }
                                        }
                                    }
                                }
                            },
                        };

                        // Render or update chart
                        if (chartInstance) {
                            chartInstance.data = data;
                            chartInstance.options = config.options;
                            chartInstance.update();
                        } else {
                            const ctx = document.getElementById('transactionChart').getContext('2d');
                            chartInstance = new Chart(ctx, config);
                        }
                    },
                    error: function(xhr) {
                        console.error("Error fetching data:", xhr.responseText);
                    }
                });
            }

            // Function to map transactions to all dates (fill missing dates with 0)
            function mapTransactionsToDates(allDates, transactions) {
                const mappedData = {};
                transactions.forEach(transaction => {
                    mappedData[transaction.date] = transaction.total_transactions;
                });

                // Return array of values corresponding to all dates
                return allDates.map(date => mappedData[date] || 0);
            }

            // Initialize date pickers
            flatpickr("#start_date", {
                dateFormat: "Y-m-d",
                defaultDate: null
            });

            flatpickr("#end_date", {
                dateFormat: "Y-m-d",
                defaultDate: null
            });

            // Load initial chart data (all transactions, daily)
            loadChartData('Daily');

            // Function to handle button styling
            function setActiveButton(buttonId) {
                // Reset all buttons to secondary
                $('#viewWeekly, #viewMonthly, #viewYearly').removeClass('btn-primary').addClass('btn-light');

                // Set clicked button to primary
                if (buttonId) {
                    $(`#${buttonId}`).removeClass('btn-light').addClass('btn-primary');
                }
            }

            // Handle filter button click
            $('#filterBtn').click(function() {
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();

                if (!startDate || !endDate) {
                    alert('Please select both start date and end date.');
                    return;
                }

                // Reload chart data with filtered date range (daily view by default)
                loadChartData('Daily', startDate, endDate);
                setActiveButton(''); // No active button for filter
            });

            // Handle view type buttons
            $('#viewWeekly').click(function() {
                loadChartData('Weekly');
                setActiveButton('viewWeekly');
            });

            $('#viewMonthly').click(function() {
                loadChartData('Monthly');
                setActiveButton('viewMonthly');
            });

            $('#viewYearly').click(function() {
                loadChartData('Yearly');
                setActiveButton('viewYearly');
            });
        });
    </script>
@endsection
