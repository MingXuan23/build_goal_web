@extends('admin.layouts.main')
@section('container')
<!-- Start::app-content -->
<div class="main-content app-content">
   <div class="container">
      <!-- Page Header -->
      <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
         <h1 class="page-title fw-semibold fs-18 mb-0">Main Dashboard</h1>
         <div class="ms-md-1 ms-0">
            <nav>
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="#">Pages</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Main Dashboard</li>
               </ol>
            </nav>
         </div>
      </div>
      <!-- Page Header Close -->
      <!-- Start::row-1 -->
      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
         <div class="card custom-card">
            <div class="card-body">
               <div class="row">
                  <div class="col-6 pe-0">
                     <p class="mb-2">
                        <span class="fs-16">Page Views</span>
                     </p>
                     <p class="mb-2 fs-12">
                        <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">27,146</span>
                        <span class="d-block fs-10 fw-semibold text-muted">THIS MONTH</span>
                     </p>
                     <a href="javascript:void(0);" class="fs-12 mb-0 text-primary">Show full stats<i class="ti ti-chevron-right ms-1"></i></a>
                  </div>
                  <div class="col-6">
                     <p class="badge bg-success-transparent float-end d-inline-flex"><i class="ti ti-caret-up me-1"></i>27%</p>
                     <p class="main-card-icon mb-0">
                        <svg class="svg-primary" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                           <path d="M0 0h24v24H0V0z" fill="none"/>
                           <path d="M13 4H6v16h12V9h-5V4zm3 14H8v-2h8v2zm0-6v2H8v-2h8z" opacity=".3"/>
                           <path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>
                        </svg>
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-12">
         <div class="card custom-card">
            <div class="card-header">
               <div class="card-title">Content Summary</div>
            </div>
            <div class="card-body">
               <div class="row gy-md-0 gy-3">
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
                     <div class="d-flex align-items-top">
                        <div class="me-3">
                           <span class="avatar avatar-rounded bg-light text-primary">
                           <i class="ti ti-files fs-18"></i>
                           </span>
                        </div>
                        <div>
                           <span class="d-block mb-1 text-muted">Contents Proposed</span>
                           <h6 class="fw-semibold mb-0">4</h6>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
                     <div class="d-flex align-items-top">
                        <div class="me-3">
                           <span class="avatar avatar-rounded bg-light text-secondary">
                           <i class="ti ti-file-check fs-18"></i>
                           </span>
                        </div>
                        <div>
                           <span class="d-block mb-1 text-muted">Approved Contents</span>
                           <h6 class="fw-semibold mb-0">4</h6>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
                     <div class="d-flex align-items-top">
                        <div class="me-3">
                           <span class="avatar avatar-rounded bg-light text-warning">
                           <i class="ti ti-file-dislike fs-18"></i>
                           </span>
                        </div>
                        <div>
                           <span class="d-block mb-1 text-muted">Rejected Contents</span>
                           <h6 class="fw-semibold mb-0">0</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card custom-card">
         <div class="card-header">
            <div class="card-title">Approved Content</div>
         </div>
         <div class="table-responsive">
            <table class="table text-nowrap">
               <thead class="table-borderless">
                  <tr>
                     <th scope="col">Content ID</th>
                     <th scope="col">Content Name</th>
                     <th scope="col">Approved</th>
                     <th scope="col">Status</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <th scope="row">Harshrath</th>
                     <td>#5182-3467</td>
                     <td>24 May 2022</td>
                     <td>
                        <button class="btn btn-sm btn-primary-light">Promote</button>
                     </td>
                  </tr>
                  <tr>
                     <th scope="row">Zozo Hadid</th>
                     <td>#5182-3412</td>
                     <td>02 July 2022</td>
                     <td>
                        <button class="btn btn-sm btn-primary-light">Promote</button>
                     </td>
                  </tr>
                  <tr>
                     <th scope="row">Martiana</th>
                     <td>#5182-3423</td>
                     <td>15 April 2022</td>
                     <td>
                        <button class="btn btn-sm btn-primary-light">Promote</button>
                     </td>
                  </tr>
                  <tr>
                     <th scope="row">Alex Carey</th>
                     <td>#5182-3456</td>
                     <td>17 March 2022</td>
                     <td>
                        <button class="btn btn-sm btn-primary-light">Promote</button>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <!--End::row-1 -->
   </div>
</div>
@endsection