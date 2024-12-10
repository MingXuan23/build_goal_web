@extends('admin.layouts.main')
@section('container')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">
            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Package Management</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Package Management</li>
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
                            <div class="card-title">List All Package</div>
                            <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalAdd">
                                Add New package
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-bordered table-hover text-nowrap w-100 data-table">
                                    <thead>

                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Estimate User</th>
                                            <th>Estimate Price ( RM )</th>
                                            <th>Estimate State</th>
                                            <th>Status</th>
                                            <th>Action</th>
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
                                <h6 class="modal-title">Update Account Status - {{ $data->name }}</h6><button
                                    aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="" method="POST">
                                @csrf
                                <div class="modal-body text-start">

                                    <div class="col-sm-12">
                                        <div class="form-floating">
                                            <select class="form-select" id="floatingSelect"
                                                aria-label="Floating label select example" name="status" required>
                                                <option value="1" @if ($data->status == 1) selected @endif>
                                                    ACTIVE</option>
                                                <option value="0" @if ($data->status == 0) selected @endif>
                                                    DISABLE</option>
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

            @foreach ($datas as $data)
                <div class="modal fade" id="modalView-{{ $data->id }}">
                    <div
                        class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">View Package - {{ $data->name }} </h6>
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="" method="POST">
                                @csrf
                                <div class="modal-body text-start">

                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            <p class="fw-semibold mt-2">Package Details</p>
                                            <hr>
                                            <div class="row gy-2">

                                                <div class="col-xl-12">
                                                    <div class="form-floating">
                                                        <input disabled type="text" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->name }}">
                                                        <label for="floatingInputprimary">Package Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-floating">
                                                        <input disabled type="text" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->estimate_user }}">
                                                        <label for="floatingInputprimary">Package Estimate User</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-floating">
                                                        <input disabled type="email" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->base_price }}">
                                                        <label for="floatingInputprimary">Package Base Price</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="form-floating">
                                                        <input disabled type="number" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="{{ $data->base_state }}">
                                                        <label for="floatingInputprimary">Package Base State</label>
                                                    </div>
                                                </div>
                
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $data->id }}">
                                        Delete
                                    </button>
                                    <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>



                        </div>
                    </div>
                </div>
            @endforeach

            @foreach ($datas as $data)
                <div class="modal fade" id="modalUpdate-{{ $data->id }}">
                        <div
                            class="modal-dialog modal-dialog-centered text-center">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">View Package - {{ $data->name }} </h6>
                                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form action="" method="POST">
                                    @csrf
                                    <div class="modal-body text-start">

                                        <div class="row p-2">
                                            <div class="col-md-12">
                                                <p class="fw-semibold mt-2">Package Details</p>
                                                <hr>
                                                <div class="row gy-2">

                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control"
                                                                id="floatingInputprimary" placeholder="name@example.com"
                                                                value="{{ $data->name }}">
                                                            <label for="floatingInputprimary">Package Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control"
                                                                id="floatingInputprimary" placeholder="name@example.com"
                                                                value="{{ $data->estimate_user }}">
                                                            <label for="floatingInputprimary">Package Estimate User</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="form-floating">
                                                            <input type="email" class="form-control"
                                                                id="floatingInputprimary" placeholder="name@example.com"
                                                                value="{{ $data->base_price }}">
                                                            <label for="floatingInputprimary">Package Base Price</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="form-floating">
                                                            <input type="number" class="form-control"
                                                                id="floatingInputprimary" placeholder="name@example.com"
                                                                value="{{ $data->base_state }}">
                                                            <label for="floatingInputprimary">Package Base State</label>
                                                        </div>
                                                    </div>
                    
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $data->id }}">
                                            Update
                                        </button>
                                        <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
            @endforeach

                <div class="modal fade" id="modalAdd">
                    <div
                        class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Add New Package</h6>
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="" method="POST">
                                @csrf
                                <div class="modal-body text-start">

                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            <p class="fw-semibold mt-2">Package Details</p>
                                            <hr>
                                            <div class="row gy-2">

                                                <div class="col-xl-12">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="">
                                                        <label for="floatingInputprimary">Package Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="">
                                                        <label for="floatingInputprimary">Package Estimate User</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-floating">
                                                        <input type="email" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="">
                                                        <label for="floatingInputprimary">Package Base Price</label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control"
                                                            id="floatingInputprimary" placeholder="name@example.com"
                                                            value="">
                                                        <label for="floatingInputprimary">Package Base State</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-floating">
                                                        <select class="form-select" id="floatingSelect"
                                                            aria-label="Floating label select example" name="status" required>
                                                            <option value="" disabled selected>
                                                                - Select Status -</option>
                                                            <option value="1">
                                                                ACTIVE</option>
                                                            <option value="0">
                                                                DISABLE</option>
                                                        </select>
                                                        <label for="floatingSelect">Account Status</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-success">
                                        Add Package
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                    @foreach ($datas as $data)
                        <form action="" method="post">
                            @csrf
                            @method('DELETE')
                            <div class="modal fade" id="delete{{ $data->id }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="deleteLabel">Delete Confirmation
                                            </h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="fw-bold text-muted">Are Sure to Delete Account for {{ $data->name }} ? This action can't be undo !</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Confirm</button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
                ajax: "{{ route('showPackage') }}",
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
                        data: 'estimate_user',
                        name: 'estimate_user',

                    },
                    {
                        data: 'base_price',
                        name: 'base_price',

                    },
                    {
                        data: 'base_state',
                        name: 'base_state',

                    },
                    {
                        data: 'active',
                        name: 'active',

                    },
                    {
                        data: 'action',
                        name: 'action',
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
        })
    </script>
@endsection

