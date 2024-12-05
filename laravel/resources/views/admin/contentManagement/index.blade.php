@extends('admin.layouts.main')
@section('container')
    {{-- @dd($content_data); --}}
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
            @if (session()->has('status'))
                <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                    </svg>
                    <div class="ms-3"> {{ session('status') }} </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Applied Contents</div>
                </div>
                <div class="card-body">

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
            </div>
            <!--End::row-1 -->
        </div>
    </div>
    @foreach ($content_data as $data)
        <div class="modal fade" id="modalView-{{ $data->id }}" ria-labelledby="exampleModalScrollable"
            data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered text-center modal-md modal-dialog-scrollable">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">CONTENT DETAIL - {{ $data->name }} </h6>
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>


                    @csrf
                    <div class="modal-body text-start">
                        <form action="#" method="POST">
                            @csrf
                            <!-- Content Details -->
                            <div class="mb-2">
                                <div class="col-xl-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" placeholder="Enter Content Name"
                                            value="{{ $data->name }}" readonly>
                                        <label for="contentName">Content Name</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="col-xl-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" placeholder="Enter Content Name"
                                            value="{{ $data->link }}" readonly>
                                        <label for="contentName">Content Link</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="col-xl-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" placeholder="Enter Content Name"
                                            value="{{ $data->created_at }}" readonly>
                                        <label for="contentName">Content Link</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="col-xl-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" placeholder="Enter Content Name"
                                            value="{{ $data->enrollment_price }}" readonly>
                                        <label for="contentName">Content Link</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="col-xl-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" placeholder="Enter Content Name"
                                            value="{{ $data->content_type_name }}" readonly>
                                        <label for="contentName">Content Type</label>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Select States</label>
                                <div id="state-container"
                                    style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                    @php
                                        $userStates = json_decode($data->state) ?? [];
                                    @endphp
                                    @foreach (array_keys($stateCities) as $state)
                                        <div class="form-check form-check-lg">
                                            <input
                                                class="form-check-input state-checkbox @error('states') is-invalid @enderror"
                                                type="checkbox" name="states[]" value="{{ $state }}"
                                                id="state-{{ $state }}"
                                                @if (in_array($state, $userStates)) checked @endif disabled>
                                            <label class="form-check-label" for="state-{{ $state }}">
                                                {{ $state }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <div class="mb-2">
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" placeholder="Enter Content Name"
                                                value="{{ $data->place }}" readonly>
                                            <label for="contentName">Content Place</label>
                                        </div>
                                    </div>
                                    
                            </div>

                            <div class="mb-2">
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" placeholder="Enter Content Name"
                                                value="{{ $data->participant_limit }}" readonly>
                                            <label for="contentName">Content Participant Limit</label>
                                        </div>
                                    </div>
                            </div>
                        </form>

                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for approval/rejection -->
        <div class="modal fade" id="approveRejectModal-{{ $data->id }}" tabindex="-1"
            aria-labelledby="approveRejectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="approveRejectModalLabel">Confrimation Status?</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for approval -->
                        <span class="text-muted fw-semibold">Please carefully evaluate the content and select your choice
                            to either approve or reject it based on your review.</span>
                        <div class="d-flex justify-content-end ">

                            <form class="me-2" action="{{ route('approveContent', $data->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>

                            <!-- Form for rejection -->
                            <form action="#" method="POST" id="rejectForm-{{ $data->id }}"
                                data-bs-toggle="modal" data-bs-target="#rejectReasonModal-{{ $data->id }}">
                                @csrf
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#rejectReasonModal-{{ $data->id }}">Reject</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejection Reason Modal -->
        <div class="modal fade" id="rejectReasonModal-{{ $data->id }}" tabindex="-1"
            aria-labelledby="rejectReasonModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="rejectReasonModalLabel">Provide Reason for Rejection</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('rejectContent', $data->id) }}" method="POST">
                            @csrf
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="rejection_reason" class="form-label">Reason</label>
                                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 d-flex justify-content-end"> <button type="submit"
                                        class="btn btn-danger">Reject</button></div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewRejectModal-{{ $data->id }}" tabindex="-1"
            aria-labelledby="viewRejectModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="viewRejectModal">Rejection Reason for - {{ $data->name }}</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="rejection_reason" class="form-label">Reason</label>
                                    <textarea class="form-control" id="rejection_reason" name="rejection_reason" required>{{ $data->reject_reason }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-end">
                                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                            </div>
                        </div>
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
                        // exportOptions: {
                        //     columns: ':not(:last-child)'
                        // }
                    },
                    {
                        extend: 'csv',
                        text: 'Export CSV',
                        // exportOptions: {
                        //     columns: ':not(:last-child)'
                        // }
                    },
                    {
                        extend: 'excel',
                        text: 'Export Excel',
                        // exportOptions: {
                        //     columns: ':not(:last-child)'
                        // }
                    },
                    {
                        extend: 'pdf',
                        text: 'Export PDF',
                        // exportOptions: {
                        //     columns: ':not(:last-child)'
                        // }
                    },
                    {
                        extend: 'print',
                        text: 'Print Data',
                        // exportOptions: {
                        //     columns: ':not(:last-child)'
                        // }
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
