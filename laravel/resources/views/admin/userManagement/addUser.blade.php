@extends('admin.layouts.main')
@section('container')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">Add New User</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add New User</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->


        <!-- Start::row-1 -->
        <form action="" method="POST">
            <div class="row">
                <div class="card custom-card">
                    <div class="card-header justify-content-between m-0 col-md-12">
                        <div class="card-title col-md-12">
                            Add New User
                        </div>
                    </div>
                    <div class="card-body col-md-12">
                        <div class="row">                           
                            <div class="col-md-6">
                                <p class="fw-semibold mt-2">Personal Details</p>
                                <hr>
                                <div class="row gy-2">
                                    
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Ic Number</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Full Name</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Email Address</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Phone Number</label>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Confirm Password</label>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-6">
                                <p class="fw-semibold mt-2">Organization Details</p>
                                <hr>
                                <div class="row gy-2">
                                    
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Organization Name</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Organization Address</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingInputprimary"
                                                placeholder="name@example.com">
                                            <label for="floatingInputprimary">Organization State</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-floating">
                                            <select class="form-select" id="floatingSelect"
                                                aria-label="Floating label select example">
                                                <option selected>- Select -</option>
                                                <option value="1">Company</option>
                                                <option value="2">Skill Training Organization</option>
                                            </select>
                                            <label for="floatingSelect">Organization Type</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">

                                    </div>
                                    <div class="col-md-2 text-end">
                                        <a href="./v.php" class="btn btn-warning btn-wave mt-5 px-4">Back</a>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit" class="btn btn-success mt-5 px-4" value="Add" name="Add" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!--End::row-1 -->

    </div>
</div>
@endsection