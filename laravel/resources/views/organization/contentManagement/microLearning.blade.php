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
                  <div class="col-md-6">
                        <label for="label-input">Search Labels:</label>
                        <input type="text" id="label-input" class="form-control" placeholder="Start typing..." autocomplete="off">
                        <ul id="suggestions-list" class="list-group mt-2" style="display:none;"></ul>
                  </div>
                  <div id="sectionsContainer"></div>
                  <div id="selected-labels" class="mb-3">
                     <p>Selected Labels:</p>
                     <ul id="selected-labels-list" class="list-group"></ul>
                  </div>
                  <p id="error-message" class="text-danger" style="display: none;">Please select at least 5 labels.</p>
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

      // class TagsInput {
      //       constructor(element) {
      //          this.container = element;
      //          this.tags = [];
      //          this.suggestions = [];
      //          this.input = this.container.querySelector('input');
      //          this.suggestionsPanel = null;
      //          this.availableItems = [];  // Initialize as an empty array

      //          // Fetch label data from the backend
      //          this.fetchLabels();

      //          this.init();
      //       }

      //       // Fetch the labels from the backend API
      //       fetchLabels() {
      //          fetch('/organization/api/getLabels')
      //          .then(response => response.json())
      //          .then(data => {
      //             // Handle the fetched labels here
      //          })
      //          .catch(error => {
      //             console.error('Error fetching labels:', error);
      //          });
      //       }


      //       handleInput() {
      //          // Ensure availableItems is populated
      //          if (!this.availableItems.length) {
      //                console.error('No labels available');
      //                return; // Exit if availableItems is empty
      //          }

      //          const value = this.input.value.trim().toLowerCase();
               
      //          if (value) {
      //                this.suggestions = this.availableItems
      //                   .filter(item => !this.tags.includes(item))
      //                   .filter(item => item.toLowerCase().includes(value));
      //                this.showSuggestions();
      //          } else {
      //                this.hideSuggestions();
      //          }
      //       }

      //       showSuggestions() {
      //          if (this.suggestionsPanel) {
      //             this.suggestionsPanel.remove();
      //          }

      //          if (this.suggestions.length === 0) {
      //             return;
      //          }

      //          this.suggestionsPanel = document.createElement('div');
      //          this.suggestionsPanel.className = 'suggestions';

      //          this.suggestions.forEach(suggestion => {
      //             const item = document.createElement('div');
      //             item.className = 'suggestion-item';
      //             item.textContent = suggestion;
      //             item.addEventListener('click', () => this.addTag(suggestion));
      //             this.suggestionsPanel.appendChild(item);
      //          });

      //          this.container.parentNode.appendChild(this.suggestionsPanel);
      //       }


      //       hideSuggestions() {
      //          if (this.suggestionsPanel) {
      //                this.suggestionsPanel.remove();
      //                this.suggestionsPanel = null;
      //          }
      //       }

      //       addTag(text) {
      //          if (text && !this.tags.includes(text)) {
      //                const tag = document.createElement('span');
      //                tag.className = 'tag';
      //                tag.innerHTML = `
      //                   ${text}
      //                   <span class="remove">×</span>
      //                `;

      //                tag.querySelector('.remove').addEventListener('click', () => this.removeTag(tag, text));
                     
      //                this.container.insertBefore(tag, this.input);
      //                this.tags.push(text);
      //                this.input.value = '';
      //                this.hideSuggestions();
      //          }
      //       }

      //       removeTag(tagElement, text) {
      //          tagElement.remove();
      //          this.tags = this.tags.filter(tag => tag !== text);
      //       }

      //       handleKeydown(e) {
      //          if (e.key === 'Enter' && this.suggestions.length > 0) {
      //                e.preventDefault();
      //                this.addTag(this.suggestions[0]);
      //          }
      //       }

      //       handleClickOutside(e) {
      //          if (!this.container.contains(e.target) && !this.suggestionsPanel?.contains(e.target)) {
      //                this.hideSuggestions();
      //          }
      //       }
      //    }

      // // Initialize the tags input after DOM content is loaded
      // document.addEventListener('DOMContentLoaded', () => {
      //    const tagsInput = new TagsInput(document.getElementById('tagsInput'));
      // });


      // $(document).ready(function() {
      //    $('#label-input').on('input', function() {
      //       var query = $(this).val(); // Get the current input value

      //       if (query.length >= 1) { // Start the request only if at least one character is typed
      //             $.ajax({
      //                url: '/organization/api/getLabels', // Your route
      //                method: 'GET',
      //                data: { query: query }, // Send the query
      //                success: function(response) {
      //                   // Show the suggestions list
      //                   var suggestions = $('#suggestions-list');
      //                   suggestions.empty(); // Clear the previous suggestions
      //                   if (response.length > 0) {
      //                         response.forEach(function(label) {
      //                            suggestions.append('<li class="list-group-item">' + label + '</li>');
      //                         });
      //                         suggestions.show();
      //                   } else {
      //                         suggestions.hide(); // Hide if no results
      //                   }
      //                }
      //             });
      //       } else {
      //             $('#suggestions-list').hide(); // Hide suggestions if the input is empty
      //       }
      //    });

      //    // Close suggestions when clicking outside
      //    $(document).on('click', function(event) {
      //       if (!$(event.target).closest('#label-input').length) {
      //             $('#suggestions-list').hide();
      //       }
      //    });

      //    // Handle click on suggestion
      //    $(document).on('click', '.list-group-item', function() {
      //       var selectedLabel = $(this).text();
      //       $('#label-input').val(selectedLabel); // Set the input field value
      //       $('#suggestions-list').hide(); // Hide the suggestions
      //    });
      // });

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
                            suggestions.append('<li class="list-group-item" data-label="' + label + '">' + label + '</li>');
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
                   var tag = $(`
                           <div class="col-md-6" 
                                 style="padding-bottom: 10px;"> <!-- Added padding here -->
                              <li class="badge badge-info mr-2 p-2" 
                                    style="background-color: white; 
                                          color: black; 
                                          display: inline-block; 
                                          margin-right: 10px; 
                                          border-radius: 10px; 
                                          border: 2px solid black;">
                                    ${label}
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
         $('form').on('submit', function(e) {
            if (selectedLabels.length < 5) { // Check if fewer than 5 labels are selected
                  e.preventDefault(); // Prevent form submission
                  $('#error-message').show(); // Show error message
            }
         });
      });





   //    $(document).ready(function() {
   //  // Initialize Select2 for the tags input
   //       $('#tags').select2({
   //          placeholder: 'Select Tags',
   //          allowClear: true,
   //          tags: true // Allow typing in the input (this enables tag creation)
   //       });

   //  // Fetch tags from the server
   //    $.ajax({
   //       url: "{{ route('getLabels') }}",
   //       method: 'GET',
   //       success: function(response) {
   //             let options = response.map(function(label) {
   //                return {
   //                   id: label.id, 
   //                   text: label.name // Adjust according to your 'labels' table structure
   //                };
   //             });

   //             // Populate the Select2 dropdown with the fetched labels
   //             $('#tags').select2({
   //                data: options,
   //                placeholder: 'Select Tags',
   //                allowClear: true,
   //                tags: true // Make sure 'tags' is set to true
   //             });
   //       },
   //       error: function(error) {
   //             console.log('Error fetching tags:', error);
   //       }
   //    });
   // });



   </script>

</div>
</div>
@endsection
