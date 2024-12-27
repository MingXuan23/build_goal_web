@extends('organization.layouts.main')

@section('title', 'Payment Confirmation')

@section('container')
    <div class="main-content app-content">
        <div class="container mt-5">
            <div class="card p-3">
                {{-- <div class="modal-header">
                <h6 class="modal-title" id="modalViewLabel">Receipt Transaction for- 22120212121132323</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
                <div class="modal-body">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-5">
                                @php
                                    if ($transaction->status == 'Success') {
                                        $bg = 'success';
                                    } elseif ($transaction->status == 'Pending') {
                                        $bg = 'warning';
                                    } elseif ($transaction->status == 'Failed') {
                                        $bg = 'danger';
                                    }

                                @endphp
                                {{-- <h6>Thank you for the transaction!</h6> --}}
                                <button class="mt-3 btn btn-{{ $bg }}-transparent fw-bold d-flex align-items-center ">PROMOTION
                                    SUMMARY <span class="ms-2 badge badge-sm bg-{{ $bg }} text-sm">{{$transaction->status}}</span></button>
                            </div>
                            <div class="col-md-7 d-flex justify-content-end">
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
                                        <p>Payment From: <span class="fw-bold">KHAIRUL ADZHAR BIN NORAIDI</span></p>
                                        <p>Phone Number: <span class="fw-bold"> +60134424434</span></p>
                                        <p>Email: <span class="fw-bold"> adharkhai@gmail.com</span></p>
                                    </div>
                                    <div class="col-md-5">
                                        <p>Payment To: <span class="fw-bold"></span> <span class="fw-bold">xBug
                                                inc</span></p>
                                        <p>Package: <span class="fw-bold">WEWEWEWE</span></p>
                                        <p>Estimated Reach: <span class="fw-bold">223232</span></p>
                                        <p>Selected States: <span class="fw-bold">asas,sasasa,saasa</span></p>
                                        <p>Trsanction Time: <span class="fw-bold">2024-12-27 03:47:25
                                            </span></p>
                                    </div>
                                    <div style="border-bottom: 2px solid #eee; padding: 15px 0;"></div>
                                    <div class="col-md-6 mt-4">
                                        <h6 class="m-0 fw-bold">AMOUNT PAID</h6>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <h6 class="fw-bold">RM 23232</h6>
                                    </div>
                                    {{-- <div style="border-bottom: 2px solid #eee; padding: 15px 0;"></div> --}}
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
                    {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button> --}}
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Print</button>
                </div>
            </div>
        </div>
    </div>

    <br><br>
@endsection
