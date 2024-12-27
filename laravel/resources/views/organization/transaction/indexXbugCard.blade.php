@extends('organization.layouts.main')
@section('container')
    <div class="main-content app-content">
        <div class="container">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Transaction History</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Transaction</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Transaction History For xBug Card</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    {{-- <th>Seller Order No</th> --}}
                                    {{-- <th>Seller Ex Order No</th> --}}
                                    {{-- <th>transac_no</th> --}}
                                    <th>amount</th>
                                    <th>status</th>
                                    <th>Action</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($datas as $data)
        <div class="modal modal-lg fade" id="modalReceipt-{{ $data->id }}" tabindex="-1"
            aria-labelledby="modalViewLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="card">
                    <div class="modal-body">
                        <div class="p-4">
                            <div class="row">
                                <div class="col-md-5">
                                    <h6 class="mt-3 fw-bold d-flex align-items-center ">xBug CARD RECEIPT <span
                                            class="ms-2 badge badge-sm bg-success text-sm">success</span></h6>
                                </div>
                                <div class="col-md-4 d-flex justify-content-end">
                                    <div class="text-center mt-3">
                                        <img src="https://directpay.my/assets/images/logo.jpg" class="img-fluid rounded"
                                            width="22" height="22">
                                    </div>
                                    <span class="fw-bold ms-1 mt-3">Provided by <span class="fw-bold text-primary">Direct
                                            Pay</span>
                                </div>
                            </div>
                            <div style="border-bottom: 2px solid #eee; padding: 15px 0; margin-bottom: 15px"></div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>Payment From&nbsp;&nbsp;&nbsp;&nbsp;: <span class="fw-bold">{{$data->user_name}}</span></p>
                                            <p>Phone Number&nbsp;&nbsp;&nbsp;: <span class="fw-bold">{{$data->user_phone}}</span></p>
                                            <p>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span class="fw-bold"> {{$data->user_email}}</span></p>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="payment-info">
                                                <p>Payment To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span class="fw-bold"></span> <span class="fw-bold">xBug inc</span></p>
                                            <p>Content Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span class="fw-bold">{{$data->content_name}}</span></p>
                                            <p>Content Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span class="fw-bold">{{$data->content_type}}</span></p>
                                            <p>Number Of Card&nbsp;&nbsp;&nbsp;: <span class="fw-bold">{{$data->number_of_card}} Unit</span></p>
                                            <p>Valid Start Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span class="fw-bold">{{$data->startdate}}</span></p>
                                            <p>Valid End Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span class="fw-bold">{{$data->enddate}}</span></p>
                                            <p>Transaction ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span class="fw-bold">{{$data->transac_no}}</span></p>
                                            <p>Trsanction Time&nbsp;&nbsp;&nbsp;&nbsp;: <span class="fw-bold">{{$data->created_at}}
                                                </span></p>
                                            </div>
                                            
                                        </div>
                                        <div style="border-bottom: 2px solid #eee; padding: 15px 0;"></div>
                                        <div class="col-md-6 mt-4">
                                            <h6 class="m-0 fw-bold">TOTAL AMOUNT</h6>
                                        </div>
                                        <div class="col-md-6 mt-4 text-end">
                                            <h6 class="fw-bold me-5">RM {{$data->amount}}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 d-flex align-items-center justify-content-center">
                                <div class="">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="#5cb85c" class="">
                                        <path
                                            d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 6c1.4 0 2.8 1.1 2.8 2.5V11c.6 0 1.2.6 1.2 1.2v3.5c0 .7-.6 1.3-1.2 1.3H9.2c-.6 0-1.2-.6-1.2-1.2v-3.5c0-.7.6-1.3 1.2-1.3V9.5C9.2 8.1 10.6 7 12 7zm0 1c-.8 0-1.5.7-1.5 1.5V11h3V9.5c0-.8-.7-1.5-1.5-1.5z" />
                                    </svg>
                                    <span class="fw-bold">SSL SECURE PAYMENT</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="">
                                    <span>Transaction is protected by 256-bit SSL encryption</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        {{-- <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Print</button> --}}
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('showTransactionHistoryXbugCardOrg') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'user_email',
                        name: 'user_email'
                    },
                    // {
                    //     data: 'sellerOrderNo',
                    //     name: 'sellerOrderNo',
                    //     // render: function(data, type, row) {
                    //     //     return data ? data.toUpperCase() :
                    //     //     ''; 
                    //     // }
                    // },
                    // {
                    //     data: 'sellerExOrderNo',
                    //     name: 'sellerExOrderNo'
                    // },
                    // {
                    //     data: 'transac_no',
                    //     name: 'transac_no'
                    // },
                    {
                        data: 'amount',
                        name: 'amount'
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
                        data: 'created_at',
                        name: 'created_at'
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: 'Copy Data'
                    },
                    {
                        extend: 'csv',
                        text: 'Export CSV'
                    },
                    {
                        extend: 'excel',
                        text: 'Export Excel'
                    },
                    {
                        extend: 'pdf',
                        text: 'Export PDF'
                    },
                    {
                        extend: 'print',
                        text: 'Print Data'
                    }
                ],
                language: {
                    emptyTable: "No logs available"
                }
            });
        });
    </script>

    <style>
        .table td {
            word-wrap: break-word;
            white-space: normal;
        }
    </style>
@endsection
