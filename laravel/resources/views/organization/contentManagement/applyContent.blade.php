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
   @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                    <i class="bi bi-dash-circle-fill fs-4"></i>
                    <div class="ms-3"> {!! session('error') !!} </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif


            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
   <form action="{{ route('addContentOrganization') }}" method="POST" enctype="multipart/form-data">
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
                              <input type="text" class="form-control @error('content_name') is-invalid @enderror" id="contentName" placeholder="Enter Content Name" name="content_name" value="{{ old('content_name') }}">
                              <label for="contentName">Content Name</label>
                              @error('content_name')
                                 <span class="mb-1 text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>
                        <!-- Content Description -->
                        <div class="col-xl-12">
                           <div class="form-floating">
                              <input type="text" class="form-control @error('content_desc') is-invalid @enderror" id="contentDescription" placeholder="Enter Content Description"  name="content_desc" value="{{ old('content_desc') }}">
                              <label for="contentDescription">Content Description</label>
                              @error('content_desc')
                                 <span class="mb-1 text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>
                        <!-- Links -->
                        <div class="col-xl-12">
                           <div class="form-floating">
                              <input type="url" class="form-control @error('content_link') is-invalid @enderror" id="contentLink" placeholder="Enter Related Link"  name="content_link" value="{{ old('content_link') }}">
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
                                 <option value="{{ $content_type->id }}" @selected(old('content_type_id') == $content_type->id)>{{ $content_type->type }}</option>
                                 @endforeach
                              </select>
                              <label for="content_type_id">Content Type</label>
                              @error('content_type_id')
                                 <span class="mb-1 text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>

                        <!-- Label -->
                         <div class="col-xl-12">
                           <label for="label-input">Search Labels:</label>
                           <input type="text" id="label-input" class="form-control" placeholder="Start typing..." autocomplete="off">
                           <ul id="suggestions-list" class="list-group mt-2" style="display:none;" ></ul>
                         </div>

                          <!-- Selected Labels -->
                        <div id="selected-labels" class="col-xl-12">
                           <p>Selected Labels:</p>
                           <ul id="selected-labels-list" class="list-group d-flex flex-wrap" style="display: flex; gap: 10px; list-style: none; padding: 0; flex-direction: initial"></ul>
                        </div>
                        <p id="error-message" class="text-danger" style="display: none;">Please select at least 5 labels.</p>

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
                              <input type="number" class="form-control @error('enrollment_price') is-invalid @enderror" id="enrollment_price" placeholder="Enter Enrollment Price"  name="enrollment_price" value="{{ old('enrollment_price') }}">
                              <label for="enrollmentPrice">Enrollment Price (in RM)</label>
                              @error('enrollment_price')
                                 <span class="mb-1 text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>
                        <!-- Place -->
                        <div class="col-xl-12">
                           <div class="form-floating">
                              <input type="text" class="form-control form-control @error('place') is-invalid @enderror" id="place" placeholder="Enter Place"  name="place" value="{{ old('place') }}">
                              <label for="place">Place</label>
                              @error('place')
                                 <span class="mb-1 text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>
                        <!-- Participant Limit -->
                        <div class="col-xl-12">
                           <div class="form-floating">
                              <input type="number" class="form-control @error('participant_limit') is-invalid @enderror" id="participant_limit" placeholder="Enter Participant Limit"  name="participant_limit" value="{{ old('participant_limit') }}">
                              <label for="participant_limit">Participant Limit</label>
                              @error('participant_limit')
                                 <span class="mb-1 text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>

                        <!--Add Image-->
                        <div class="col-xl-12">
                           <div class="form-floating">
                              <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" placeholder="Upload Your Content Image"  name="image" >
                              <label for="image" class="form-label">Upload Your Content Image</label>
                              @error('image')
                                 <span class="mb-1 text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>
                        <!-- State -->

                        <div class="col-xl-12">
                           <div class="form-floating">
                           <select class="form-select @error('state') is-invalid @enderror" 
                                    name="state" 
                                    id="state-select" 
                                    style="max-height: 250px; overflow-y: auto; border: 1px solid #ddd;"
                                 >
                              <option value="" disabled selected>Select a state</option>
                              @foreach ($states as $state)
                                    <option value="{{ $state->name }}" 
                                          @selected(old('state') == $state->name)>
                                       {{ $state->name }}
                                    </option>
                              @endforeach
                           </select>
                              <label for="state">Select State</label>
                              @error('state')
                              <span class="text-danger">{{ $message }}</span>
                           @enderror
                           </div>
                        </div>
                     


                       
                       


                                
                     </div>
                  </div>

                   
                  <!-- <div class="col-md-6">
            
                              <div class="form-floating">
                                    <input type="text" id="label-input" class="form-control" placeholder="Start typing..." autocomplete="off">
                                    <label for="label-input">Related Labels</label>
                                    <ul id="suggestions-list" class="list-group mt-2" style="display:none;"></ul>
                                 <br>
                              <div id="selected-labels" class="mb-3">
                           
                                 <ul id="selected-labels-list" class="list-group d-flex flex-wrap" style="display: flex; gap: 10px; list-style: none; padding: 0; flex-direction: initial"></ul>
                              </div>
                           </div>
                       
                       
                  </div> -->
                
                  <!-- <p id="error-message" class="text-danger" style="display: none;">Please select at least 5 labels.</p> -->
                  <input type="hidden" id="labelIds" name="labelIds" value="">

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

   <!-- <script>
      $(document).ready(function() {
    var selectedLabels = []; // Array to store selected labels

    // Handle input and filter suggestions based on the user input
    $('#label-input').on('input', function() {
        var query = $(this).val(); // Get the current input value

        if (query.length >= 1) {
            $.ajax({
                url: '/organization/api/getLabels', // Your route
                method: 'GET',
                data: { query: query }, // Send the query
                success: function(response) {
                    var suggestions = $('#suggestions-list');
                    suggestions.empty(); // Clear the previous suggestions
                    if (response.length > 0) {
                     response.forEach(function(label) {
                        // Escape JSON string for HTML attribute
                        const dataLabel = JSON.stringify(label).replace(/"/g, '&quot;');
                        suggestions.append(
                              '<li class="list-group-item" data-label="' +
                              dataLabel +
                              '">' +
                              label.name +
                              '</li>'
                        );
                     });
                     suggestions.show();
                  } else {
                     suggestions.hide();
                  }

                }
            });
        } else {
            $('#suggestions-list').hide(); // Hide suggestions if the input is empty
        }
    });

    // Handle click on a suggestion (add it to the selected labels)
    $(document).on('click', '.list-group-item', function() {
            var selectedLabel = $(this).data('label'); // Get the label text
            console.log(selectedLabel)
            if (!selectedLabels.includes(selectedLabel)) { // Prevent duplicate selections
                  selectedLabels.push(selectedLabel); // Add the label to the selected labels array
                  updateSelectedLabels(); // Update the displayed selected labels
            }
            $('#label-input').val(''); // Clear the input field
            $('#suggestions-list').hide(); // Hide the suggestions
         });

         // Function to update the displayed selected labels
         function updateSelectedLabels() {
            var selectedLabelsContainer = $('#selected-labels-list');
            selectedLabelsContainer.empty(); // Clear current selected labels

            selectedLabels.forEach(function(label) {
           
               var l = JSON.parse(label);
                   var tag = $(`
                           <div class="col-md-6" 
                                 style="padding-bottom: 10px;">
                              <li class="badge badge-info mr-2 p-2" 
                                    style="background-color: white; 
                                          color: black; 
                                          display: inline-block; 
                                          margin-right: 10px; 
                                          border-radius: 10px; 
                                          border: 2px solid black;">
                                    ${label.name}
                                    <button class="close ml-2" 
                                          type="button" 
                                          style="color: black; 
                                                   background: transparent; 
                                                   border: none; 
                                                   cursor: pointer;">&times;</button>
                              </li>
                           </div>
                        `);
                  // Add remove functionality to the tag
                  tag.find('.close').on('click', function() {
                     selectedLabels = selectedLabels.filter(function(item) {
                        return item !== label; // Remove label from the selected array
                     });
                     updateSelectedLabels(); // Update the display
                  });
                  selectedLabelsContainer.append(tag);
            });
         }

         // Form validation before submission
         $('form').on('submit', async function (e) {
               e.preventDefault(); // Prevent default form submission

               if (selectedLabels.length < 5) {
                  $('#error-message').show();
                  return;
               }

               $('#error-message').hide();

               try {
                  const labelIds = selectedLabels.map(label => label.id); // Extract label IDs
                  console.log(selectedLabels, labelIds)

                  const response = await fetch(`http://localhost:30000/api/vector/getVectorValue?values=${JSON.stringify(labelIds)}`);
                  const data = await response.json(); // Parse API response

                  // Assuming API response contains a `weights` array
                  const weights = data.weights || [];
                  console.log(weights,data)
                  document.getElementById('formattedContent').value += `\nCategory Weights: ${weights.join(', ')}`;

                  // Inject `category_weight` into a hidden input field
                  const categoryWeightInput = document.createElement('input');
                  categoryWeightInput.type = 'hidden';
                  categoryWeightInput.name = 'category_weight';
                  categoryWeightInput.value = JSON.stringify(weights); // Pass weights as JSON string
                  this.appendChild(categoryWeightInput);

                  // Submit the form after processing the weights
                  this.submit();
               } catch (error) {
                  console.error('Error fetching weights:', error);
                  alert('An error occurred while processing your request. Please try again.');
               }
            });

      });
   </script> -->
</div>

<script>
   
   $(document).ready(function() {
    var selectedLabels = []; // Array to store selected labels

    // Handle input and filter suggestions based on the user input
    $('#label-input').on('input', function() {
        var query = $(this).val(); // Get the current input value

        if (query.length >= 1) {
            $.ajax({
                url: '/organization/api/getLabels', // Your route
                method: 'GET',
                data: { query: query }, // Send the query
                success: function(response) {
                    var suggestions = $('#suggestions-list');
                    suggestions.empty(); // Clear the previous suggestions
                    if (response.length > 0) {
                     response.forEach(function(label) {
                        // Escape JSON string for HTML attribute
                       
                       // const dataLabel = JSON.stringify(label).replace(/"/g, '&quot;');
                        suggestions.append(
                              '<li class="list-group-item" data-labelid="' +
                              JSON.stringify(label).replace(/"/g, '&quot;') +
                              '">' +
                              label.name +
                              '</li>'
                        );
                     });
                     suggestions.show();
                  } else {
                     suggestions.hide();
                  }

                }
            });
        } else {
            $('#suggestions-list').hide(); // Hide suggestions if the input is empty
        }
    });

    // Handle click on a suggestion (add it to the selected labels)
    $(document).on('click', '.list-group-item', function() {
            var selectedLabel = $(this).data('labelid'); // Get the label text
           // console.log(selectedLabel, selectedLabels,selectedLabels.includes(selectedLabel) )
            if (!selectedLabels.some(label => label.id === selectedLabel.id)) { // Prevent duplicate selections
                  selectedLabels.push(selectedLabel); // Add the label to the selected labels array
                  updateSelectedLabels(); // Update the displayed selected labels
            }else{
               alert('This label has been selected');
            }
            $('#label-input').val(''); // Clear the input field
            $('#suggestions-list').hide(); // Hide the suggestions
         });

         // Function to update the displayed selected labels
         function updateSelectedLabels() {
            var selectedLabelsContainer = $('#selected-labels-list');
            selectedLabelsContainer.empty(); // Clear current selected labels

            selectedLabels.forEach(function(label) {
               var tag = $(`
                  <li class="badge badge-info" 
                     style="
                        background-color: white; 
                        color: black; 
                        display: inline-flex; 
                        align-items: center; 
                        padding: 5px 10px; 
                        border-radius: 10px; 
                        border: 2px solid black;">
                     ${label.name}
                     <button class="close ml-2" 
                        type="button" 
                        style="
                           color: black; 
                           background: transparent; 
                           border: none; 
                           cursor: pointer;">
                        &times;
                     </button>
                  </li>
               `);

               // Add remove functionality to the tag
               tag.find('.close').on('click', function() {
                  selectedLabels = selectedLabels.filter(function(item) {
                     return item !== label; // Remove label from the selected array
                  });
                  updateSelectedLabels(); // Update the display
               });

               selectedLabelsContainer.append(tag);
            });
         }


         // Form validation before submission
         $('form').on('submit', async function (e) {
               e.preventDefault(); // Prevent default form submission

               if (selectedLabels.length < 5) {
                  $('#error-message').show();
                  return;
               }

               $('#error-message').hide();

               try {
                  const labelIds = selectedLabels.map(label => label.id); // Extract label IDs
                  $('#labelIds').val(labelIds);
                 
                  this.submit();
               } catch (error) {
                  console.error('Error fetching weights:', error);
                  alert('An error occurred while processing your request. Please try again.');
               }
            });

      });
</script>
@endsection