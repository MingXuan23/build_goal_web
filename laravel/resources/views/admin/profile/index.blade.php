@extends('admin.layouts.main')
@section('container')
<!-- Start::app-content -->
<div class="main-content app-content">
<div class="container">
   <!-- Page Header -->
   <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
      <h1 class="page-title fw-semibold fs-18 mb-0">Profile</h1>
      <div class="ms-md-1 ms-0">
         <nav>
            <ol class="breadcrumb mb-0">
               <li class="breadcrumb-item"><a href="#">Pages</a></li>
               <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
         </nav>
      </div>
   </div>
   <!-- Page Header Close -->
   <!-- Start::row-1 -->
   <div class="row">
      <div class="col-xl-12">
         <div class="row">
            <div class="col-md-12">
               <div class="row">
                  <div class="col-md-12">
                     <div class="card custom-card">
                        <div class="card-body p-0">
                           <div class="">
                              <div class="">                          
                                 <ul class="nav nav-tabs nav-tabs-header mb-0 d-sm-flex d-block d-flex p-2 align-items-center justify-content-start" role="tablist">
                                    <li class="nav-item m-1">
                                       <a class="nav-link active" data-bs-toggle="tab" role="tab"
                                          aria-current="page" href="#your" aria-selected="true">Personal Details</a>
                                    </li>
                                    <li class="nav-item m-1">
                                       <a class="nav-link" data-bs-toggle="tab" role="tab"
                                          aria-current="page" href="#organization"
                                          aria-selected="true">Organization Details</a>
                                    </li>
                                    <li class="nav-item m-1">
                                       <a class="nav-link" data-bs-toggle="tab" role="tab"
                                          aria-current="page" href="#e-kyc"
                                          aria-selected="true">e-kyc Detail</a>
                                    </li>     
                                    <li class="nav-item m-1">
                                       <a class="nav-link" data-bs-toggle="tab" role="tab"
                                          aria-current="page" href="#change-password"
                                          aria-selected="true">Change Password</a>
                                    </li>                                
                                 </ul>                              
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  
                  <div class="col-md-12 mb-3">
                     <div class="alert alert-solid-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-lg"></i>Your account has not been verified because you have not completed the eKYC process. <a href="" class="fw-bold text-light">Click here</a> to complete your eKYC..
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="tab-content task-tabs-container">
                        <div class="tab-pane show active p-0" id="your" role="tabpanel">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="card custom-card overflow-hidden">
                                    <div class="card-body p-0">
                                       <div class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                                          <div>
                                             <span class="avatar avatar-xxl avatar-rounded online me-3">
                                             <img src="../../assets/images/user/avatar-1.jpg" alt="">
                                             </span>
                                          </div>
                                          <div class="flex-fill main-profile-info">
                                             <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="fw-bold mb-1 text-fixed-white mt-3 p-3">KHAIRUL ADZHAR</h6>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="p-4 border-bottom border-block-end-dashed">
                                          <span>
                                             <div class="col-md-12">
                                                <div class="row">
                                                   <div class="col-md-8">
                                                      <div class="form-floating mb-3">
                                                         <input type="text" class="form-control" id="floatingInput"
                                                             placeholder="Ic Number" value="010101010101">
                                                         <label for="floatingInput">Ic Number</label>
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 mb-3">
                                                      <div class="form-floating mb-3">
                                                         <input type="text" class="form-control" id="floatingInput"
                                                             placeholder="Full Name" value="KHAIRUL ADZHAR BIN NORAIDI">
                                                         <label for="floatingInput">Full Name</label>
                                                     </div>
                                                   </div>
                                                   <div class="col-md-3 mb-3">
                                                      <div class="form-floating mb-3">
                                                         <input type="email" class="form-control" id="floatingInput"
                                                             placeholder="Email Address" value="khairuladzhar@gmail.com">
                                                         <label for="floatingInput">Email address</label>
                                                     </div>
                                                   </div>
                                                   <div class="col-md-3 mb-3">
                                                      <div class="form-floating mb-3">
                                                         <input type="number" class="form-control" id="floatingInput"
                                                             placeholder="Phone Number" value="60144333443">
                                                         <label for="floatingInput">Phone Number</label>
                                                     </div>
                                                   </div>
                                                   <div class="col-md-6 mb-3">
                                                      <div class="form-floating mb-3">
                                                         <textarea type="text" class="form-control" id="floatingInput" placeholder="Text" name="u_role" value="">JALAN 1, TAMAN JAYA</textarea>
                                                         <label for="floatingInput">Adress Detail</label>
                                                     </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-12">
                                                <div class="row">
                                                   <div class="col-md-8">
                                                   </div>
                                                   <div class="col-md-2 text-end">
                                                   </div>
                                                   <div class="text-end col-md-2">
                                                      <button type="button" class="btn btn-success btn-wave">Update</button>
                                                   </div>
                                                </div>
                                             </div>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane p-0" id="organization" role="tabpanel">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="card custom-card overflow-hidden">
                                    <div class="card-body p-0">
                                       <div class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                                          <div>
                                             <span class="avatar avatar-xxl avatar-rounded online me-3">
                                             <img src="../../assets/images/user/avatar-1.jpg" alt="">
                                             </span>
                                          </div>
                                          <div class="flex-fill main-profile-info">
                                             <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="fw-bold mb-1 text-fixed-white mt-3 p-3">KHAIRUL ADZHAR</h6>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="p-4 border-bottom border-block-end-dashed">
                                          <span>
                                             <div class="col-md-12">
                                                <div class="row">
                                                   <div class="col-md-8">
                                                      <div class="form-floating mb-3">
                                                         <input type="text" class="form-control" id="floatingInput"
                                                             placeholder="Full Name" value="xBug Tech ">
                                                         <label for="floatingInput">Organization Name</label>
                                                     </div>
                                                   </div>
                                                   <div class="col-md-4 mb-3">
                                                      <div class="form-floating mb-3">
                                                         <input type="text" class="form-control" id="floatingInput"
                                                             placeholder="Full Name" value="FINANCIAL">
                                                         <label for="floatingInput">Deparment Detail</label>
                                                     </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-12">
                                                <div class="row">
                                                   <div class="col-md-8">
                                                   </div>
                                                   <div class="col-md-2 text-end">
                                                   </div>
                                                   <div class="text-end col-md-2">
                                                      <button type="button" class="btn btn-success btn-wave">Update</button>
                                                   </div>
                                                </div>
                                             </div>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        <div class="tab-pane p-0" id="e-kyc" role="tabpanel">
                           <div class="row" id="tasks-container">
                              <div class="col-xl-12 task-card">
                                 <div class="row justify-content-center">
                                    <div class="col-md-12 ">
                                       <ul class="list-unstyled mb-0 notification-container">
                                          <li>
                                             <div class="card custom-card un-read">
                                                <div class="card-body p-3">
                                                   <a href="javascript:void(0);">
                                                      <div class="d-flex align-items-top mt-0 flex-wrap">
                                                         <div class="row">
                                                            <div class="col-md-1">
                                                               <div class="lh-1 d-flex justify-content-center align-items-center mt-3">
                                                                  <span class="avatar avatar-md online avatar-rounded">
                                                                  <img alt="avatar" src="../../assets/images/user/avatar-1.jpg">
                                                                  </span>
                                                               </div>
                                                            </div>
                                                            <div class="col-md-11">
                                                               <div class="flex-fill">
                                                                  <div class="d-flex align-items-center">
                                                                     <div class="row">
                                                                        <div class="col-md-10">
                                                                           <div class="mt-sm-0 mt-2">
                                                                              <p class="mb-0 fs-14 fw-semibold">Khairul Adzhar</p>
                                                                              <p class="mb-0 text-muted">To ensure a secure and seamless experience, we require users to complete eKYC (Electronic Know Your Customer) verification. This process involves a quick and easy upload of your identification documents and facial recognition to verify your identity. Click start button to get started and enhance your security.</p>
                                                                              <span class="mb-0 d-block text-muted fs-12"><span class="badge bg-warning-transparent fw-semibold fs-12">Pending...</span></span>
                                                                           </div>
                                                                        </div>
                                                                        <div class="text-end col-md-2">
                                                                           <div class="ms-auto mt-4">
                                                                              <button type="button" class="btn btn-success btn-wave">Start</button>
                                                                           </div>
                                                                        </div>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </a>
                                                </div>
                                             </div>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane p-0" id="change-password" role="tabpanel">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="card custom-card overflow-hidden">
                                    <div class="card-body p-0">
                                       <div class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                                          <div>
                                             <span class="avatar avatar-xxl avatar-rounded online me-3">
                                             <img src="../../assets/images/user/avatar-1.jpg" alt="">
                                             </span>
                                          </div>
                                          <div class="flex-fill main-profile-info">
                                             <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="fw-bold mb-1 text-fixed-white mt-3 p-3">KHAIRUL ADZHAR</h6>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="p-4 border-bottom border-block-end-dashed">
                                          <span>
                                             <div class="col-md-12">
                                                <div class="row">
                                                   <div class="col-md-12 mb-3">
                                                      <div class="form-floating">
                                                         <input type="password" class="form-control" id="floatingPassword"
                                                             placeholder="Password">
                                                         <label for="floatingPassword">Current Password</label>
                                                     </div>
                                                   </div>
                                                   <div class="col-md-6 mb-3">
                                                      <div class="form-floating">
                                                         <input type="password" class="form-control" id="floatingPassword"
                                                             placeholder="Password">
                                                         <label for="floatingPassword">Password</label>
                                                     </div>
                                                   </div>
                                                   <div class="col-md-6 mb-3">
                                                      <div class="form-floating">
                                                         <input type="password" class="form-control" id="floatingPassword"
                                                             placeholder="Password">
                                                         <label for="floatingPassword">Confirm Password</label>
                                                     </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-12">
                                                <div class="row">
                                                   <div class="col-md-8">
                                                   </div>
                                                   <div class="col-md-2 text-end">
                                                   </div>
                                                   <div class="text-end col-md-2">
                                                      <button type="button" class="btn btn-success btn-wave">Change Password</button>
                                                   </div>
                                                </div>
                                             </div>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--End::row-1 -->
   </div>
</div>
@endsection