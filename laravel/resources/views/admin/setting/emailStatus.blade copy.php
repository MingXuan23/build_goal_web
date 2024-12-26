@extends('admin.layouts.main')
@section('container')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">
            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Email Status</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Email Status</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Page Header Close -->

            <!-- Start::row-1 -->
            <div class="row">
                <div class="col-xl-12">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill fs-4"></i>
                            </svg>
                            <div class="ms-3 fw-bold"> {{ session('success') }} </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        @php
                            $errors = is_array(session('error')) ? session('error') : [session('error')];
                        @endphp

                        @foreach ($errors as $error)
                            <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                                <i class="bi bi-dash-circle-fill fs-4"></i>
                                <div class="ms-3 fw-bold"> {{ $error }} </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endforeach
                    @endif


                    <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title">Email Status For send Content Notification</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-bordered table-hover text-nowrap w-100 data-table">
                                    <thead>

                                        <tr>
                                            <th>No.</th>
                                            <th>Email For</th>
                                            <th>Email Name</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End::row-1 -->
            @foreach ($datas as $data)
                <div class="modal fade" id="modalActive-{{ $data->id }}">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Update Email Status - {{ $data->name }}</h6><button
                                    aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{route('emailStatusUpdate',$data->id)}}" method="POST">
                                @csrf
                                <div class="modal-body text-start">

                                    <div class="col-sm-12">
                                        <div class="form-floating">
                                            <select class="form-select" id="floatingSelect"
                                                aria-label="Floating label select example" name="status" required>
                                                <option value="1" @if ($data->status == 1) selected @endif>
                                                    ACTIVE</option>
                                                <option value="0" @if ($data->status == 0) selected @endif>
                                                    INACTIVE</option>
                                            </select>
                                            <label for="floatingSelect">Account Status</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary ">Update</button>
                                    <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: "{{ route('emailStatus') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: ((data, type, row) => {
                            return data.toUpperCase();
                        })

                    },
                    {
                        data: 'email_name',
                        name: 'email_name',

                    },
                    {
                        data: 'active',
                        name: 'active',

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

