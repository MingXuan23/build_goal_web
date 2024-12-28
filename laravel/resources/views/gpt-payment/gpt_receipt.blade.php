@extends('organization.layouts.main')

@section('title', 'Payment Confirmation')

@section('styles') <!-- Ensure the section is correctly named -->
    <style>
        :root {
            /* --primary-color: #2c3e50; */
            /* --secondary-color: #34495e;
                            --accent-color: #3498db; */
            --success-color: #27ae60;
            --danger-color: #dc3545;
            /* Danger color for errors */
            --warning-color: #ffc107;
            /* Warning color for cautions */
        }

        .payment-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .payment-header {
            background: linear-gradient(135deg, var(--success-color), var(--success-color));
            color: white;
            padding: 20px;
            border-radius: 15px 15px 0 0;
        }


        .payment-header-pending {
            background: linear-gradient(135deg, var(--warning-color), var(--warning-color));
            color: white;
            padding: 20px;
            border-radius: 15px 15px 0 0;
        }

        .payment-header-failed {
            background: linear-gradient(135deg, var(--danger-color), var(--danger-color));
            color: white;
            padding: 20px;
            border-radius: 15px 15px 0 0;
        }

        .payment-body {
            padding: 30px;
        }

        .order-summary {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .detail-section {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }

        .detail-section:last-child {
            border-bottom: none;
        }

        .price-tag {
            font-size: 24px;
            color: var(--primary-color);
            font-weight: bold;
        }

        .confirm-button {
            background: var(--success-color);
            border: none;
            padding: 12px 40px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .confirm-button:hover {
            background: #219a52;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }

        .secure-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #666;
            margin-top: 20px;
        }
    </style>
@endsection

@section('container')
    <div class="main-content app-content">
        <div class="container mt-5">
            <div class="payment-container">
                <div class="">
                    @if ($transaction->status == 'Success')
                        <div class="">
                        @elseif($transaction->status == 'Pending')
                            <div class="">
                            @elseif($transaction->status == 'Failed')
                                <div class="">
                                @else
                                    <div class="">
                    @endif
                    <div class="d-flex justify-content-between align-items-center">
                        @if ($transaction->status == 'Success')
                            {{-- <h3 class="m-0 text-white">Payment Success</h3> --}}
                        @elseif($transaction->status == 'Pending')
                            {{-- <h3 class="m-0 text-white">Payment Processing</h3> --}}
                        @elseif($transaction->status == 'Failed')
                            {{-- <h3 class="m-0 text-white">Payment Failed</h3> --}}
                            {{-- @else
                            <h3 class="m-0 text-white">Payment Failed</h3> --}}
                        @endif
                    </div>
                </div>


                <div class="payment-body">
                    <div class="order-summary p-5">
                        @php
                           if ($transaction->status == 'Success') {
                                $bg = 'success';
                                $a = 'PAYMENT SUCCESSFULL';
                            } elseif ($transaction->status == 'Pending') {
                                $bg = 'warning';
                                $a = 'PAYMENT PENDING';
                            } elseif ($transaction->status == 'Failed') {
                                $bg = 'danger';
                                $a = 'PAYMENT FAILED';
                            }

                        @endphp
                        <button class="btn btn-{{ $bg }}-transparent fw-bold d-flex align-items-center ">{{$a}}<span
                                class="ms-2 badge badge-sm bg-{{ $bg }} text-sm">{{ $transaction->status }}</span></button>
                        <div class="d-flex justify-content-end">
                            {{-- <button
                            class="mb-4 btn btn-{{ $bg }}-transparent fw-bold d-flex align-items-center ">PAYMENT
                            SUCCESSFULL<span
                                class="ms-2 badge badge-sm bg-{{ $bg }} text-sm">{{ $transaction->status }}</span></button> --}}
                            <div class="text-center">
                                <img src="https://directpay.my/assets/images/logo.jpg" class="img-fluid rounded"
                                    width="22" height="22">
                            </div>
                            <span class="fw-bold ms-1 ">Provided by <span class="fw-bold text-primary">Direct
                                    Pay</span>
                        </div>
                        <h6 class="mt-3 fw-bold d-flex align-items-center ">TRANSACTION SUMMARY</h6>
                        {{-- <h5 class="text-muted mb-4">Order Summary</h5> --}}

                        <div class="detail-section mt-4 p-3">
                            <!-- Content Name -->
                            {{-- <h6 class="mb-3 fw-bold text-muted">Order Summary</h6> --}}
                            <div class="d-flex justify-content-between">
                                <h6>Payment For : </h6>
                                <h6 class="me-3 fw-bold"><img src="../../assets/images/gpt.png" alt="" width="35" height="35"/>xBug GPT AI</h6>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <h6>Transaction ID : </h6><h6 class="fw-bold">{{$transaction->transac_no}}</h6>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <h6>Trsanction Created : </h6><h6 class="fw-bold">{{$transaction->created_at}}</h6>
                            </div>

                        </div>

                        <div class="detail-section">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class=" m-0 fw-bold">TOTAL AMOUNT</h6>
                                <div class="price-tag me-5">RM {{ number_format($transaction->amount) }}
                                </div>
                            </div>
                        </div>
                        <div class="secure-badge">

                        </div>
                        <div class=" d-flex align-items-center justify-content-center">
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
                <!-- Hidden field for cp_token -->
            </div>
        </div>
    </div>
    </div>

@endsection