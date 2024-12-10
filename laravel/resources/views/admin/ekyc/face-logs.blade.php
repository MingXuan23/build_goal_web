@extends('admin.layouts.main')

@section('container')
    <div class="main-content app-content">
        <div class="container">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">e-KYC Face Logs</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Face Logs</li>
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
                <div class="card-header">
                    <div class="card-title">Face Log for xBug</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap data-table">
                            <thead class="table-borderless">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Request ID</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Response</th>
                                    <th scope="col">Compare With</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Time (s)</th>
                                    <th scope="col">DNS</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('showFaceLogs') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'requestId',
                        name: 'requestId'
                    },
                    {
                        data: 'requestedBy',
                        name: 'requestedBy'
                    },
                    {
                        data: 'res',
                        name: 'res'
                    },
                    {
                        data: 'compareWith',
                        name: 'compareWith'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'responseTime',
                        name: 'responseTime'
                    },
                    {
                        data: 'domain',
                        name: 'domain'
                    },
                    {
                        data: 'verifiedAt',
                        name: 'verifiedAt'
                    },
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
                ],
                "language": {
                    "emptyTable": "No records found"
                }
            });
        });
    </script>

    <style>
        .table td {
            word-wrap: break-word; /* Membenarkan teks untuk dibungkus pada baris baru */
            white-space: normal; /* Menetapkan teks supaya tidak dipaksa ke satu baris */
        }
    </style>
@endsection
