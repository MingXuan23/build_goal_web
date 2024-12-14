@extends('admin.layouts.main')
@section('container')
    <div class="main-content app-content">
        <div class="container">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">xBug GPT Model</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">xBug GPT Model</li>
                        </ol>
                    </nav>
                </div>
            </div>
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
            <!-- Cost Data Table -->
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">xBug GPT Model Detail</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Model Name</th>
                                    <th>Provider</th>
                                    <th>Max Token</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($datas as $data)
        <div class="modal fade" id="modalUpdateStatus-{{ $data->id }}">
            <div class="modal-dialog modal-dialog-centered text-center">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Update Status Model - {{ $data->model_name }}</h6><button
                            aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('updateGptModelStatus', $data->id) }}" method="POST">
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
                                    <label for="floatingSelect">Model Status</label>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary ">Change</button>
                            <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($datas as $data)
        <div class="modal fade" id="modalUpdateModel-{{ $data->id }}">
            <div class="modal-dialog modal-dialog-centered text-center">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Update Model - {{ $data->model_name }}</h6><button
                            aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('updateGptModel', $data->id) }}" method="POST">
                        @csrf
                        <div class="modal-body text-start">
                            <div class="col-sm-12">
                                <div class="col-xl-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control"
                                            id="floatingInputprimary" placeholder="name@example.com"
                                            value="{{ $data->model_name }}" name="model_name">
                                        <label for="floatingInputprimary">Model Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <div class="col-xl-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control"
                                            id="floatingInputprimary" placeholder="name@example.com"
                                            value="{{ $data->provider }}" name="provider">
                                        <label for="floatingInputprimary">Provider</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <div class="col-xl-12">
                                    <div class="form-floating">
                                        <input type="number" class="form-control"
                                            id="floatingInputprimary" placeholder="name@example.com"
                                            value="{{ $data->max_token }}" name="max_token">
                                        <label for="floatingInputprimary">Max Token</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary ">Change</button>
                            <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('showGptModel') }}",  // Update with your correct route
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'model_name', name: 'model_name' },
                    { data: 'provider', name: 'provider' },
                    { data: 'max_token', name: 'max_token' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' },
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
