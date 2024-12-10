@extends('organization.layouts.main')
@section('container')
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
   @if (session()->has('success'))
      <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
         <i class="bi bi-check-circle-fill fs-4"></i>
         </svg>
         <div class="ms-3"> {{ session('success') }} </div>
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
   @endif
   <form action="{{ route('addContent') }}" method="POST">
    @csrf
      <div class="row">
         <div class="card custom-card">
            <div class="card-header justify-content-between m-0 col-md-12">
               <div class="card-title col-md-12">
                  Apply Your Content Here
               </div>
            </div>
            <div class="card-body col-md-12">
               <div class="row">
                  <!-- Part 1: Basic Content Details -->
                  <div class="col-md-6">
                     <p class="fw-semibold mt-2">Content Details</p>
                     <hr>
                     <div class="row gy-2">
                        <!-- Content Name -->
                        <div class="col-xl-12">
                           <div class="form-floating">
                              <input type="text" class="form-control @error('content_name') is-invalid @enderror" id="contentName" placeholder="Enter Content Name" name="content_name">
                              <label for="contentName">Content Name</label>
                              @error('content_name')
                                 <span class="mb-1 text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>
                        <!-- Content Description -->
                        <div class="col-xl-12">
                           <div class="form-floating">
                              <input type="text" class="form-control @error('content_desc') is-invalid @enderror" id="contentDescription" placeholder="Enter Content Description"  name="content_desc">
                              <label for="contentDescription">Content Description</label>
                              @error('content_desc')
                                 <span class="mb-1 text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>
                        <!-- Links -->
                        <div class="col-xl-12">
                           <div class="form-floating">
                              <input type="url" class="form-control @error('content_link') is-invalid @enderror" id="contentLink" placeholder="Enter Related Link"  name="content_link">
                              <label for="contentLink">Content Link</label>
                              @error('content_link')
                                 <span class="mb-1 text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>
                        <!-- Content Type -->
                        <div class="col-xl-12">
                           <div class="form-floating">
                              <select class="form-select @error('content_type_id') is-invalid @enderror" id="content_types" name="content_type_id" >
                                 <option value="" disabled selected>Select Content Type</option>
                                 @foreach ($content_types as $content_type)
                                 <option value="{{ $content_type->id }}">{{ $content_type->type }}</option>
                                 @endforeach
                              </select>
                              <label for="content_type_id">Content Type</label>
                              @error('content_type_id')
                                 <span class="mb-1 text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>

                        <!-- Content -->
                         <div class="col-xl-12">
                           
                         </div>
                     </div>
                  </div>
                  <!-- Part 2: Additional Information -->
                  <div class="col-md-6">
                     <p class="fw-semibold mt-2">Content Information</p>
                     <hr>
                     <div class="row gy-2">
                        <!-- Enrollment Price -->
                        <div class="col-xl-12">
                           <div class="form-floating">
                              <input type="number" class="form-control @error('enrollment_price') is-invalid @enderror" id="enrollment_price" placeholder="Enter Enrollment Price"  name="enrollment_price">
                              <label for="enrollmentPrice">Enrollment Price (in RM)</label>
                              @error('enrollment_price')
                                 <span class="mb-1 text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>
                        <!-- Place -->
                        <div class="col-xl-12">
                           <div class="form-floating">
                              <input type="text" class="form-control form-control @error('place') is-invalid @enderror" id="place" placeholder="Enter Place"  name="place">
                              <label for="place">Place</label>
                              @error('place')
                                 <span class="mb-1 text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>
                        <!-- Participant Limit -->
                        <div class="col-xl-12">
                           <div class="form-floating">
                              <input type="number" class="form-control @error('participant_limit') is-invalid @enderror" id="participant_limit" placeholder="Enter Participant Limit"  name="participant_limit">
                              <label for="participant_limit">Participant Limit</label>
                              @error('participant_limit')
                                 <span class="mb-1 text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>
                        <!-- State -->
                        <div class="col-xl-12">
                           <label class="form-label">Select States</label>
                           <span class="text-muted"> - scroll down </span>
                           <div id="state-container" style="max-height: 250px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                               @foreach ($states as $state)
                                   <div class="form-check form-check-lg">
                                       <input class="form-check-input state-checkbox @error('states') is-invalid @enderror" 
                                              type="checkbox" 
                                              name="states[]" 
                                              value="{{ $state->name }}" 
                                              id="state-{{ $state->name }}" 
                                              @checked(is_array(old('states')) && in_array($state->name, old('states')))>
                                       <label class="form-check-label" for="state-{{ $state->name }}">
                                           {{ $state->name }}
                                       </label>
                                       
                                       @error('states')
                                           <span class="mb-1 text-danger">{{ $message }}</span>
                                       @enderror
                                   </div>
                               @endforeach
                           </div>
                       </div>
                       
                       


                                
                     </div>
                  </div>
                  <!-- Action Buttons -->
                  <div class="col-md-12">
                     <div class="row">
                        <div class="col-md-8">

                        </div>
                        <div class="col-md-2 text-end">
                              
                        </div>
                        <div class="col-md-2">
                              <button type="submit" class="btn btn-success mt-5 px-4"  name="Add">Apply Content</button>
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