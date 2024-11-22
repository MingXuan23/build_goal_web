@extends('organization.layouts.main')
@section('container')
<!-- Start::app-content -->
<div class="main-content app-content">
   <div class="container">
      <!-- Page Header -->
      <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
         <h1 class="page-title fw-semibold fs-18 mb-0">Promote Your Content Here</h1>
         <div class="ms-md-1 ms-0">
            <nav>
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="#">Pages</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Promote Content</li>
               </ol>
            </nav>
         </div>
      </div>
      <!-- Page Header Close -->

      <!-- Start::row-1 -->
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
               <h4 class="card-title">Increase Your Content Views</h4>
               </div>
               <div class="card-body">
                  <!-- Promotion Form -->
                  <form action="#" method="POST">
                     @csrf
                     
                     <!-- Content Details -->
                     <div class="mb-3">
                        <label for="content_id" class="form-label">Content ID</label>
                        <input type="text" class="form-control" id="content_id" name="content_id" value="This will be the content id from the database" readonly>
                     </div>

                     <div class="mb-3">
                        <label for="content_name" class="form-label">Content Name</label>
                        <input type="text" class="form-control" id="content_name" name="content_name" value="This will be the Content Name from the database" readonly>
                     </div>

                     <!-- Package Selection -->
                     <div class="mb-3">
                        <label for="package" class="form-label">Choose Package </label>
                        <select class="form-select" id="package" name="Package" required>
                           <option value="" disabled selected>Choose Package  (package will be extracted from the database)</option>
                           <option value="1">Package A (Target Users: 50 - 100, Price: RM 100)</option>
                           <option value="2">Package B (Target Users: 101 - 200, Price: RM 200)</option>
                           <option value="3">Package C (Target Users: 201 - 300, Price: RM 300)</option>
                        </select>
                     </div>

                     <!-- State Selection -->
                     <div class="mb-3">
                        <label for="state" class="form-label">Choose State</label>
                        <select class="form-select" id="state" name="state" required>
                           <option value="" disabled selected>Select a state</option>
                           <option value="1">State A</option>
                           <option value="2">State B</option>
                           <option value="3">State C</option>
                        </select>
                     </div>

                     <!-- Submit Button -->
                     <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Promote</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!--End::row-1 -->
   </div>
</div>
@endsection
