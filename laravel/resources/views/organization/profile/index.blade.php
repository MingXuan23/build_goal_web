@extends('organization.layouts.main')
@section('container')
{{-- @dd($datas); --}}
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
                                 <ul class="nav nav-tabs nav-tabs-header mb-0 d-sm-flex d-block d-flex p-2 align-items-center justify-content-start"
                                    role="tablist">
                                    <li class="nav-item m-1">
                                       <a class="nav-link active" data-bs-toggle="tab" role="tab"
                                          aria-current="page" href="#your"
                                          aria-selected="true">Personal Details</a>
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
                  @if (Auth::user()->ekyc_status === 0)
                  <div class="col-md-12 mb-3">
                     <div class="alert alert-solid-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-lg"></i>Your account has not been verified because
                        you have not completed the eKYC process. Go to<span class="fw-bold text-light">
                        e-kyc Detail</span> to complete your eKYC..
                     </div>
                  </div>
                  @endif
                  <div class="col-md-12">
                     <div class="tab-content task-tabs-container">
                        <div class="tab-pane show active p-0" id="your" role="tabpanel">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="card custom-card overflow-hidden">
                                    <div class="card-body p-0">
                                       <div
                                          class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                                          <div>
                                             <span
                                                class="avatar avatar-xxl avatar-rounded online me-3">
                                             <img src="../../assets/images/user/avatar-1.jpg"
                                                alt="">
                                             </span>
                                          </div>
                                          <div class="flex-fill main-profile-info">
                                             <div
                                                class="d-flex align-items-center justify-content-between">
                                                <h6 class="fw-bold mb-1 text-fixed-white mt-3 p-3">
                                                   {{ $datas[0]->name }}
                                                </h6>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="p-4 border-bottom border-block-end-dashed">
                                          <span>
                                             <div class="col-md-12">
                                                <div class="row">
                                                   <div class="col-md-8">
                                                      <div class="form-floating mb-3">
                                                         <input type="text"
                                                            class="form-control"
                                                            id="floatingInput"
                                                            placeholder="Ic Number"
                                                            value="{{ $datas[0]->icNo }}"
                                                            name="IcNo">
                                                         <label for="floatingInput">Ic
                                                         Number</label>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-4 mb-3">
                                                      <div class="form-floating mb-3">
                                                         <input type="text"
                                                            class="form-control"
                                                            id="floatingInput"
                                                            placeholder="Full Name"
                                                            value="{{ $datas[0]->name }}"
                                                            name="name">
                                                         <label for="floatingInput">Full
                                                         Name</label>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3 mb-3">
                                                      <div class="form-floating mb-3">
                                                         <input type="email"
                                                            class="form-control"
                                                            id="floatingInput"
                                                            placeholder="Email Address"
                                                            value="{{ $datas[0]->email }}"
                                                            name="email">
                                                         <label for="floatingInput">Email
                                                         address</label>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3 mb-3">
                                                      <div class="form-floating mb-3">
                                                         <input type="number"
                                                            class="form-control"
                                                            id="floatingInput"
                                                            placeholder="Phone Number"
                                                            value="{{ $datas[0]->telno }}"
                                                            name="telno">
                                                         <label for="floatingInput">Phone
                                                         Number</label>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3 mb-3">
                                                      <div class="form-floating mb-3">
                                                         <input type="text"
                                                            class="form-control"
                                                            id="floatingInput"
                                                            placeholder="Full Name"
                                                            value="{{ ($datas[0]->active == 1) ? 'Active' : 'Inactive' }}" disabled>
                                                         <label for="floatingInput">Account Status</label>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3 mb-3">
                                                      <div class="form-floating mb-3">
                                                         @php
                                                         // Data peran
                                                         $rolesMap = [
                                                         1 => 'admin',
                                                         2 => 'staff',
                                                         3 => 'organization',
                                                         4 => 'content creator',
                                                         5 => 'mobile user',
                                                         ];
                                                         $userRoles = is_string(
                                                         Auth::user()->role,
                                                         )
                                                         ? json_decode(
                                                         Auth::user()->role,
                                                         true,
                                                         )
                                                         : Auth::user()->role;
                                                         if (!is_array($userRoles)) {
                                                         $userRoles = [];
                                                         }
                                                         $roleNames = array_map(
                                                         fn($role) => $rolesMap[
                                                         $role
                                                         ] ?? 'unknown',
                                                         $userRoles,
                                                         );
                                                         $rolesDisplay = implode(
                                                         ', ',
                                                         $roleNames,
                                                         );
                                                         @endphp
                                                         <input type="text"
                                                            class="form-control"
                                                            id="floatingInput"
                                                            placeholder="Phone Number"
                                                            value="{{ $rolesDisplay }}"
                                                            disabled readonly>
                                                         <label for="floatingInput">Role</label>
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
                                                      <button type="button"
                                                         class="btn btn-success"
                                                         data-bs-toggle="modal"
                                                         data-bs-target="#exampleModalSm">Update</button>
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
                                       <div
                                          class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                                          <div>
                                             <span
                                                class="avatar avatar-xxl avatar-rounded online me-3">
                                             <img src="../../assets/images/user/avatar-1.jpg"
                                                alt="">
                                             </span>
                                          </div>
                                          <div class="flex-fill main-profile-info">
                                             <div
                                                class="d-flex align-items-center justify-content-between">
                                                <h6 class="fw-bold mb-1 text-fixed-white mt-3 p-3">
                                                   {{ $datas[0]->name }}
                                                </h6>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="p-4 border-bottom border-block-end-dashed">
                                          <span>
                                             <div class="col-md-12">
                                                <div class="row">
                                                   <div class="col-md-8">
                                                      <div class="form-floating mb-3">
                                                         <input type="text"
                                                            class="form-control"
                                                            id="floatingInput"
                                                            placeholder="Full Name"
                                                            value="{{ $datas[0]->org_name }}">
                                                         <label for="floatingInput">Organization
                                                         Name</label>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-4 mb-3">
                                                      <div class="form-floating mb-3">
                                                         <input type="text"
                                                            class="form-control"
                                                            id="floatingInput"
                                                            placeholder="Full Name"
                                                            value="{{ $datas[0]->org_desc }}">
                                                         <label for="floatingInput">Organization Description</label>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-4 mb-3">
                                                      <div class="form-floating">
                                                         <select class="form-select" id="floatingSelect"
                                                            aria-label="Floating label select example" name="ostate">
                                                            <option value="" selected>- Select State -</option>
                                                            <option value="pahang" @selected($datas[0]->org_state == 'pahang')>Pahang
                                                            </option>
                                                            <option value="perak" @selected($datas[0]->org_state == 'perak')>Perak
                                                            </option>
                                                            <option value="terengganu" @selected($datas[0]->org_state == 'terengganu')>
                                                            Terengganu</option>
                                                            <option value="perlis" @selected($datas[0]->org_state == 'perlis')>Perlis
                                                            </option>
                                                            <option value="selangor" @selected($datas[0]->org_state == 'selangor')>
                                                            Selangor</option>
                                                            <option value="negeri_sembilan"
                                                            @selected($datas[0]->org_state == 'negeri_sembilan')>Negeri Sembilan</option>
                                                            <option value="johor" @selected($datas[0]->org_state == 'johor')>Johor
                                                            </option>
                                                            <option value="kelantan" @selected($datas[0]->org_state == 'kelantan')>
                                                            Kelantan</option>
                                                            <option value="kedah" @selected($datas[0]->org_state == 'kedah')>Kedah
                                                            </option>
                                                            <option value="pulau_pinang" @selected($datas[0]->org_state == 'pulau_pinang')>
                                                            Pulau Pinang</option>
                                                            <option value="melaka" @selected($datas[0]->org_state == 'melaka')>Melaka
                                                            </option>
                                                            <option value="sabah" @selected($datas[0]->org_state == 'sabah')>Sabah
                                                            </option>
                                                            <option value="sarawak" @selected($datas[0]->org_state == 'sarawak')>
                                                            Sarawak</option>
                                                         </select>
                                                         <label for="floatingSelect">State</label>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-8 mb-3">
                                                      <div class="form-floating mb-3">
                                                         <input type="text"
                                                            class="form-control"
                                                            id="floatingInput"
                                                            placeholder="Full Name"
                                                            value="{{ $datas[0]->org_address }}">
                                                         <label for="floatingInput">Organization Address</label>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-4 mb-3">
                                                      <div class="form-floating mb-3">
                                                         <input type="text"
                                                            class="form-control"
                                                            id="floatingInput"
                                                            placeholder="Full Name"
                                                            value="{{ ($datas[0]->org_status == 1) ? 'Active' : 'Inactive' }}" disabled>
                                                         <label for="floatingInput">Organization Status</label>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-8 mb-3">
                                                      <div class="form-floating">
                                                         <select class="form-select" id="floatingSelect"
                                                            aria-label="Floating label select example" name="otype">
                                                         <option value="" disabled
                                                         {{ $datas[0]->org_type == null ? 'selected' : '' }}>-
                                                         Select -
                                                         </option>
                                                         <option value="1"
                                                         {{ $datas[0]->org_type === 'Government' ? 'selected' : '' }}>
                                                         Government
                                                         </option>
                                                         <option value="2"
                                                         {{ $datas[0]->org_type === 'Company' ? 'selected' : '' }}>
                                                         Company
                                                         </option>
                                                         <option value="3"
                                                         {{ $datas[0]->org_type === 'Skill Training Vendor' ? 'selected' : '' }}>
                                                         Skill
                                                         Training
                                                         Vendor</option>
                                                         <option value="4"
                                                         {{ $datas[0]->org_type === 'NGO' ? 'selected' : '' }}>NGO
                                                         </option>
                                                         <option value="5"
                                                         {{ $datas[0]->org_type === 'Content Creator' ? 'selected' : '' }}>
                                                         Content
                                                         Creator</option>
                                                         <option value="6"
                                                         {{ $datas[0]->org_type === 'Event Organizer' ? 'selected' : '' }}>
                                                         Event
                                                         Organizer</option>
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
                                                   </div>
                                                   <div class="text-end col-md-2">
                                                      <button type="button"
                                                         class="btn btn-success btn-wave">Update</button>
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
                                          <li class="">
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
                                                                                    @if (Auth::user()->ekyc_status === 0)
                                                                                    <div class="mt-sm-0 mt-2">
                                                                                        <p class="mb-0 fs-14 fw-semibold">
                                                                                            {{ Auth::user()->name }}
                                                                                        </p>
                                                                                        <p class="mb-0 text-muted">
                                                                                            To ensure a secure and seamless experience, we require users to complete eKYC (Electronic Know Your Customer) verification. This process involves a quick and easy upload of your identification documents and facial recognition to verify your identity. Click start button to get started and enhance your security.
                                                                                        </p>
                                                                                        <span class="mb-0 d-block text-muted fs-12">
                                                                                            <span class="badge bg-warning-transparent fw-semibold fs-12">Pending...</span>
                                                                                        </span>
                                                                                    </div>
                                                                                    
                                                                                    @else
                                                                                    <div class="mt-sm-0 mt-2">
                                                                                        <p class="mb-0 fs-14 fw-semibold">
                                                                                            {{ Auth::user()->name }}
                                                                                        </p>
                                                                                        <p class="mb-0 text-muted">
                                                                                            Congratulations! Your eKYC verification is successfully completed. Your identity has been verified for a secure and seamless experience.
                                                                                        </p>
                                                                                        <p class="mb-0 mt-1 text-muted text-wrap" style="word-break: break-word;">
                                                                                           <span class="fw-bold text-success">eKYC SIGNATURE:  </span><span class="text-muted fw-semibold"> eKYC_VERIFIED|KHAIRUL-12345|2024-11-26T10:30:00Z|ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz0123456789PQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz0123456789PQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz0123456789</span> 
                                                                                        </p>
                                                                                        <span class="mb-0 mt-1 d-block text-muted fs-12">
                                                                                            <span class="badge bg-success-transparent fw-semibold fs-12">Verified</span>
                                                                                        </span>
                                                                                    </div>
                                                                                    @endif
                                                                                </div>
                                                                                @if (Auth::user()->ekyc_status === 0)
                                                                                <div class="text-end col-md-2">
                                                                                    <div class="ms-auto mt-4">
                                                                                       <button type="button" class="btn btn-success btn-wave">Start</button>
                                                                                    </div>
                                                                              </div>
                                                                                @else
                                                                                    
                                                                                @endif
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
                                       <div
                                          class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                                          <div>
                                             <span
                                                class="avatar avatar-xxl avatar-rounded online me-3">
                                             <img src="../../assets/images/user/avatar-1.jpg"
                                                alt="">
                                             </span>
                                          </div>
                                          <div class="flex-fill main-profile-info">
                                             <div
                                                class="d-flex align-items-center justify-content-between">
                                                <h6 class="fw-bold mb-1 text-fixed-white mt-3 p-3">
                                                   KHAIRUL ADZHAR
                                                </h6>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="p-4 border-bottom border-block-end-dashed">
                                          <span>
                                             <div class="col-md-12">
                                                <div class="row">
                                                   <div class="col-md-12 mb-3">
                                                      <div class="form-floating">
                                                         <input type="password"
                                                            class="form-control"
                                                            id="floatingPassword"
                                                            placeholder="Password">
                                                         <label for="floatingPassword">Current
                                                         Password</label>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-6 mb-3">
                                                      <div class="form-floating">
                                                         <input type="password"
                                                            class="form-control"
                                                            id="floatingPassword"
                                                            placeholder="Password">
                                                         <label
                                                            for="floatingPassword">Password</label>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-6 mb-3">
                                                      <div class="form-floating">
                                                         <input type="password"
                                                            class="form-control"
                                                            id="floatingPassword"
                                                            placeholder="Password">
                                                         <label for="floatingPassword">Confirm
                                                         Password</label>
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
                                                      <button type="button"
                                                         class="btn btn-success btn-wave">Change
                                                      Password</button>
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