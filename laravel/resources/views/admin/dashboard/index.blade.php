@extends('admin.layouts.main')
@section('container')
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
                    <div class="card custom-card">
                        <div class="card-header">
                            <h5 class="card-title">User Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Total Users</h6>
                                    <h4 class="fw-bold">{{ $totalUsers }}</h4>
                                </div>
                                <div>
                                    <h6 class="text-muted">Active Users</h6>
                                    <h4 class="fw-bold text-success">{{ $activeUsers }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card custom-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Registration Statistics</h5>
                                <div>
                                    <button class="btn btn-primary btn-sm" id="weekBtn">Week</button>
                                    <button class="btn btn-secondary btn-sm" id="monthBtn">Month</button>
                                    <button class="btn btn-secondary btn-sm" id="yearBtn">Year</button>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <canvas id="registrationsChart"></canvas>
                            </div>
                        </div>

                </div>
                <div class="col-xl-6 col-lg-6 col-md-12">
                    
                    <div class="card custom-card">
                        <div class="card-header">
                            <h5 class="card-title">Transaction Summary</h5>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="transactionTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="day-tab" data-bs-toggle="tab" href="#day" role="tab" aria-controls="day" aria-selected="false">Day</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="week-tab" data-bs-toggle="tab" href="#week" role="tab" aria-controls="week" aria-selected="false">Week</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="month-tab" data-bs-toggle="tab" href="#month" role="tab" aria-controls="month" aria-selected="false">Month</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="year-tab" data-bs-toggle="tab" href="#year" role="tab" aria-controls="year" aria-selected="true">Year</a>
                                </li>

                            </ul>
                            <div class="tab-content mt-4">
                                <!-- Day Chart -->
                                <div class="tab-pane fade" id="day" role="tabpanel" aria-labelledby="day-tab">
                                    <canvas id="dayTransactionChart"></canvas>
                                    <div class="mt-3">
                                        <p><strong>Total Transactions:</strong> {{ $totalDailyTransactions }}</p>
                                        <p><strong>Total Amount Received:</strong> RM{{ number_format($totalDailyAmount, 2) }}</p>
                                    </div>
                                </div>
                                <!-- Week Chart -->
                                <div class="tab-pane fade" id="week" role="tabpanel" aria-labelledby="week-tab">
                                    <canvas id="weekTransactionChart"></canvas>
                                    <div class="mt-3">
                                        <p><strong>Total Transactions:</strong> {{ $totalWeeklyTransactions }}</p>
                                        <p><strong>Total Amount Received:</strong> RM{{ number_format($totalWeeklyAmount, 2) }}</p>
                                    </div>
                                </div>
                                <!-- Month Chart -->
                                <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
                                    <canvas id="monthTransactionChart"></canvas>
                                    <div class="mt-3">
                                        <p><strong>Total Transactions:</strong> {{ $totalMonthlyTransactions }}</p>
                                        <p><strong>Total Amount Received:</strong> RM{{ number_format($totalMonthlyAmount, 2) }}</p>
                                    </div>
                                </div>
                                <!-- Year Chart -->
                                <div class="tab-pane fade show active" id="year" role="tabpanel" aria-labelledby="year-tab">
                                    <canvas id="yearTransactionChart"></canvas>
                                    <div class="mt-3">
                                        <p><strong>Total Transactions:</strong> {{ $totalYearlyTransactions }}</p>
                                        <p><strong>Total Amount Received:</strong> RM{{ number_format($totalYearlyAmount, 2) }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                </div>
            </div>
      <!-- End::row 1 -->
      <!-- Start::row 2 -->
            <div class="row">
                <!-- Users by Role Chart -->
                <div class="col-lg-6">
                    <div class="card custom-card">
                    <div class="card-header">
                        <h5 class="card-title">Users Data</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="userRoleChart" width="400" height="200"></canvas>
                    </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card custom-card">
                    <div class="card-header">
                        <h5 class="card-title">eKYC Status</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="ekycChart"></canvas>
                    </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card custom-card">
                    <div class="card-header">
                        <h5 class="card-title">Email Verification Status</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="userStatsChart"></canvas>
                    </div>
                    </div>
                </div>
            </div>
      <!-- End::row 2-->
      <!-- Start::row 3 -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Content Summary</div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-md-0 gy-3">
                            <!-- Total Contents -->
                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                <div class="d-flex align-items-top">
                                <div class="me-3">
                                    <span class="avatar avatar-rounded bg-light text-primary">
                                    <i class="ti ti-files fs-18"></i>
                                    </span>
                                </div>
                                <div>
                                    <span class="d-block mb-1 text-muted">Total Contents</span>
                                    <h6 class="fw-semibold mb-0 text-primary">{{ $totalContents }}</h6>
                                </div>
                                </div>
                            </div>
                            <!-- Pending Contents -->
                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                <div class="d-flex align-items-top">
                                <div class="me-3">
                                    <span class="avatar avatar-rounded bg-light text-warning">
                                    <i class="ti ti-file fs-18"></i>
                                    </span>
                                </div>
                                <div>
                                    <span class="d-block mb-1 text-muted">Pending Contents</span>
                                    <h6 class="fw-semibold mb-0 text-warning">{{ $pendingCount }}</h6>
                                </div>
                                </div>
                            </div>
                            <!-- Rejected Contents -->
                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                <div class="d-flex align-items-top">
                                <div class="me-3">
                                    <span class="avatar avatar-rounded bg-light text-danger">
                                    <i class="ti ti-file-dislike fs-18"></i>
                                    </span>
                                </div>
                                <div>
                                    <span class="d-block mb-1 text-muted">Rejected Contents</span>
                                    <h6 class="fw-semibold mb-0 text-danger">{{ $rejectedCount }}</h6>
                                </div>
                                </div>
                            </div>
                            <!-- Approved Contents -->
                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                <div class="d-flex align-items-top">
                                <div class="me-3">
                                    <span class="avatar avatar-rounded bg-light text-success">
                                    <i class="ti ti-file-check fs-18"></i>
                                    </span>
                                </div>
                                <div>
                                    <span class="d-block mb-1 text-muted">Approved Contents</span>
                                    <h6 class="fw-semibold mb-0 text-success">{{ $approvedCount }}</h6>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
      <!-- End::row 3-->
</div>
<!-- Scripts for Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   // Users by Role Chart
   document.addEventListener('DOMContentLoaded', function () {
       const userCtx = document.getElementById('userRoleChart').getContext('2d');
       const userChartData = @json($userCounts);
   
       const userLabels = userChartData.map(item => item.role_name);
       const userCounts = userChartData.map(item => item.user_count);
   
       new Chart(userCtx, {
           type: 'bar', // You can change this to 'pie', 'line', etc.
           data: {
               labels: userLabels,
               datasets: [{
                   label: 'Number of Users',
                   data: userCounts,
                   backgroundColor: ['#f39c12', '#3498db', '#2ecc71', '#e74c3c', '#9b59b6'],
                   borderColor: '#ffffff',
                   borderWidth: 1
               }]
           },
           options: {
               responsive: true,
               maintainAspectRatio: true,
               aspectRatio: 2 // Adjust aspect ratio
           }
       });
   });
   
   
    document.addEventListener('DOMContentLoaded', function () {
        // eKYC Status Chart
        var ekycCtx = document.getElementById('ekycChart').getContext('2d');
        new Chart(ekycCtx, {
            type: 'pie',
            data: {
                labels: ['Verified', 'Not Verified'],
                datasets: [{
                    data: [{{ $ekycVerified }}, {{ $ekycNotVerified }}],
                    backgroundColor: ['#28a745', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
   
        // Other User Statistics Chart
        var userStatsCtx = document.getElementById('userStatsChart').getContext('2d');
        new Chart(userStatsCtx, {
            type: 'pie',
            data: {
                labels: ['Verified', 'Not Verified'],
                datasets: [{
                    data: [
                        {{ $emailVerified }}, 
                        {{ $totalUsers - $emailVerified }} // Calculate unverified users
                    ],
                    backgroundColor: ['#007bff', '#ffc107'] // Colors for verified and unverified
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                const value = tooltipItem.raw;
                                const total = {{ $totalUsers }};
                                const percentage = ((value / total) * 100).toFixed(2);
                                return `${tooltipItem.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });


    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('registrationsChart').getContext('2d');

        // Data from the backend
        const yearData = @json($yearData);
        const monthData = @json($monthData);
        const weekData = @json($weekData);

        // Chart initialization
        const registrationsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(weekData), // Default to week labels
                datasets: [{
                    label: 'Number of Registered Users',
                    data: Object.values(weekData), // Default to week data
                    backgroundColor: '#007bff',
                    borderColor: '#0056b3',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0 // Whole numbers only
                        }
                    }
                }
            }
        });

        // Button click handlers
        document.getElementById('weekBtn').addEventListener('click', function () {
            updateChart('week', weekData);
            setActiveButton('weekBtn');
        });

        document.getElementById('monthBtn').addEventListener('click', function () {
            updateChart('month', monthData);
            setActiveButton('monthBtn');
        });

        document.getElementById('yearBtn').addEventListener('click', function () {
            updateChart('year', yearData);
            setActiveButton('yearBtn');
        });

        // Update chart data
        function updateChart(range, data) {
            let labels, dataset;

            if (range === 'week') {
                labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                dataset = labels.map(day => data[day] || 0); // Fill missing days with 0
            } else if (range === 'month') {
                labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                dataset = labels.map((_, i) => data[i + 1] || 0); // Months are indexed 1-12
            } else {
                labels = Object.keys(data);
                dataset = Object.values(data);
            }

            registrationsChart.data.labels = labels;
            registrationsChart.data.datasets[0].data = dataset;
            registrationsChart.update();
        }

        // Highlight active button
        function setActiveButton(activeId) {
            ['weekBtn', 'monthBtn', 'yearBtn'].forEach(id => {
                document.getElementById(id).classList.toggle('btn-primary', id === activeId);
                document.getElementById(id).classList.toggle('btn-secondary', id !== activeId);
            });
        }

        // Set the default active button (week) on page load
        setActiveButton('weekBtn');
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Yearly Data
        const yearlyTransactionData = @json($yearlyTransactions);
        const yearlyLabels = Object.keys(yearlyTransactionData);
        const yearlyCounts = Object.values(yearlyTransactionData);

        // Monthly Data
        const monthlyTransactionData = @json($monthlyTransactions);
        const monthlyLabels = Object.keys(monthlyTransactionData).map(month => new Date(2023, month - 1, 1).toLocaleString('default', { month: 'long' }));
        const monthlyCounts = Object.values(monthlyTransactionData);

        // Weekly Data
        const weeklyTransactionData = @json($weeklyTransactions);
        const weeklyLabels = Object.keys(weeklyTransactionData);
        const weeklyCounts = Object.values(weeklyTransactionData);

         // Daily Data
        const dailyTransactionData = @json($dailyTransactions);
        const dailyLabels = Object.keys(dailyTransactionData);
        const dailyCounts = Object.values(dailyTransactionData);

        // Yearly Transactions Chart
        new Chart(document.getElementById('yearTransactionChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: yearlyLabels,
                datasets: [{
                    label: 'Transactions',
                    data: yearlyCounts,
                    backgroundColor: '#28a745',
                }]
            }
        });

        // Monthly Transactions Chart
        new Chart(document.getElementById('monthTransactionChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Transactions',
                    data: monthlyCounts,
                    backgroundColor: '#28a745',
                }]
            }
        });

        // Weekly Transactions Chart
        new Chart(document.getElementById('weekTransactionChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Transactions',
                    data: weeklyCounts,
                    backgroundColor: '#28a745',
                }]
            }
        });

        new Chart(document.getElementById('dayTransactionChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Transactions',
                    data: dailyCounts,
                    backgroundColor: '#28a745',
                }]
            }
        });
    });
</script>
   
</script>
@endsection