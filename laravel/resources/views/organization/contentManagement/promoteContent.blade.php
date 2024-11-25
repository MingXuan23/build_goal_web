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
                                    <input type="text" class="form-control" id="content_id" name="content_id"
                                        value="{{ $content->id }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="content_name" class="form-label">Content Name</label>
                                    <input type="text" class="form-control" id="content_name" name="content_name"
                                        value="{{ $content->name }}" readonly>
                                </div>
                                
                                
                                <!-- State Selection (Checkbox) -->
                                <div class="mb-3">
                                    <label class="form-label">Select States</label>
                                    <div id="state-container">
                                        @foreach (array_keys($stateCities) as $state)
                                            <div class="form-check">
                                                <input class="form-check-input state-checkbox" type="checkbox"
                                                    name="states[]" value="{{ $state }}" id="state-{{ $state }}">
                                                <label class="form-check-label" for="state-{{ $state }}">
                                                    {{ $state }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- City Selection (Checkboxes) -->
                                <div class="mb-3">
                                    <label class="form-label">Select Cities</label>
                                    <div id="city-container">
                                        <p class="text-muted">Please select a state to view cities.</p>
                                    </div>
                                </div>

                                <!-- Package Selection -->
                                <div class="mb-3">
                                    <label for="package" class="form-label">Choose Package </label>
                                    <select class="form-select" id="package" name="Package" required>
                                        <option value="" disabled selected>Choose Package (package will be extracted
                                            from the database)</option>
                                        <option value="1">Package A (Target Users: 50 - 100, Price: RM 100)</option>
                                        <option value="2">Package B (Target Users: 101 - 200, Price: RM 200)</option>
                                        <option value="3">Package C (Target Users: 201 - 300, Price: RM 300)</option>
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary me-2">Pay</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--End::row-1 -->
        </div>
    </div>
    <script>
        const stateCities = @json($stateCities);

        const stateCheckboxes = document.querySelectorAll('.state-checkbox');
        const cityContainer = document.getElementById('city-container');

        stateCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                cityContainer.innerHTML = '';

                const selectedStates = Array.from(stateCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (selectedStates.length === 0) {
                    cityContainer.innerHTML = '<p class="text-muted">Please select a state to view cities.</p>';
                } else {
                    selectedStates.forEach(state => {
                        if (stateCities[state]) {
                            const stateHeading = document.createElement('h5');
                            stateHeading.textContent = state;
                            cityContainer.appendChild(stateHeading);

                            stateCities[state].forEach(city => {
                                const checkboxWrapper = document.createElement('div');
                                checkboxWrapper.classList.add('form-check');

                                const checkbox = document.createElement('input');
                                checkbox.type = 'checkbox';
                                checkbox.className = 'form-check-input';
                                checkbox.name = 'cities[]'; 
                                checkbox.value = `${state} - ${city}`; 

                                const label = document.createElement('label');
                                label.className = 'form-check-label';
                                label.textContent = city;

                                checkboxWrapper.appendChild(checkbox);
                                checkboxWrapper.appendChild(label);

                                cityContainer.appendChild(checkboxWrapper);
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
