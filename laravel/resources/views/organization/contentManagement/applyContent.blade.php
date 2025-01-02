@extends('organization.layouts.main')
@section('container')
    <div class="main-content app-content">
        <div class="container">
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
                                <div class="col-md-6">
                                    <p class="fw-semibold mt-2">Content Details</p>
                                    <hr>
                                    <div class="row gy-2">
                                        <div class="col-xl-12">
                                            <div class="form-floating">
                                                <input type="text"
                                                    class="form-control @error('content_name') is-invalid @enderror"
                                                    id="contentName" placeholder="Enter Content Name" name="content_name"
                                                    value="{{ old('content_name') }}">
                                                <label for="contentName">Content Name</label>
                                                @error('content_name')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="col-md-12 text-end">
                                                    <span class="text-success text-end fw-bold"
                                                        id="generate-suggestions">Generate
                                                        suggestions</span><i class='bx bx-loader text-success fw-bold'></i>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-floating">
                                                        <textarea class="form-control @error('content_desc') is-invalid @enderror" id="contentDescription"
                                                            placeholder="Enter Content Description" name="content_desc" style="height: 150px;">{{ old('content_desc') }}</textarea>
                                                        <label for="contentDescription">Content Description</label>
                                                        @error('content_desc')
                                                            <span class="mb-1 text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="form-floating">
                                                <input type="url"
                                                    class="form-control @error('content_link') is-invalid @enderror"
                                                    id="contentLink" placeholder="Enter Related Link" name="content_link"
                                                    value="{{ old('content_link') }}">
                                                <label for="contentLink">Content Link</label>
                                                @error('content_link')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="form-floating">
                                                <select class="form-select @error('content_type_id') is-invalid @enderror"
                                                    id="content_types" name="content_type_id">
                                                    <option value="" disabled selected>Select Content Type</option>
                                                    @foreach ($content_types as $content_type)
                                                        <option value="{{ $content_type->id }}"
                                                            @selected(old('content_type_id') == $content_type->id)>{{ $content_type->type }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="content_type_id">Content Type</label>
                                                @error('content_type_id')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <label for="label-input">Search Labels:</label>
                                            <input type="text" id="label-input" class="form-control"
                                                placeholder="Start typing..." autocomplete="off">
                                            <ul id="suggestions-list" class="list-group mt-2" style="display:none;"></ul>
                                        </div>
                                        <div id="selected-labels" class="col-xl-12">
                                            <p>Selected Labels:</p>
                                            <ul id="selected-labels-list" class="list-group d-flex flex-wrap"
                                                style="display: flex; gap: 10px; list-style: none; padding: 0; flex-direction: initial">
                                            </ul>
                                        </div>
                                        <p id="error-message" class="text-danger" style="display: none;">Please select at
                                            least 5 labels.</p>
                                        <div class="col-xl-12">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p class="fw-semibold mt-2">Content Information</p>
                                    <hr>
                                    <div class="row gy-2">
                                        <div class="col-xl-12">
                                            <div class="form-floating">
                                                <input type="number"
                                                    class="form-control @error('enrollment_price') is-invalid @enderror"
                                                    id="enrollment_price" placeholder="Enter Enrollment Price"
                                                    name="enrollment_price" value="{{ old('enrollment_price') }}">
                                                <label for="enrollmentPrice">Enrollment Price (in RM)</label>
                                                @error('enrollment_price')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="form-floating">
                                                <input type="text"
                                                    class="form-control form-control @error('place') is-invalid @enderror"
                                                    id="place" placeholder="Enter Place" name="place"
                                                    value="{{ old('place') }}">
                                                <label for="place">Place</label>
                                                @error('place')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="form-floating">
                                                <input type="number"
                                                    class="form-control @error('participant_limit') is-invalid @enderror"
                                                    id="participant_limit" placeholder="Enter Participant Limit"
                                                    name="participant_limit" value="{{ old('participant_limit') }}">
                                                <label for="participant_limit">Participant Limit</label>
                                                @error('participant_limit')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <label for="image" class="form-label mt-1">Upload Your Content Image</label>
                                            <div class="">
                                                <input type="file"
                                                    class="form-control @error('image') is-invalid @enderror"
                                                    id="image" placeholder="Upload Your Content Image"
                                                    name="image">
                                               
                                                @error('image')
                                                    <span class="mb-1 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="form-floating">
                                                <select class="form-select @error('state') is-invalid @enderror"
                                                    name="state" id="state-select"
                                                    style="max-height: 250px; overflow-y: auto; border: 1px solid #ddd;">
                                                    <option value="" disabled selected>Select a state</option>
                                                    @foreach ($states as $state)
                                                        <option value="{{ $state->name }}" @selected(old('state') == $state->name)>
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
                                <input type="hidden" id="labelIds" name="labelIds" value="">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">

                                        </div>
                                        <div class="col-md-2 text-end">

                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success mt-5 px-4" name="Add">Apply
                                                Content</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            var selectedLabels = [];


            $('#label-input').on('input', function() {
                var query = $(this).val();

                if (query.length >= 1) {
                    $.ajax({
                        url: '/organization/api/getLabels',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            var suggestions = $('#suggestions-list');
                            suggestions.empty();
                            if (response.length > 0) {
                                response.forEach(function(label) {
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
                    $('#suggestions-list').hide();
                }
            });

            $(document).on('click', '.list-group-item', function() {
                var selectedLabel = $(this).data('labelid');
                if (!selectedLabels.some(label => label.id === selectedLabel.id)) {
                    selectedLabels.push(selectedLabel);
                    updateSelectedLabels();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'This label has been selected',
                        customClass: {
                            title: 'custom-title',
                            content: 'custom-content'
                        }
                    });
                }
                $('#label-input').val('');
                $('#suggestions-list').hide();
            });

            function updateSelectedLabels() {
                var selectedLabelsContainer = $('#selected-labels-list');
                selectedLabelsContainer.empty();

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

                    tag.find('.close').on('click', function() {
                        selectedLabels = selectedLabels.filter(function(item) {
                            return item !== label;
                        });
                        updateSelectedLabels();
                    });

                    selectedLabelsContainer.append(tag);
                });
            }
            $('form').on('submit', async function(e) {
                e.preventDefault();

                if (selectedLabels.length < 5) {
                    $('#error-message').show();
                    return;
                }

                $('#error-message').hide();

                try {
                    const labelIds = selectedLabels.map(label => label.id);
                    $('#labelIds').val(labelIds);

                    this.submit();
                } catch (error) {
                    console.error('Error fetching weights:', error);
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

        $(document).ready(function() {
            $('#generate-suggestions').on('click', function() {
                const contentName = $('#contentName').val();

                if (!contentName) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Content Name is required',
                        text: 'Please provide a Content Name to generate suggestions.',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Generating suggestions...',
                    text: 'Please wait while we generate your content description.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                $.ajax({
                    url: '{{ route('generateDescription') }}',
                    method: 'POST',
                    data: {
                        content_name: contentName,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        Swal.close();
                        if (response.status === 'success') {
                            // $('#contentDescription').val(response.description);

                           //  Swal.fire({
                           //      icon: 'success',
                           //      title: 'Description Generated',
                           //      text: 'The description has been successfully generated.',
                           //  });
                            displayResponseInTextarea(response.description,
                                'contentDescription');
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
    </script>
@endsection
