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
      <div class="card custom-card">
         <div class="card-header">
            <div class="card-title">Approved Content</div>
         </div>
         <div class="table-responsive">
            <table class="table text-nowrap  data-table">
               <thead class="table-borderless ">
                  <tr>
                     <th scope="col">No.</th>
                     <th scope="col">Content Name</th>
                     <th scope="col">Content Type</th>
                     <th scope="col">Status</th>
                     <th scope="col">Action</th>
                  </tr>
               </thead>

            </table>
         </div>
      </div>
      <!--End::row-1 -->
   </div>
</div>
@foreach ($content_data as $data)
                <div class="modal fade" id="modalView-{{ $data->id }}">
    
                    <div
                        class="modal-dialog modal-dialog-centered text-center ">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">View Content - {{ $data->name }} </h6>
                                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('updateUser', $data->id) }}" method="POST">
                                @csrf
                                <div class="modal-body text-start">
                                <form action="#" method="POST">
                                @csrf
                                <!-- Content Details -->
                                <div class="mb-3">
                                    <label for="content_id" class="form-label">Content ID</label>
                                    <input type="text" class="form-control" id="content_id" name="content_id"
                                        value="{{ $data->id }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="content_name" class="form-label">Content Name</label>
                                    <input type="text" class="form-control" id="content_name" name="content_name"
                                        value="{{ $data->name }}" readonly>
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
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Delete user Record">Delete</button>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>
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
                            

                        </div>
                    </div>
                </div>
            @endforeach

<script>
        $(document).ready(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: "{{ route('showContent') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        // visible:false
                    },
                    {
                        data: 'type',
                        name: 'type',
                        // render: ((data, type, row) => {
                        //     return data.toUpperCase();
                        // })

                    },
                    {
                        data: 'reason_phrase',
                        name: 'reason_phrase',

                    },
                    {
                        data: 'action',
                        name: 'action',

                    },
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: 'Copy Data',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'Export CSV',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Export Excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'Export PDF',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print Data',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            });
        })
    </script>
@endsection