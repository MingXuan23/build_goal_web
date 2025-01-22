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
            <div class="card custom-card">
                <div class="card-header justify-content-between m-0 col-md-12">
                    <div class="card-title col-md-12">
                        MicroLearning Content
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('uploadMicroLearning') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="content_name" class="form-label">Title</label>
                            <input type="text" class="form-control" id="content_name" name="content_name" required
                                value="{{ old('content_name') }}">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Thumbnail (Image)</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <div class="mb-3">
                            <label for="content_desc" class="form-label">Description</label>
                            <div class="text-end">
                                <span class="text-success text-end fw-bold" id="generate-description">Generate
                                    suggestions</span><i class='bx bx-loader text-success fw-bold'></i>
                            </div>
                            <textarea class="form-control" id="content_desc" name="content_desc" rows="10" required>{{ old('content_desc') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="label-input">Search Labels:</label>
                            <input type="text" id="label-input" class="form-control" placeholder="Start typing..."
                                autocomplete="off">
                            <ul id="suggestions-list" class="list-group mt-2" style="display:none;"></ul>
                        </div>
                        <div id="selected-labels" class="mb-3 mt-3">
                            <ul id="selected-labels-list" class="list-group d-flex flex-wrap"
                                style="display: flex; gap: 10px; list-style: none; padding: 0; flex-direction: initial">
                            </ul>
                        </div>
                        <p id="error-message" class="text-danger" style="display: none;">Please select at least 5 labels.
                        </p>
                        <!-- Button to Show Add Section Form -->
                        <button type="button" id="showSectionFormButton" class="btn btn-primary"
                            onclick="showSectionForm()">Add Section</button>
                        <!-- Add Section Input Form -->
                        <div id="sectionInput" class="mt-3" style="display: none;">
                            <label for="sectionHeader" class="form-label">Section Header</label>
                            <input type="text" id="sectionHeader" class="form-control"
                                placeholder="Enter Section Header">
                            <label for="sectionBody" class="form-label mt-2">Section Body</label>
                            <textarea id="sectionBody" class="form-control" rows="3" placeholder="Enter Section Body"></textarea>
                            <button type="button" class="btn btn-success mt-3" onclick="addSection()">Add this
                                section</button>
                        </div>
                        <!-- Container to Display Sections -->
                        <div id="sectionsContainer" class="mt-4">
                            <!-- Sections will be dynamically displayed here -->
                        </div>
                        <!-- Hidden Input for Formatted Content -->
                        <input type="hidden" id="formattedContent" name="formattedContent">
                        <input type="hidden" id="labelIds" name="labelIds" value="">
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
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

                    // Update the hidden field with the formatted content
                    document.getElementById('formattedContent').value = formattedString;

                    // Clear the input fields
                    document.getElementById('sectionHeader').value = '';
                    document.getElementById('sectionBody').value = '';

                    // Update and display the sections container
                    updateSectionsContainer();

                    // Hide the section input form
                    document.getElementById('sectionInput').style.display = 'none';
                } else {
                    //   alert('Please fill out both the Section Header and Body.');
                    Swal.fire({
                        icon: 'error',
                        title: 'Please fill out both the Section Header and Body.',
                        customClass: {
                            title: 'custom-title',
                            content: 'custom-content'
                        }
                    });
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
                <div class="section mb-3">
                    <h3>Step ${index + 1}: ${header}</h3>
                    <p>${body}</p>
                </div>
            `;
                    }
                });

                container.innerHTML = html;
            }

            function showSectionForm() {
                document.getElementById('sectionInput').style.display = 'block';
            }




            //     function generatePreview() {
            //         const title = document.getElementById('content_name').value;
            //         const description = document.getElementById('content_desc').value;
            //         const formattedContent = document.getElementById('formattedContent').value;
            //         const preview = document.getElementById('preview');
            //         const previewCard = document.getElementById('previewCard');
            //         const form = document.querySelector('form'); // Reference to the form

            //         // Validate inputs
            //         if (!title || !description || !formattedContent) {
            //             alert('Please fill in the Title, Description, and add at least one Section.');
            //             return;
            //         }

            //         // Generate the preview HTML
            //         let html = `
    //    <h1>${title}</h1>
    //    <p><em>${description}</em></p>
    //    <hr>
    // `;

            //         const contentSections = formattedContent.split('\n\n');
            //         contentSections.forEach((section, index) => {
            //             const headerMatch = section.match(/\*\*\*(.*?)\*\*\*/); // Match header in ***
            //             if (headerMatch) {
            //                 const header = headerMatch[1]; // Extract header
            //                 const body = section.replace(/\*\*\*(.*?)\*\*\*/, '').trim(); // Remove header and extract body

            //                 // Append formatted section to preview
            //                 html += `
    //             <div class="preview-section">
    //                <h2>Step ${index + 1}: ${header}</h2>
    //                <p>${body}</p>
    //             </div>
    //          `;
            //             }
            //         });

            //         // Append the Upload button to the preview
            //         html += `
    //    <div class="col-md-12">
    //          <div class="row">
    //             <div class="col-md-8"></div>
    //             <div class="col-md-2 text-end"></div>
    //             <div class="col-md-2">
    //                <button type="submit" class="btn btn-success mt-5 px-4">Upload</button>
    //             </div>
    //          </div>
    //    </div>
    // `;

            //         // Display the preview in the card
            //         preview.innerHTML = html;
            //         preview.style.display = 'block'; // Show the preview content
            //         previewCard.style.display = 'block'; // Show the preview card

            //         // Optionally hide the main content form
            //         document.querySelector('.card-body').style.display = 'none'; // Hide the form
            //     }


            //     function returnToForm() {
            //         const preview = document.getElementById('preview');
            //         const previewCard = document.getElementById('previewCard'); // The card containing the preview
            //         const mainContent = document.querySelector('.card-body'); // The form content (inside card-body)

            //         // Hide the preview
            //         preview.style.display = 'none';
            //         previewCard.style.display = 'none'; // Optionally hide the entire card containing the preview

            //         // Show the form again
            //         mainContent.style.display = 'block';
            //     }



            $(document).ready(function() {
                var selectedLabels = []; // Array to store selected labels

                // Handle input and filter suggestions based on the user input
                $('#label-input').on('input', function() {
                    var query = $(this).val(); // Get the current input value

                    if (query.length >= 1) {
                        $.ajax({
                            url: '/organization/api/getLabels', // Your route
                            method: 'GET',
                            data: {
                                query: query
                            }, // Send the query
                            success: function(response) {
                                var suggestions = $('#suggestions-list');
                                suggestions.empty(); // Clear the previous suggestions
                                if (response.length > 0) {
                                    response.forEach(function(label) {
                                        // Escape JSON string for HTML attribute

                                        // const dataLabel = JSON.stringify(label).replace(/"/g, '&quot;');
                                        suggestions.append(
                                            '<li class="list-group-item" data-labelid="' +
                                            JSON.stringify(label).replace(/"/g,
                                                '&quot;') +
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
                    if (!selectedLabels.some(label => label.id === selectedLabel
                            .id)) { // Prevent duplicate selections
                        selectedLabels.push(selectedLabel); // Add the label to the selected labels array
                        updateSelectedLabels(); // Update the displayed selected labels
                    } else {
                        // alert('This label has been selected');
                        Swal.fire({
                            icon: 'error',
                            title: 'This label has been selected',
                            customClass: {
                                title: 'custom-title',
                                content: 'custom-content'
                            }
                        });
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
                $('form').on('submit', async function(e) {
                    e.preventDefault(); // Prevent default form submission

                    if (selectedLabels.length < 5) {
                        $('#error-message').show();
                        return;
                    }

                    $('#error-message').hide();

                    try {
                        const labelIds = selectedLabels.map(label => label.id); // Extract label IDs
                        $('#labelIds').val(labelIds);
                        // console.log(selectedLabels, labelIds)

                        // const response = await fetch(`http://localhost:30000/api/vector/getVectorValue?values=${JSON.stringify(labelIds)}`);
                        // const data = await response.json(); // Parse API response

                        // // Assuming API response contains a `weights` array
                        // const weights = data.weights || [];
                        // console.log(weights,data)
                        // document.getElementById('formattedContent').value += `\nCategory Weights: ${weights.join(', ')}`;

                        // // Inject `category_weight` into a hidden input field
                        // const categoryWeightInput = document.createElement('input');
                        // categoryWeightInput.type = 'hidden';
                        // categoryWeightInput.name = 'category_weight';
                        // categoryWeightInput.value = JSON.stringify(weights); // Pass weights as JSON string
                        // this.appendChild(categoryWeightInput);

                        // Submit the form after processing the weights
                        this.submit();
                    } catch (error) {
                        console.error('Error fetching weights:', error);
                        // alert('An error occurred while processing your request. Please try again.');
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred while processing your request. Please try again.',
                            customClass: {
                                title: 'custom-title',
                                content: 'custom-content'
                            }
                        });
                    }
                });

            });
        </script>

        <script>
            $(document).ready(function() {
                $('#generate-description').on('click', function() {
                    const contentName = $('#content_name').val();

                    if (!contentName) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Content Name is required',
                            text: 'Please provide a Content Name to generate a description.',
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Generating suggestion...',
                        text: 'Please wait while we generate the description.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    $.ajax({
                        url: '{{route('generateDescriptionMicro')}}', // Route ke API Anda
                        method: 'POST',
                        data: {
                            content_name: contentName,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            Swal.close();
                            if (response.status === 'success') {
                                displayResponseInTextarea(response.description, 'content_desc');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message ||
                                    'An error occurred. Please try again.',
                            });
                        },
                    });
                });
            });

            // Fungsi untuk menampilkan teks satu per satu di dalam textarea
            function displayResponseInTextarea(message, textareaId) {
                const textarea = $(`#${textareaId}`);
                let messageIndex = 0;
                let isTag = false;
                let tagBuffer = '';
                let currentTag = '';
                let isBold = false;
                let boldTextBuffer = '';
                let formattedMessage = '';

                textarea.val(''); // Kosongkan textarea sebelum memulai

                const intervalId = setInterval(function() {
                    let char = message.charAt(messageIndex);
                    messageIndex++;

                    if (char === '<') {
                        isTag = true;
                        tagBuffer = '<';
                        currentTag = '';
                    } else if (char === '>') {
                        isTag = false;
                        tagBuffer += '>';
                        formattedMessage += tagBuffer;
                        tagBuffer = '';
                    }

                    if (isTag) {
                        tagBuffer += char;
                    } else {
                        if (char === '*' && message.charAt(messageIndex) === '*') {
                            if (isBold) {
                                formattedMessage += boldTextBuffer;
                                boldTextBuffer = '';
                            }
                            isBold = !isBold;
                            messageIndex++;
                        } else {
                            if (isBold) {
                                boldTextBuffer += char;
                            } else {
                                if (char === '\n') {
                                    formattedMessage += '\n'; // Ganti dengan newline untuk textarea
                                } else {
                                    formattedMessage += char;
                                }
                            }
                        }
                    }

                    // Perbarui textarea
                    textarea.val(formattedMessage);

                    // Jika teks selesai, hentikan interval
                    if (messageIndex >= message.length) {
                        clearInterval(intervalId);
                    }
                }, 10);
            }
        </script>
    </div>
    </div>
@endsection
