@extends('organization.layouts.main')
@section('container')
    {{-- @dd($content_data); --}}
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
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Approved Content</div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-nowrap w-100 data-table">
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
                    </div>
                </div>
            </div>
            <!--End::row-1 -->
            @foreach ($content_data as $data)
                <div class="modal fade" id="modalView-{{ $data->id }}">
                    <div class="modal-dialog modal-dialog-centered text-center modal-xl">
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
                                                    <div class="form-check form-check-lg">
                                                        <input class="form-check-input state-checkbox" type="checkbox"
                                                            name="states[]" value="{{ $state }}"
                                                            id="state-{{ $state }}">
                                                        <label class="form-check-label" for="state-{{ $state }}">
                                                            {{ $state }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    
                                        <!-- Package Selection -->
                                        <div class="mb-3">
                                            <label for="package" class="form-label">Choose Package </label>
                                            <select class="form-select" id="package" name="package" required>
                                                <option value="" disabled selected>Select Package</option>
                                                @foreach ($packages as $package)
                                                    <option value="{{ $package->id }}"data-base-price="{{ $package->base_price }}" data-base-state="{{ $package->base_state }}">{{ $package->name }} | RM {{ $package->base_price }} | {{ $package->estimate_user }} ppl.</option>
                                                @endforeach
                                            </select>
                                        </div>

                                         <!-- Final Price Display -->
                                        <div class="mb-3">
                                            <label for="final_price" class="form-label">Final Price</label>
                                            <input type="text" class="form-control" id="final_price" name="final_price" value="RM 0.00" readonly>
                                        </div>


                                        <!-- Submit Button -->
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="submit" class="btn btn-primary me-2">Pay</button>
                                        </div>
                                    </form>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger " data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Delete user Record">Delete</button>
                                    <button type="button" class="btn btn-primary " data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>



                        </div>
                    </div>
                </div>
            @endforeach

            @foreach ($content_data as $data)
                <div class="modal fade" id="reject-{{ $data->id }}" aria-labelledby="reject">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="reject">Rejection Reason for - {{ $data->name }}</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="rejection_reason" class="form-label">Reason</label>
                                            <textarea class="form-control" required disabled>{{ $data->reject_reason }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button class="btn btn-danger" data-bs-dismiss="modal"
                                            aria-label="Close">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
                        data: 'status',
                        name: 'status',

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
<script>
    $(document).ready(function () {
    const calculateFinalPrice = () => {
        // Get selected package
        const selectedPackage = $('#package option:selected');
        const basePrice = parseFloat(selectedPackage.data('base-price')) || 0;
        const baseState = parseInt(selectedPackage.data('base-state')) || 0;

        // Count selected states
        const selectedStatesCount = $('.state-checkbox:checked').length;

        // Calculate final price
        const n = selectedStatesCount;
        const finalPrice = basePrice * (1 + (n - baseState) / 10);

        // Update final price in the input
        $('#final_price').val(`RM ${finalPrice.toFixed(2)}`);
    };

    // Event listeners
    $('#package').on('change', calculateFinalPrice);
    $('.state-checkbox').on('change', calculateFinalPrice);
});
</script>
@endsection
