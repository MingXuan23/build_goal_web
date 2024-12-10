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
                <div class="col-xl-6">
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
   
</script>
@endsection