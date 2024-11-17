@extends('admin.layouts.main')
@section('container')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">User Management</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Management</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->


        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">List All User</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file-export" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Ic Number</th>
                                        <th>Full Name</th>
                                        <th>Organization Name</th>
                                        {{-- <th>Email Address</th> --}}
                                        <th>Email Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        {{-- <td>System Architect</td> --}}
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td><span class="badge bg-danger-transparent">Not Verify</span></td>
                                        <td>
                                            <button class="btn btn-icon btn-sm btn-info-transparent rounded-pill" data-bs-toggle="modal" data-bs-target="#modalView-1">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill" data-bs-toggle="modal" data-bs-target="#modalUpdate-1">
                                                <i class="ri-edit-line"></i>
                                            </button>
                        
                                            <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" id="alert-confirm-1">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        {{-- <td>System Architect</td> --}}
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td><span class="badge bg-success-transparent">Verify</span></td>
                                        <td>
                                            <button class="btn btn-icon btn-sm btn-info-transparent rounded-pill" data-bs-toggle="modal" data-bs-target="#modalView-2">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            <button class="btn btn-icon btn-sm btn-warning-transparent rounded-pill" data-bs-toggle="modal" data-bs-target="#modalUpdate-2">
                                                <i class="ri-edit-line"></i>
                                            </button>
                        
                                            <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" id="alert-confirm-2">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->

        <div class="modal fade" id="modalUpdate-1">
            <div class="modal-dialog modal-dialog-centered text-center">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Update Department</h6><button aria-label="Close"
                            class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="" method="POST">
                        @csrf
                        <div class="modal-body text-start">

                            <div class="col-sm-12">
                                <label for="input-placeholder" class="form-label ">Department Name <span
                                        class="text-danger fw-bold">*</span> </label>
                                <input type="text" class="form-control" name="dep_name"
                                    id="input-placeholder" >
                            </div>

                            <div class="col-sm-12">
                                <label for="faculty" class="form-label ">Faculty <span
                                        class="text-danger fw-bold">*</span> </label>
                                <select name="fac_id" id="faculty" class="form-select">
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                            <button type="button" class="btn btn-danger btn-sm"
                                data-bs-dismiss="modal">Close</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection