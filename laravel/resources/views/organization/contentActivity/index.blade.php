@extends('organization.layouts.main')

@section('container')
    <style>
        .wrap-text {
            white-space: normal !important;
            word-wrap: break-word;
        }
    </style>
    <div class="main-content app-content">
        <div class="container">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Content User (Clicked)</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Content User</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if (session()->has('status'))
                <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                    <div class="ms-3"> {{ session('status') }} </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">List Content User (Clicked)</div>
                    <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#viewAllContentClickedViewed">
                        List Paid Content
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap data-table">
                            <thead class="table-borderless">
                                <tr>
                                    <th scope="col">No.</th>
                                    {{-- <th scope="col">Content Owner</th> --}}
                                    <th scope="col">Content Name</th>
                                    <th scope="col">Interaction Type</th>
                                    <th scope="col">Total Click</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($datas as $data)
        <div class="modal fade" id="modalView-{{ $data->content_id }}">
            <div class="modal-dialog modal-dialog-centered text-center modal-lg modal-dialog-scrollable">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Content Detail - {{ strtoupper($data->name) }}</h6>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">

                        <div id="chart-container-{{ $data->content_id }}"
                            class="d-flex justify-content-center align-items-center">
                            <canvas id="chart-{{ $data->content_id }}" width="400" height="200"></canvas>
                        </div>
                        <div id="modal-table-{{ $data->content_id }}"></div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <div class="modal fade" id="viewAllContentClickedViewed">
        <div class="modal-dialog modal-dialog-centered text-center modal-xl modal-dialog-scrollable">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Content Promotion Active</h6>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Table -->
                    <table id="contentActiveTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Owner Name</th>
                                <th>Content Name</th>
                                <th>Content Type</th>
                                <th>Payment Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated dynamically -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            // Define your PHP variable to JavaScript
            var dataContentActive = @json($dataContentActive);

            // Populate the table dynamically
            var tableBody = '';
            dataContentActive.forEach(function(item, index) {
                tableBody += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.user_name}</td>
                        <td>${item.content_name}</td>
                        <td>${item.content_type_name}</td>
                        <td>${item.transaction_updated_at}</td>
                    </tr>
                `;
            });

            // Append rows to the table
            $('#contentActiveTable tbody').html(tableBody);

            // Initialize DataTables
            $('#contentActiveTable').DataTable({
                "autoWidth": false,
                "columnDefs": [{
                        "className": "text-start",
                        "targets": "_all"
                    } // Apply text-start to all columns
                ]
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('showContentUserClickedViewedOrganization') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    // {
                    //     data: 'content_owner_email',
                    //     name: 'content_owner_email'
                    // },
                    {
                        data: 'name',
                        name: 'name',
                        render: (data, type, row) => {
                            return `<div class="wrap-text">${data.toUpperCase()}</div>`;
                        }
                    },
                    {
                        data: 'interaction_type',
                        name: 'interaction_type'
                    },
                    {
                        data: 'totalInteractions',
                        name: 'totalInteractions'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: 'Copy Data',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'Export CSV',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Export Excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'Export PDF',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print Data',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            });

            $(document).on('click', '.btn-info-transparent', function() {
                var contentId = $(this).data('content-id');
                var interactionType = $(this).data('interaction-type');

                $.ajax({
                    url: '/admin/content-detail/' + contentId + '/' + interactionType,
                    method: 'GET',
                    success: function(response) {
                        var modalBody = $('#modalView-' + contentId + ' .modal-body');
                        modalBody.empty();

                        modalBody.append(`
                           <div class="d-flex align-items-center justify-content-center">
                                <div class="me-3">
                                   
                                    <div class="input-group">
                                        <label for="start_date" class="form-label mt-2 me-2">Start Date:</label>
                                        <div class="input-group-text text-muted">
                                            <i class="ri-calendar-line"></i>
                                        </div>
                                        <input type="text" class="form-control" id="start_date-${contentId}" placeholder="Choose start date">
                                    </div>
                                </div>

                                <div class="me-3">
                                    <div class="input-group">
                                        <label for="end_date" class="form-label mt-2 me-2">End Date:</label>
                                        <div class="input-group-text text-muted">
                                            <i class="ri-calendar-line"></i>
                                        </div>
                                        <input type="text" class="form-control" id="end_date-${contentId}" placeholder="Choose end date">
                                    </div>
                                </div>

                                <button class="btn btn-primary  px-4" id="filterBtn-${contentId}">Filter</button>
                            </div>


                            <div id="chart-container-${contentId}" style="height: 400px; margin-bottom: 20px; margin-top: 20px">
                                <canvas id="chart-${contentId}" width="400" height="200"></canvas>
                            </div>
                            <div id="modal-table-${contentId}"></div>
                        `);
                        let i = 1;
                        var tableHtml = `
                            <table class="table table-striped" id="contentDetailTable-${contentId}">
                                <thead>
                                    <tr>                            
                                        <th>No.</th>
                                        <th>Interaction Type</th>
                                        <th>Clicked From</th>
                                        <th>Clicked At</th>                                   
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        response.forEach(function(item) {
                            tableHtml += `
                                <tr>                       
                                    <td>${i++}</td> 
                                    <td>${item.interaction_type}</td> 
                                    <td>Mobile xBug App</td>                        
                                    <td>${item.content_user_created_at}</td>
                                </tr>
                            `;
                        });

                        tableHtml += `</tbody></table>`;
                        modalBody.append(tableHtml);
                        $('#contentDetailTable-' + contentId + ' td').css('text-align', 'left');
                        $('#contentDetailTable-' + contentId).DataTable();

                        $('#modalView-' + contentId).on('shown.bs.modal', function() {
                            var ctx = document.getElementById('chart-' + contentId);

                            if (ctx) {
                                // Periksa apakah chart sudah ada, jika ya, hancurkan dulu
                                var existingChart = Chart.getChart(
                                    ctx
                                ); // Mendapatkan chart yang terkait dengan canvas
                                if (existingChart) {
                                    existingChart.destroy(); // Hancurkan chart lama
                                }

                                var labels = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri',
                                    'Sat'
                                ];
                                var colors = {
                                    'Sun': 'rgba(255, 99, 132, 0.2)',
                                    'Mon': 'rgba(54, 162, 235, 0.2)',
                                    'Tue': 'rgba(255, 159, 64, 0.2)',
                                    'Wed': 'rgba(75, 192, 192, 0.2)',
                                    'Thu': 'rgba(153, 102, 255, 0.2)',
                                    'Fri': 'rgba(255, 159, 64, 0.2)',
                                    'Sat': 'rgba(255, 205, 86, 0.2)'
                                };

                                var hourlyClicks = Array(7).fill().map(() => Array(24)
                                    .fill(0));

                                response.forEach(function(item) {
                                    var createdAt = new Date(item
                                        .content_user_created_at);
                                    var dayOfWeek = createdAt.getDay();
                                    var hour = createdAt.getHours();

                                    hourlyClicks[dayOfWeek][hour] += 1;
                                });

                                var datasets = labels.map(function(label, index) {
                                    return {
                                        label: label,
                                        data: hourlyClicks[index],
                                        backgroundColor: colors[label],
                                        borderColor: colors[label].replace(
                                            '0.2', '1'),
                                        borderWidth: 1
                                    };
                                });

                                // Buat chart baru
                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: Array.from({
                                            length: 24
                                        }, (_, i) => `${i}:00`),
                                        datasets: datasets
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            x: {
                                                title: {
                                                    display: true,
                                                    text: 'Hour of the Day'
                                                }
                                            },
                                            y: {
                                                title: {
                                                    display: true,
                                                    text: 'Click Count'
                                                },
                                                beginAtZero: true,
                                                ticks: {
                                                    stepSize: 1,
                                                    callback: function(value) {
                                                        return Math.round(
                                                            value);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                        });


                        flatpickr("#start_date-" + contentId, {
                            dateFormat: "Y-m-d", // Format tanggal (tahun-bulan-hari)
                            defaultDate: "today"
                        });

                        flatpickr("#end_date-" + contentId, {
                            dateFormat: "Y-m-d", // Format tanggal (tahun-bulan-hari)
                            defaultDate: "today"
                        });

                        // Filtering by Date Range
                        $('#filterBtn-' + contentId).click(function() {
                            var startDate = $('#start_date-' + contentId).val();
                            var endDate = $('#end_date-' + contentId).val();

                            var filteredData = response.filter(function(item) {
                                var itemDate = new Date(item
                                        .content_user_created_at).toISOString()
                                    .split('T')[0];
                                return itemDate >= startDate && itemDate <=
                                    endDate;
                            });

                            var filteredLabels = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu',
                                'Fri', 'Sat'
                            ];
                            var filteredHourlyClicks = Array(7).fill().map(() => Array(
                                24).fill(0));

                            filteredData.forEach(function(item) {
                                var createdAt = new Date(item
                                    .content_user_created_at);
                                var dayOfWeek = createdAt.getDay();
                                var hour = createdAt.getHours();

                                filteredHourlyClicks[dayOfWeek][hour] += 1;
                            });

                            // Define an array of unique colors for each day
                            var filteredColors = {
                                'Sun': 'rgba(255, 99, 132, 0.2)',
                                'Mon': 'rgba(54, 162, 235, 0.2)',
                                'Tue': 'rgba(255, 159, 64, 0.2)',
                                'Wed': 'rgba(75, 192, 192, 0.2)',
                                'Thu': 'rgba(153, 102, 255, 0.2)',
                                'Fri': 'rgba(255, 159, 64, 0.2)',
                                'Sat': 'rgba(255, 205, 86, 0.2)'
                            };

                            var filteredDatasets = filteredLabels.map(function(label,
                                index) {
                                return {
                                    label: label,
                                    data: filteredHourlyClicks[index],
                                    backgroundColor: filteredColors[
                                        label
                                    ], // Assign the unique color for each label
                                    borderColor: filteredColors[label].replace(
                                        '0.2', '1'
                                    ), // Replace the alpha value for the border color
                                    borderWidth: 1
                                };
                            });

                            // Destroy existing chart if any
                            var existingChart = Chart.getChart('chart-' +
                                contentId); // Get existing chart
                            if (existingChart) {
                                existingChart.destroy(); // Destroy the old chart
                            }

                            var ctx = document.getElementById('chart-' + contentId);
                            if (ctx) {
                                // Create a new chart with the filtered data
                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: Array.from({
                                            length: 24
                                        }, (_, i) => `${i}:00`),
                                        datasets: filteredDatasets
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            x: {
                                                title: {
                                                    display: true,
                                                    text: 'Hour of the Day'
                                                }
                                            },
                                            y: {
                                                title: {
                                                    display: true,
                                                    text: 'Click Count'
                                                },
                                                beginAtZero: true,
                                                ticks: {
                                                    stepSize: 1,
                                                    callback: function(value) {
                                                        return Math.round(
                                                            value
                                                        );
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
