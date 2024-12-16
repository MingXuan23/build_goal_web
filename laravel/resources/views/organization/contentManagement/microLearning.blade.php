@extends('organization.layouts.main')
@section('container')
<!-- Start::app-content -->
<div class="main-content app-content">
<div class="container">
   <!-- Page Header -->
   <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
      <h1 class="page-title fw-semibold fs-18 mb-0">Upload Your MicroLearning Resource Here</h1>
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
         <div class="ms-3"> {{ session('success') }} </div>
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
   @endif

   <div class="card">
      <div class="card-header">
         <h2>MicroLearning Content</h2>
      </div>
      <div class="card-body">
         <form action="{{ route('uploadMicroLearning') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
               <label for="content_name" class="form-label">Title</label>
               <input type="text" class="form-control" id="content_name" name="content_name" required>
            </div>
            <div class="mb-3">
               <label for="image" class="form-label">Thumbnail (Image)</label>
               <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="mb-3">
               <label for="content_desc" class="form-label">Description</label>
               <textarea class="form-control" id="content_desc" name="content_desc" rows="5" required></textarea>
            </div>
            <div id="sectionsContainer"></div>
            <div id="mainButtons">
               <button type="button" class="btn btn-primary" onclick="showSectionInput()">Add Section Here</button>
               <button type="button" class="btn btn-primary" onclick="generatePreview()">Generate Preview</button>
            </div>
            <div id="sectionInput" class="section-input" style="display: none;">
               <div class="mb-3">
                     <label for="sectionHeader" class="form-label">Section Header</label>
                     <input type="text" id="sectionHeader" class="form-control" placeholder="Enter Section Header">
               </div>
               <div class="mb-3">
                     <label for="sectionBody" class="form-label">Section Body</label>
                     <textarea id="sectionBody" class="form-control" rows="4" placeholder="Enter Section Content"></textarea>
               </div>
               <button type="button" class="btn btn-primary" onclick="addSection()">Add Section</button>
            </div>

            <input type="hidden" id="formattedContent" name="formattedContent" value="">

            <div class="col-md-12">
               <div class="row">
                     <div class="col-md-8"></div>
                     <div class="col-md-2 text-end"></div>
                     <div class="col-md-2">
                        <button type="submit" class="btn btn-success mt-5 px-4">Upload</button>
                     </div>
               </div>
            </div>
         </form>
      </div>
   </div>

   <!-- Preview Card -->
   <div id="previewCard" class="card" style="display: none;">
      <div class="card-header">
         <h4>Preview</h4>
      </div>
      <div id="preview" class="card-body" style="display: none;">
         <!-- The preview content will be dynamically added here -->
      </div>
      <div class="col-md-12">
         <div class="row">
            <div class="col-md-8">
            <button class="btn btn-primary mt-3" onclick="returnToForm()">Back to Form</button> <!-- Added button to go back to the form -->
            </div>
            <div class="col-md-2 text-end"></div>
            <div class="col-md-2">
            </div>
         </div>
      </div>
      
   </div>

   <script>
      let formattedString = '';

      function showSectionInput() {
         const sectionInput = document.getElementById('sectionInput');
         const mainButtons = document.getElementById('mainButtons');

         sectionInput.style.display = 'block';
         mainButtons.style.display = 'none';
      }

      function addSection() {
         const header = document.getElementById('sectionHeader').value;
         const body = document.getElementById('sectionBody').value;

         if (header && body) {
            if (formattedString === '') {
               formattedString = `***${header}***${body}`;
            } else {
               formattedString += `\n\n***${header}***${body}`;
            }

            document.getElementById('formattedContent').value = formattedString;

            document.getElementById('sectionHeader').value = '';
            document.getElementById('sectionBody').value = '';

            document.getElementById('sectionInput').style.display = 'none';
            document.getElementById('mainButtons').style.display = 'block';

            updateSectionsContainer();
         } else {
            alert('Please fill out both the Section Header and Body.');
         }
      }

      function updateSectionsContainer() {
         const container = document.getElementById('sectionsContainer');
         let html = '';

         const contentSections = formattedString.split('\n\n');
         contentSections.forEach((section, index) => {
            const headerMatch = section.match(/\*\*\*(.*?)\*\*\*/);
            if (headerMatch) {
               const header = headerMatch[1];
               const body = section.replace(/\*\*\*(.*?)\*\*\*/, '').trim();
               html += `
                  <div class="section">
                     <h3>Section ${index + 1}: ${header}</h3>
                     <p>${body}</p>
                  </div>
               `;
            }
         });

         container.innerHTML = html;
      }

      function generatePreview() {
            const title = document.getElementById('content_name').value;
            const description = document.getElementById('content_desc').value;
            const formattedContent = document.getElementById('formattedContent').value;
            const preview = document.getElementById('preview');
            const previewCard = document.getElementById('previewCard');
            const form = document.querySelector('form'); // Reference to the form

            // Validate inputs
            if (!title || !description || !formattedContent) {
               alert('Please fill in the Title, Description, and add at least one Section.');
               return;
            }

            // Generate the preview HTML
            let html = `
               <h1>${title}</h1>
               <p><em>${description}</em></p>
               <hr>
            `;

            const contentSections = formattedContent.split('\n\n');
            contentSections.forEach((section, index) => {
               const headerMatch = section.match(/\*\*\*(.*?)\*\*\*/); // Match header in ***
               if (headerMatch) {
                     const header = headerMatch[1]; // Extract header
                     const body = section.replace(/\*\*\*(.*?)\*\*\*/, '').trim(); // Remove header and extract body

                     // Append formatted section to preview
                     html += `
                        <div class="preview-section">
                           <h2>Step ${index + 1}: ${header}</h2>
                           <p>${body}</p>
                        </div>
                     `;
               }
            });

            // Append the Upload button to the preview
            html += `
               <div class="col-md-12">
                     <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-2 text-end"></div>
                        <div class="col-md-2">
                           <button type="submit" class="btn btn-success mt-5 px-4">Upload</button>
                        </div>
                     </div>
               </div>
            `;

            // Display the preview in the card
            preview.innerHTML = html;
            preview.style.display = 'block'; // Show the preview content
            previewCard.style.display = 'block'; // Show the preview card

            // Optionally hide the main content form
            document.querySelector('.card-body').style.display = 'none'; // Hide the form
         }


      function returnToForm() {
         const preview = document.getElementById('preview');
         const previewCard = document.getElementById('previewCard'); // The card containing the preview
         const mainContent = document.querySelector('.card-body'); // The form content (inside card-body)

         // Hide the preview
         preview.style.display = 'none';
         previewCard.style.display = 'none'; // Optionally hide the entire card containing the preview

         // Show the form again
         mainContent.style.display = 'block';
      }
   </script>

</div>
</div>
@endsection
