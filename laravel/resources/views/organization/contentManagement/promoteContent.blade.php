@extends('organization.layouts.main')
@section('container')
    {{-- @dd($stateCities) --}}
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
                                <div class="mb-3">
                                    <label for="state" class="form-label">Select State</label>
                                    <select class="form-select" id="state" name="state">
                                        <option value="" disabled selected>Select a State</option>
                                        @foreach (array_keys($stateCities) as $state)
                                            <option value="{{ $state }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="city" class="form-label">Select City</label>
                                    <select class="form-select" id="city" name="city" disabled>
                                        <option value="" disabled selected>Select a City</option>
                                    </select>
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

        const stateSelect = document.getElementById('state');
        const citySelect = document.getElementById('city');
        stateSelect.addEventListener('change', function() {
            const selectedState = this.value;

            citySelect.innerHTML = '<option value="" disabled selected>Select a City</option>';

            if (selectedState && stateCities[selectedState]) {
                citySelect.disabled = false; 

                stateCities[selectedState].forEach(city => {
                    const option = document.createElement('option');
                    option.value = city;
                    option.textContent = city;
                    citySelect.appendChild(option);
                });
            } else {
                citySelect.disabled = true;
            }
        });
    </script>
@endsection
