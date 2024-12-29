@extends('admin.layouts.main')

@section('styles')
    <style>
        #contentCardsTable .card-id {
            width: 80px;
            /* Adjust this value as needed */
        }
    </style>
@endsection
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

            @if (session()->has('status'))
                <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                    <div class="ms-3">{{ session('status') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Applied Contents</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap data-table">
                            <thead class="table-borderless">
                                <tr>
                                    <th>No.</th>
                                    <th>Content Name</th>
                                    <th>Paid At</th>
                                    <th>Assigned/Required</th>
                                    <th>Action</th>
                                    <th>Receipt</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="contentCardsModal" tabindex="-1" aria-labelledby="contentCardsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contentCardsModalLabel">Content Cards</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap" id="contentCardsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Start Date</th>
                                    <th>Start Time</th>
                                    <th>End Date</th>
                                    <th>End Time</th>
                                    <th>Card ID</th>
                                    <th>Tracking Id</th>
                                    <th>Verification Code</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dynamically populated -->
                            </tbody>
                        </table>
                    </div>
                    <button id="addNewCard" class="btn btn-success mt-3">Add New Card</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveContentCards" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: false,
                responsive: true,
                pageLength: 50,
                ajax: "{{ route('showxBugStandAdmin') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    }, // Fixed ID for numbering
                    {
                        data: 'name',
                        name: 'name'
                    }, // Content Name
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }, // Paid At
                    {
                        data: 'number_of_card',
                        name: 'number_of_card'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm view-cards" data-content-id="' +
                                row.id + '">View Cards</button>';
                        }
                    },
                    {
                        data: 'receipt',
                        name: 'receipt',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {

                            return '<button class="btn btn-primary btn-sm "> <a class="text-white" href="' +
                                data + '" target="_blank"">View Receipt</a></button>';
                        }

                    },
                    // Receipt (assuming receipt relates to number of cards)
                    // { 
                    //     data: 'promotion_status', 
                    //     name: 'promotion_status',
                    //     render: function (data) {
                    //         let badgeClass;
                    //         switch (data) {
                    //             case 'pending': badgeClass = 'warning'; break;
                    //             case 'approved': badgeClass = 'success'; break;
                    //             case 'rejected': badgeClass = 'danger'; break;
                    //             default: badgeClass = 'secondary';
                    //         }
                    //         return '<span class="badge bg-' + badgeClass + '-transparent">' + data.toUpperCase() + '</span>';
                    //     }
                    // }
                ],
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });

            // Event listener for View Cards button
            $('.data-table').on('click', '.view-cards', function() {
                var contentId = $(this).data('content-id');

                $('#contentCardsModal').data('content-id',
                contentId); // Update contentId in modal's data attribute
                loadContentCards(contentId);
            });

            function loadContentCards(contentId) {
                $.ajax({
                    url: '/admin/content-cards/' + contentId,
                    method: 'GET',
                    success: function(response) {
                        var tbody = $('#contentCardsTable tbody');
                        tbody.empty();
                        response.cards.forEach(function(card) {
                            appendCardRow(card);
                        });
                        $('#contentCardsModal').modal('show');
                    },
                    error: function(xhr) {
                        // alert('Error loading content cards. Please try again.');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error loading content cards. Please try again.',
                            customClass: {
                                title: 'custom-title',
                                content: 'custom-content'
                            }
                        });
                    }
                });
            }

            function appendCardRow(card = {}) {
                // Get the last row's date and time values
                const formatDatetime = (datetime) => {
                    if (!datetime) return '';
                    const [date, time] = datetime.split(' '); // Split into date and time parts
                    return {
                        date,
                        time
                    }; // Return as object with date and time
                };

                var lastRow = $('#contentCardsTable tbody tr:last');
                var lastStartDate = lastRow.find('.start-date').val();
                var lastStartTime = lastRow.find('.start-time').val();
                var lastEndDate = lastRow.find('.end-date').val();
                var lastEndTime = lastRow.find('.end-time').val();

                // Use the values from the last row, if present, or leave them empty
                const {
                    date,
                    time
                } = formatDatetime(card.startdate || `${lastStartDate} ${lastStartTime}`);

                var row = `
            <tr>
                <td>
                    <input type="text" class="form-control id" value="${card.id || ''}" ${card.id ? 'readonly' : ''}>
                </td>
                
                <td>
                    <input type="date" class="form-control start-date" value="${date || lastStartDate || ''}">
                </td>
                <td>
                    <input type="time" class="form-control start-time" value="${time || lastStartTime || ''}">
                </td>
                <td>
                    <input type="date" class="form-control end-date" value="${card.enddate ? card.enddate.split(' ')[0] : lastEndDate || ''}">
                </td>
                <td>
                    <input type="time" class="form-control end-time" value="${card.enddate ? card.enddate.split(' ')[1] : lastEndTime || ''}">
                </td>
                 <td>
                    <input type="text" class="form-control card-id" value="${card.card_id || ''}" >
                </td>
                <td>
                    <input type="text" class="form-control tracking-id" value="${card.tracking_id || ''}" >
                </td>
                <td>
                    <input type="text" class="form-control verification-code" value="${card.verification_code || ''}">
                </td>
                <td>
                    <button class="btn btn-danger btn-sm delete-card">Delete</button>
                </td>
            </tr>`;
                $('#contentCardsTable tbody').append(row);
            }

            $('#addNewCard').click(function() {
                appendCardRow(); // Add a new row copying the last row's date and time
            });

            $('#contentCardsTable').on('click', '.delete-card', function() {
                $(this).closest('tr').remove();
            });

            $('#saveContentCards').click(function() {
                var contentId = $('#contentCardsModal').data('content-id');
                console.log(contentId);
                var cards = [];
                $('#contentCardsTable tbody tr').each(function() {
                    var row = $(this);
                    cards.push({
                        id: row.find('.id').val() || null,
                        card_id: row.find('.card-id').val() || null,
                        start_date: row.find('.start-date').val(),
                        end_date: row.find('.end-date').val(),
                        start_time: row.find('.start-time').val(),
                        end_time: row.find('.end-time').val(),
                        tracking_id: row.find('.tracking-id').val(),
                        verification_code: row.find('.verification-code').val()
                    });
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('admin.save-content-cards') }}',
                    method: 'POST',
                    data: {
                        content_id: contentId,
                        cards: cards
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Card Added Successfully',
                            customClass: {
                                title: 'custom-title',
                                content: 'custom-content'
                            }
                        });
                        $('#contentCardsModal').modal('hide');
                        table.ajax.reload();

                    },
                    error: function(xhr) {
                        console.log(xhr);
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr
                            .responseJSON.message : 'Error saving cards. Please try again.';
                            Swal.fire({
                            icon: 'error',
                            title: errorMessage,
                            customClass: {
                                title: 'custom-title',
                                content: 'custom-content'
                            }
                        }); // Display the error message
                    }
                });
            });
        });
    </script>
@endsection
