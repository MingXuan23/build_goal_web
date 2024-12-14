@extends('admin.layouts.main')
@section('container')
    <div class="main-content app-content">
        <div class="container">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">xBug Cost & API Keys</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">xBug Cost & API Keys</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Cost Data Table -->
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">xBug Cost Logs</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Amount</th>
                                    <th>Currency</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- API Keys Data Table -->
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">xBug API Key Information</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>DNS</th>
                                    <th>Owner</th>
                                    <th>Email</th>
                                    <th>Id User</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $apiKeys['object'] ?? 'N/A' }}</td>
                                    <td>{{ $apiKeys['name'] ?? 'N/A' }}</td>
                                    <td>{{ $apiKeys['owner']['user']['name'] ?? 'N/A' }}</td>
                                    <td>{{ $apiKeys['owner']['user']['email'] ?? 'N/A' }}</td>
                                    <td>{{ $apiKeys['owner']['user']['id'] ?? 'N/A' }}</td>
                                    <td>{{ date('Y-m-d H:i:s', $apiKeys['created_at'] ?? time()) }}</td>
                                </tr>
                            </tbody>
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
                ajax: "{{ route('getUsage') }}",  // Update with your correct route
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'start_time', name: 'start_time' },
                    { data: 'end_time', name: 'end_time' },
                    { data: 'amount', name: 'amount' },
                    { data: 'currency', name: 'currency' },
                ],
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: 'Copy Data' },
                    { extend: 'csv', text: 'Export CSV' },
                    { extend: 'excel', text: 'Export Excel' },
                    { extend: 'pdf', text: 'Export PDF' },
                    { extend: 'print', text: 'Print Data' }
                ],
                language: {
                    emptyTable: "No costs available"
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
