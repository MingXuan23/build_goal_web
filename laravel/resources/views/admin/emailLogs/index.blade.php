@extends('admin.layouts.main')

@section('container')
<div class="main-content app-content">
    <div class="container">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">Email Logs</h1>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Email Logs</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-nowrap data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Email Type</th>
                                <th>Name</th>
                                <th>Recipient Email</th>
                                <th>Sender Email</th>
                                <th>Status</th>
                                <th>Response</th>
                                <th>Date</th>
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
            ajax: "{{ route('showEmailLogs') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
                { data: 'email_type', name: 'email_type' },
                { data: 'name', name: 'name' },
                { data: 'recipient_email', name: 'recipient_email' },
                { data: 'from_email', name: 'from_email' },
                { data: 'status', name: 'status' },
                { data: 'response_data', name: 'response_data' },
                { data: 'created_at', name: 'created_at' }
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
                emptyTable: "No logs available"
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
