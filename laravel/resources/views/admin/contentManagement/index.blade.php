@extends('admin.layouts.main')
@section('container')

    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">
            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Content Management</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Content Management</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Page Header Close -->
            <!-- Start::row-1 -->
             <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Applied Contents</div>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap data-table">
                        <thead class="table-borderless">
                            <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Content Name</th>
                            <th scope="col">Applied On</th>
                            <th scope="col">Details</th>
                            <th scope="col">Organization</th>
                            <th scope="col">Status</th>
                            </tr>
                        </thead>
                    </table>        
                </div>
             </div>
            <!--End::row-1 -->
        </div>
    </div>
    @foreach ($content_data as $data)
        <div class="modal fade" id="modalView-{{ $data->id }}">

            <div class="modal-dialog modal-dialog-centered text-center modal-xl">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">View Content - {{ $data->name }} </h6>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    
                        @csrf
                        <div class="modal-body text-start">
                            <form action="#" method="POST">
                                @csrf
                                <!-- Content Details -->
                                <div class="mb-3">
                                    <label for="content_id" class="form-label">Content ID</label>
                                    <input type="text" class="form-control" id="content_id" name="content_id"
                                        value="{{ $data->id }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="content_name" class="form-label">Content Name</label>
                                    <input type="text" class="form-control" id="content_name" name="content_name"
                                        value="{{ $data->name }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="applied_on" class="form-label">Link</label>
                                    <input type="text" class="form-control" id="link" name="link"
                                        value="{{ $data->link }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="applied_on" class="form-label">Applied On</label>
                                    <input type="text" class="form-control" id="created_at" name="created_at"
                                        value="{{ $data->created_at }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="enrollment_price" class="form-label">Enrollment Price</label>
                                    <input type="text" class="form-control" id="enrollment_price" name="enrollment_price"
                                        value="{{ $data->enrollment_price }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="content_type" class="form-label">Content Type</label>
                                    <input type="text" class="form-control" value="{{ $data->content_type_name  }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="place" class="form-label">Place</label>
                                    <input type="text" class="form-control" id="place" name="place"
                                        value="{{ $data->place }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="participant_limit" class="form-label">Participant Limit</label>
                                    <input type="text" class="form-control" id="participant_limit" name="participant_limit"
                                        value="{{ $data->participant_limit }}" readonly>
                                </div>
                            </form>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for approval/rejection -->
<div class="modal fade" id="approveRejectModal-{{ $data->id }}" tabindex="-1" aria-labelledby="approveRejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveRejectModalLabel">Do you want to approve or reject this content?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for approval -->
                <form action="{{ route('approveContent', $data->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Approve</button>
                </form>

                <!-- Form for rejection -->
                <form action="#" method="POST" id="rejectForm-{{ $data->id }}" data-bs-toggle="modal" data-bs-target="#rejectReasonModal-{{ $data->id }}">
                    @csrf
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectReasonModal-{{ $data->id }}">Reject</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Reason Modal -->
<div class="modal fade" id="rejectReasonModal-{{ $data->id }}" tabindex="-1" aria-labelledby="rejectReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectReasonModalLabel">Provide Reason for Rejection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rejectContent', $data->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Reason</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </form>
            </div>
        </div>
    </div>
</div>
    @endforeach

    <script>
        $(document).ready(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: "{{ route('showContentAdmin') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        // visible:false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        // render: ((data, type, row) => {
                        //     return data.toUpperCase();
                        // })

                    },
                    {
                        data: 'action',
                        name: 'action',

                    },
                    {
                        data: 'user_id',
                        name: 'user_id',

                    },
                    {
                        data: 'approve',
                        name: 'approve',

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
                    
                ]
            });
        })
    </script>
@endsection


{{-- <div class="d-flex justify-content-between"><span class="badge bg-' . $statusClass . '-transparent p-2 me-1">' .
        $messageActive . '</span><button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill "
        data-bs-toggle="modal" data-bs-target="#modalEkyc-' . $row->id . '">
        <i class="ri-edit-line"></i>
    </button>
</div> --}}
