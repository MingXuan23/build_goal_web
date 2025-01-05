@extends('admin.layouts.main')
@section('container')
    {{-- @dd($totalUserHaveOneRole); --}}
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">
            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Admin Main Dashboard</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item text-warning"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Main Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Page Header Close -->
            <!-- Start::row 1 -->
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-top">
                                        <div class="flex-fill">
                                            <p class="mb-0 text-muted">Total Users</p>
                                        </div>
                                        <div class="ms-2">
                                            <span class="avatar avatar-md bg-primary fs-18">
                                                <i class="bi bi-person-square"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <h4 class="fw-bold text-center">{{ $totalUsers }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-top">
                                        <div class="flex-fill">
                                            <p class="mb-0 text-muted">Active Users</p>
                                        </div>
                                        <div class="ms-2">
                                            <span class="avatar avatar-md bg-success fs-18">
                                                <i class="bi bi-person-square"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <h4 class="fw-bold text-success text-center">{{ $activeUsers }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-top">
                                        <div class="flex-fill">
                                            <p class="mb-0 text-muted">Ban Users</p>
                                        </div>
                                        <div class="ms-2">
                                            <span class="avatar avatar-md bg-danger fs-18">
                                                <i class="bi bi-person-square"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <h4 class="fw-bold text-danger text-center">{{ $totalUserBan }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-top">
                                        <div class="flex-fill">
                                            <p class="mb-0 text-muted">Users GPT</p>
                                        </div>
                                        <div class="ms-2">
                                            <span class="avatar avatar-md bg-info fs-18">
                                                <i class="bi bi-person-square"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <h4 class="fw-bold text-center text-info">{{ $totalGpt }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-top">
                                        <div class="flex-fill">
                                            <p class="mb-0 text-muted">Total Ban GPT</p>
                                        </div>
                                        <div class="ms-2">
                                            <span class="avatar avatar-md bg-dark fs-18">
                                                <i class="bi bi-person-square"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <h4 class="fw-bold text-dark text-center">{{ $totalGptBlock }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-top">
                                        <div class="flex-fill">
                                            <p class="mb-0 text-muted">User More Role</p>
                                        </div>
                                        <div class="ms-2">
                                            <span class="avatar avatar-md bg-warning fs-18">
                                                <i class="bi bi-person-square"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <h4 class="fw-bold text-warning text-center">{{ $totalUserHaveOneRole }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                                    <h5 class="fw-semibold mb-1">{{ $totalContents }}</h5>
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
                                                    <h5 class="fw-semibold mb-1">{{ $approvedCount }}</h5>
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
                                                    <h5 class="fw-semibold mb-1">{{ $pendingCount }}</h5>
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
                                                    <h5 class="fw-semibold mb-1">{{ $rejectedCount }}</h5>
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

                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Registration Statistics</h5>
                            <div>
                                <button id="weekBtn" class="btn btn-primary">Weekly</button>
                                <button id="monthBtn" class="btn btn-secondary">Monthly</button>
                                <button id="yearBtn" class="btn btn-secondary">Yearly</button>
                            </div>
                        </div>

                        {{-- <div class="card-body">
                            <canvas id="registrationsChart"></canvas>
                        </div> --}}

                        <div class="card-body">
                            <canvas id="registrationsChart" width="500" height="180"></canvas>
                        </div>

                        <div class="custom-legend" id="customLegend">
                            <!-- Legenda akan diisi oleh JavaScript -->
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body p-0">
                            <div class="p-2">
                                <div class="ms-2 d-flex align-items-center mt-2">
                                    <span class="avatar avatar-md avatar-rounded bg-primary me-2">
                                        <i class="bi bi-receipt fs-16"></i>
                                    </span>
                                    <p class="mb-0 flex-fill text-muted">List Role Registred</p>
                                </div>

                            </div>
                            <div class="card-body">
                                <canvas id="userRoleChart" width="500" height="180"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body p-0">
                            <div class="p-2">
                                <div class="ms-2 d-flex align-items-center mt-2">
                                    <span class="avatar avatar-md avatar-rounded bg-primary me-2">
                                        <i class="bi bi-receipt fs-16"></i>
                                    </span>
                                    <p class="mb-0 flex-fill text-muted">e-KYC Statistics</p>
                                </div>

                            </div>
                            <div class="card-body">
                                <canvas id="ekycChart" width="500" height="180"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users by Role Chart -->
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body p-0">
                            <div class="p-2">
                                <div class="ms-2 d-flex align-items-center mt-2">
                                    <span class="avatar avatar-md avatar-rounded bg-primary me-2">
                                        <i class="bi bi-receipt fs-16"></i>
                                    </span>
                                    <p class="mb-0 flex-fill text-muted">Email Verification Statistics</p>
                                </div>

                            </div>
                            <div class="card-body">
                                <canvas id="userStatsChart" width="500" height="180"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
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
                                                    <button class="btn btn-primary px-4 mx-2"
                                                        id="filterBtn">Filter</button>
                                                    <button class="btn btn-secondary mx-2 mt-1"
                                                        id="viewWeekly">Weekly</button>
                                                    <button class="btn btn-secondary mx-2 mt-1"
                                                        id="viewMonthly">Monthly</button>
                                                    <button class="btn btn-secondary mx-2 mt-1"
                                                        id="viewYearly">Yearly</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Container untuk grafik -->
                            <div id="chart-container">
                                <canvas id="transactionChart" width="250" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End::row 3-->
            </div>
        </div>
    </div>
    <!-- Scripts for Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari backend
            const userChartData = @json($userCounts);

            const userLabels = userChartData.map(item => item.role_name);
            const userCounts = userChartData.map(item => item.user_count);

            // Definisikan palet warna yang lebih besar untuk menangani banyak peran
            const colorPalette = [{
                    background: 'rgba(255, 99, 132, 0.2)', // Merah
                    border: 'rgba(255, 99, 132, 1)'
                }, // Red
                {
                    background: 'rgba(75, 192, 192, 0.2)', // Hijau
                    border: 'rgba(75, 192, 192, 1)'
                }, // Green
                {
                    background: 'rgba(54, 162, 235, 0.2)', // Biru
                    border: 'rgba(54, 162, 235, 1)'
                }, // Blue
                {
                    background: 'rgba(153, 102, 255, 0.2)', // Ungu
                    border: 'rgba(153, 102, 255, 1)'
                }, // Purple
                {
                    background: 'rgba(255, 206, 86, 0.2)', // Kuning
                    border: 'rgba(255, 206, 86, 1)'
                }, // Yellow
                {
                    background: 'rgba(201, 203, 207, 0.2)', // Abu-abu
                    border: 'rgba(201, 203, 207, 1)'
                }, // Grey
                {
                    background: 'rgba(255, 159, 64, 0.2)', // Oranye
                    border: 'rgba(255, 159, 64, 1)'
                } // Orange
                // Tambahkan lebih banyak warna jika diperlukan
            ];

            // Fungsi untuk menetapkan warna unik untuk setiap peran
            function getColor(index) {
                return colorPalette[index % colorPalette.length];
            }

            const backgroundColors = userLabels.map((_, index) => getColor(index).background);
            const borderColors = userLabels.map((_, index) => getColor(index).border);

            // Inisialisasi Chart.js untuk Users by Role
            const userRoleCtx = document.getElementById('userRoleChart').getContext('2d');
            const userRoleChart = new Chart(userRoleCtx, {
                type: 'bar', // Anda dapat menggantinya dengan 'pie', 'line', dll.
                data: {
                    labels: userLabels,
                    datasets: [{
                        label: 'Number of Users',
                        data: userCounts,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1,
                        borderRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Menonaktifkan legenda default
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed.y;
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0 // Angka bulat saja
                            },
                            title: {
                                display: true,
                                text: 'Number of Users'
                            }
                        },
                        x: {
                            // title: {
                            //     display: true,
                            //     text: 'User Roles'
                            // }
                        }
                    }
                }
            });

            // Fungsi untuk membuat legenda kustom
            function createCustomLegend(labels) {
                const legendContainer = document.getElementById('userRoleLegend');
                legendContainer.innerHTML = ''; // Kosongkan kontainer

                labels.forEach((label, index) => {
                    const legendItem = document.createElement('div');
                    legendItem.classList.add('legend-item');

                    const colorBox = document.createElement('div');
                    colorBox.classList.add('legend-color-box');
                    colorBox.style.backgroundColor = backgroundColors[index];
                    colorBox.style.borderColor = borderColors[index];

                    const labelText = document.createElement('span');
                    labelText.textContent = label;

                    legendItem.appendChild(colorBox);
                    legendItem.appendChild(labelText);
                    legendContainer.appendChild(legendItem);
                });
            }

            createCustomLegend(userLabels);

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // eKYC Status Chart
            var ekycCtx = document.getElementById('ekycChart').getContext('2d');
            new Chart(ekycCtx, {
                type: 'pie',
                data: {
                    labels: ['Verified', 'Not Verified'],
                    datasets: [{
                        data: [{{ $ekycVerified }}, {{ $ekycNotVerified }}],
                        backgroundColor: [
                            'rgba(76, 175, 80, 0.6)', // Hijau Cerah untuk Verified
                            'rgba(244, 67, 54, 0.6)' // Merah Cerah untuk Not Verified
                        ],
                        borderColor: [
                            'rgba(76, 175, 80, 1)', // Hijau Solid
                            'rgba(244, 67, 54, 1)' // Merah Solid
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top', // Posisi legenda
                            labels: {
                                boxWidth: 20, // Lebar kotak warna
                                padding: 15 // Jarak antara kotak dan teks label
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(2);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Other User Statistics Chart
            var userStatsCtx = document.getElementById('userStatsChart').getContext('2d');
            new Chart(userStatsCtx, {
                type: 'pie',
                data: {
                    labels: ['Email Verified', 'Email Not Verified'],
                    datasets: [{
                        data: [
                            {{ $emailVerified }},
                            {{ $totalUsers - $emailVerified }}
                        ],
                        backgroundColor: [
                            'rgba(0, 123, 255, 0.6)', // Biru Muda untuk Email Verified
                            'rgba(255, 193, 7, 0.6)' // Kuning Cerah untuk Email Not Verified
                        ],
                        borderColor: [
                            'rgba(0, 123, 255, 1)', // Biru Solid
                            'rgba(255, 193, 7, 1)' // Kuning Solid
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 20,
                                padding: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(2);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Registrations Chart (Bar Chart)
            const registrationsCtx = document.getElementById('registrationsChart').getContext('2d');

            // Data dari backend
            const yearData = @json($yearData);
            const monthData = @json($monthData);
            const weekData = @json($weekData);

            // Pemetaan warna untuk setiap hari
            const dayColors = {
                'Monday': {
                    background: 'rgba(54, 162, 235, 0.2)', // Biru
                    border: 'rgba(54, 162, 235, 1)'
                },
                'Tuesday': {
                    background: 'rgba(255, 99, 132, 0.2)', // Merah
                    border: 'rgba(255, 99, 132, 1)'
                },
                'Wednesday': {
                    background: 'rgba(255, 206, 86, 0.2)', // Kuning
                    border: 'rgba(255, 206, 86, 1)'
                },
                'Thursday': {
                    background: 'rgba(75, 192, 192, 0.2)', // Hijau
                    border: 'rgba(75, 192, 192, 1)'
                },
                'Friday': {
                    background: 'rgba(153, 102, 255, 0.2)', // Ungu
                    border: 'rgba(153, 102, 255, 1)'
                },
                'Saturday': {
                    background: 'rgba(255, 159, 64, 0.2)', // Oranye
                    border: 'rgba(255, 159, 64, 1)'
                },
                'Sunday': {
                    background: 'rgba(201, 203, 207, 0.2)', // Abu-abu
                    border: 'rgba(201, 203, 207, 1)'
                }
            };

            // Fungsi untuk menetapkan warna berdasarkan hari
            function assignColors(labels) {
                const backgroundColor = labels.map(label => dayColors[label]?.background || 'rgba(0, 0, 0, 0.1)');
                const borderColor = labels.map(label => dayColors[label]?.border || 'rgba(0, 0, 0, 1)');
                return {
                    backgroundColor,
                    borderColor
                };
            }

            // Fungsi untuk membuat legenda kustom (opsional)
            function createCustomLegend(labels) {
                const legendContainer = document.getElementById('customLegend');
                legendContainer.innerHTML = ''; // Kosongkan kontainer

                labels.forEach(label => {
                    const legendItem = document.createElement('div');
                    legendItem.classList.add('legend-item');

                    const colorBox = document.createElement('div');
                    colorBox.classList.add('legend-color-box');
                    colorBox.style.backgroundColor = dayColors[label]?.background || 'rgba(0, 0, 0, 0.1)';
                    colorBox.style.borderColor = dayColors[label]?.border || 'rgba(0, 0, 0, 1)';

                    const labelText = document.createElement('span');
                    labelText.textContent = label;

                    legendItem.appendChild(colorBox);
                    legendItem.appendChild(labelText);
                    legendContainer.appendChild(legendItem);
                });
            }

            // Inisialisasi Chart dengan data mingguan sebagai default
            let currentRange = 'week';
            let labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            let data = labels.map(day => weekData[day] || 0);

            const {
                backgroundColor,
                borderColor
            } = assignColors(labels);

            const registrationsChart = new Chart(registrationsCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Pengguna Terdaftar',
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 1,
                        borderRadius: 5, // Opsional: Menambahkan radius pada batang
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Menonaktifkan legenda default
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed.y;
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0 // Angka bulat saja
                            }
                        }
                    }
                }
            });

            // Membuat legenda kustom pada inisialisasi chart (opsional)
            // createCustomLegend(labels); // Aktifkan jika ingin legenda kustom

            // Penanganan klik tombol
            document.getElementById('weekBtn').addEventListener('click', function() {
                if (currentRange !== 'week') {
                    updateChart('week', weekData);
                    setActiveButton('weekBtn');
                }
            });

            document.getElementById('monthBtn').addEventListener('click', function() {
                if (currentRange !== 'month') {
                    updateChart('month', monthData);
                    setActiveButton('monthBtn');
                }
            });

            document.getElementById('yearBtn').addEventListener('click', function() {
                if (currentRange !== 'year') {
                    updateChart('year', yearData);
                    setActiveButton('yearBtn');
                }
            });

            // Fungsi untuk memperbarui data chart
            function updateChart(range, dataSet) {
                let newLabels, newData;

                if (range === 'week') {
                    newLabels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    newData = newLabels.map(day => dataSet[day] || 0);
                } else if (range === 'month') {
                    newLabels = [
                        'January', 'February', 'March', 'April', 'May', 'June',
                        'July', 'August', 'September', 'October', 'November', 'December'
                    ];
                    // Jika Anda ingin memberikan warna unik untuk setiap bulan, Anda perlu menambahkan pemetaan warna untuk bulan juga
                    // Misalnya:
                    // const monthColors = { 'January': {...}, 'February': {...}, ... };
                    newData = newLabels.map((_, i) => dataSet[i + 1] || 0);
                } else if (range === 'year') {
                    newLabels = Object.keys(dataSet).sort();
                    newData = newLabels.map(year => dataSet[year]);
                }

                // Jika rentang waktu adalah 'week', tetapkan warna berdasarkan hari
                // Untuk 'month' dan 'year', tetapkan warna secara acak atau berdasarkan logika lain
                let colorsToAssign;
                if (range === 'week') {
                    colorsToAssign = assignColors(newLabels);
                } else {
                    // Misalnya, tetapkan warna secara acak atau gunakan logika lain
                    colorsToAssign = {
                        backgroundColor: newLabels.map(() => getRandomColor(0.6)),
                        borderColor: newLabels.map(() => getRandomColor(1))
                    };
                }

                registrationsChart.data.labels = newLabels;
                registrationsChart.data.datasets[0].data = newData;
                registrationsChart.data.datasets[0].backgroundColor = colorsToAssign.backgroundColor;
                registrationsChart.data.datasets[0].borderColor = colorsToAssign.borderColor;
                registrationsChart.update();

                // Membuat legenda kustom untuk label baru jika diperlukan
                // createCustomLegend(newLabels);

                currentRange = range;
            }

            // Fungsi untuk menyorot tombol aktif
            function setActiveButton(activeId) {
                ['weekBtn', 'monthBtn', 'yearBtn'].forEach(id => {
                    const button = document.getElementById(id);
                    if (id === activeId) {
                        button.classList.add('btn-primary');
                        button.classList.remove('btn-secondary');
                    } else {
                        button.classList.add('btn-secondary');
                        button.classList.remove('btn-primary');
                    }
                });
            }

            // Fungsi untuk menghasilkan warna acak
            function getRandomColor(alpha) {
                const r = Math.floor(Math.random() * 255);
                const g = Math.floor(Math.random() * 255);
                const b = Math.floor(Math.random() * 255);
                return `rgba(${r}, ${g}, ${b}, ${alpha})`;
            }

            // Set tombol default aktif (week) saat halaman dimuat
            setActiveButton('weekBtn');
        });
    </script>

    <script>
        $(document).ready(function() {
            let chartInstance = null;

            // Function to load chart data
            function loadChartData(viewType = 'Daily', startDate = '', endDate = '') {
                $.ajax({
                    url: '/admin/dashboard/transaction-data',
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
                $('#viewWeekly, #viewMonthly, #viewYearly').removeClass('btn-primary').addClass('btn-secondary');

                // Set clicked button to primary
                if (buttonId) {
                    $(`#${buttonId}`).removeClass('btn-secondary').addClass('btn-primary');
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
