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

            <!-- Start::row-1 -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Approved Content</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-nowrap w-100 data-table">
                                    <thead class="table-borderless">
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Content Name</th>
                                            <th scope="col">Content Type</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Promote Content</th>

                                            <th scope="col">xBUG Stand</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row-1 -->

            <!-- Dynamic Modal -->
            <div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="dynamicModalLabel">View Content</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('promote-content.payment') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <!-- Content Name -->
                                <input type="hidden" name="content_id" id="content_id">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="contentName" name="content_name"
                                            readonly>
                                        <label for="contentName">Content Name</label>
                                    </div>
                                </div>

                                <!-- Package Selection -->
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="package" name="package">

                                            @foreach ($packages as $index => $package)
                                                <option value="{{ $package->id }}"
                                                    data-base-price="{{ $package->base_price }}"
                                                    data-base-state="{{ $package->base_state }}"
                                                    @if ($index == 0) selected @endif>
                                                    <!-- Select the first package -->
                                                    {{ $package->name }} | RM {{ $package->base_price }} |
                                                    {{ $package->estimate_user }} estimate reach.
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="package">Choose Package</label>
                                    </div>
                                </div>


                                <!-- State Selection -->
                                <div class="mb-3">
                                    <label class="form-label" id="state_label">Select at least 1 states to promote</label>
                                    <span class="text-muted"> - scroll down </span>
                                    <div id="state-container"
                                        style="max-height: 250px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                        @foreach ($states as $state)
                                            <div class="form-check form-check-lg">
                                                <input class="form-check-input state-checkbox" type="checkbox"
                                                    name="states[]" value="{{ $state->name }}"
                                                    id="state-{{ $state->name }}">
                                                <label class="form-check-label"
                                                    for="state-{{ $state->name }}">{{ $state->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>



                                <!-- Final Price -->
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="finalPrice" name="final_price"
                                            value="RM 0.00" readonly>
                                        <label for="finalPrice">Final Price</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="pay-btn" disabled>Pay</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- Smart Card Modal -->
            <div class="modal fade" id="smartCardModal" tabindex="-1" aria-labelledby="smartCardModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="smartCardModalLabel">Apply xBUG Stand</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="smartCardForm" action="" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="form-floating">
                                                <input type="date" class="form-control" id="startDate" name="startDate">
                                                <label for="startDate">Start Date</label>
                                            </div>
                                            <div class="form-floating mt-3">
                                                <input type="time" class="form-control" id="startTime" name="startTime">
                                                <label for="startTime">Start Time</label>
                                            </div>
                                            <div class="form-floating mt-3">
                                                <input type="date" class="form-control" id="endDate" name="endDate">
                                                <label for="endDate">End Date</label>
                                            </div>
                                            <div class="form-floating mt-3">
                                                <input type="time" class="form-control" id="endTime" name="endTime">
                                                <label for="endTime">End Time</label>
                                            </div>
                                            <div class="form-floating mt-3">
                                                <input type="number" class="form-control" id="numXbugStand" name="numXbugStand" min="1" max="10" value="1">
                                                <label for="numXbugStand">Number of the xBUG Stand</label>
                                                <div id="xbugStandHelp" class="form-text">Maximum of 10 stands. For larger requests, please email <a href="mailto:admin@xbug.online">admin@xbug.online</a>.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Payment Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<!-- 
            @foreach ($content_data as $data)
                <form action="{{ route('addCardOrganization', $data->id) }}" method="post">
                    @csrf
                    <div class="modal fade" id="modalAddCard-{{ $data->id }}" aria-labelledby="addCard">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="addCard">Apply Smart Card For - {{ $data->name }}
                                    </h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <div class="form-floating">
                                                    <input type="date" class="form-control" id="floatingInputprimary"
                                                        name="startDate" value="">
                                                    <label for="floatingInputprimary">Start Date</label>
                                                </div>
                                                <div class="form-floating mt-3">
                                                    <input type="time" class="form-control" id="floatingInputprimary"
                                                        name="startTime" value="">
                                                    <label for="floatingInputprimary">Start Time</label>
                                                </div>
                                                <div class="form-floating mt-3">
                                                    <input type="date" class="form-control" id="floatingInputprimary"
                                                      name="endDate" value="">
                                                    <label for="floatingInputprimary">End Date</label>
                                                </div>
                                                <div class="form-floating mt-3">
                                                    <input type="time" class="form-control" id="floatingInputprimary"
                                                         name="endTime" value="">
                                                    <label for="floatingInputprimary">End Time</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <button class="btn btn-danger me-3" data-bs-dismiss="modal"
                                                aria-label="Close">Cancel</button>
                                            <button type="submit" class="btn btn-primary">
                                                Payment Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endforeach -->

        </div>
    </div>

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
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'card',
                        name: 'card'
                    },
                   
                ],
            });



            const calculateFinalPrice = () => {
                const selectedPackage = $('#package option:selected');

                const basePrice = parseFloat(selectedPackage.data('base-price')) || 0;
                const baseState = parseInt(selectedPackage.data('base-state')) || 0;


                $('#state_label').text(`Select at least ${baseState} states to promote`);

                // Count the selected states
                const selectedStatesCount = $('.state-checkbox:checked').length;

                $('#pay-btn').prop('disabled', (selectedStatesCount < baseState));


                // Calculate the final price
                const n = selectedStatesCount;
                const finalPrice = basePrice * (1 + Math.max(n - baseState, 0) / 10);


                // Update the final price input
                $('#finalPrice').val(`RM ${finalPrice.toFixed(2)}`);
            };

            // Event listener to open modal and populate data
            $(document).on('click', '.view-content', function() {
                const contentData = $(this).data();
                $('#dynamicModalLabel').text(`View Content - ${contentData.name}`);

                $('#content_id').val(contentData.id)
                $('#contentName').val(contentData.name);

                $('#finalPrice').val('RM 0.00'); // Reset the final price

                // Recalculate final price when state checkboxes or package dropdown change
               
            });

            $(document).on('click', '.smart-card-btn', function() {
                const contentId = $(this).data('id');
                const contentName = $(this).data('name');
                $('#smartCardModalLabel').text(`Apply xBUG Stand For - ${contentName}`);
                let routeTemplate = "{{ route('addCardOrganization', ':id') }}";
                let action = routeTemplate.replace(':id', contentId);

                // Set the action attribute for the form
                $('#smartCardForm').attr('action', action);
                // Reset form
                $('#smartCardForm')[0].reset();

                const today = new Date();
                const yyyy = today.getFullYear();
                const mm = String(today.getMonth() + 1).padStart(2, '0'); // Month (0-based, so +1)
                const dd = String(today.getDate()).padStart(2, '0');

                // Start date and time
                const startDate = `${yyyy}-${mm}-${dd}`;
                const startTime = "08:00";

                // End date (7 days after today)
                const endDateObj = new Date();
                endDateObj.setDate(today.getDate() + 7);
                const endYYYY = endDateObj.getFullYear();
                const endMM = String(endDateObj.getMonth() + 1).padStart(2, '0');
                const endDD = String(endDateObj.getDate()).padStart(2, '0');
                const endDate = `${endYYYY}-${endMM}-${endDD}`;
                const endTime = "18:00";

                // Populate the input fields using jQuery
                $("#startDate").val(startDate);
                $("#startTime").val(startTime);
                $("#endDate").val(endDate);
                $("#endTime").val(endTime);
                
            });

            $('.state-checkbox').off('change').on('change', calculateFinalPrice);
            $('#package').off('change').on('change', calculateFinalPrice);

        });
    </script>
@endsection
