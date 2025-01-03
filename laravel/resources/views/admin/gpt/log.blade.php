@extends('admin.layouts.main')
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
                <h1 class="page-title fw-semibold fs-18 mb-0">xBug GPT Log</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">xBug GPT Log</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Cost Data Table -->
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">xBug GPT Log Detail</div>
                    <span>P (T): Prompt Tokens, C (T): Completion Tokens, T (T): Total Tokens</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Model</th>
                                    <th>Request By</th>
                                    <th>P (T)</th>
                                    <th>C (T)</th>
                                    <th>T (T)</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('showGptLog') }}", // Update with your correct route
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: (data, type, row) => {
                            return `<div class="wrap-text fw-bold">${data.toUpperCase()}</div>`;
                        }
                    },
                    {
                        data: 'model',
                        name: 'model'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'prompt_tokens',
                        name: 'prompt_tokens'
                    },
                    {
                        data: 'completion_tokens',
                        name: 'completion_tokens'
                    },
                    {
                        data: 'total_tokens',
                        name: 'total_tokens',
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: 'Copy Data'
                    },
                    {
                        extend: 'csv',
                        text: 'Export CSV'
                    },
                    {
                        extend: 'excel',
                        text: 'Export Excel'
                    },
                    {
                        extend: 'pdf',
                        text: 'Export PDF'
                    },
                    {
                        extend: 'print',
                        text: 'Print Data'
                    }
                ],
                language: {
                    emptyTable: "No Data available"
                }
            });
        });
    </script>

    <style>
        .table td {
            word-wrap: break-word;
            white-space: normal;
        }
    </style>
@endsection
