@extends('organization.layouts.main')

@section('title', 'Payment Confirmation')

@section('styles') <!-- Ensure the section is correctly named -->
    <style>
        /* :root {
        --primary-color: #2c3e50;
        --secondary-color: #34495e;
        --accent-color: #3498db;
        --success-color: #27ae60;
    } */

        .payment-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .payment-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
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
        <div class="container">
            <div class="payment-body mt-4">
                <div class="order-summary p-5">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5 class="mb-4 fw-bold">Promotion Summary</h5>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="secure-badge">
                                <div class="text-center">
                                    <img src="https://directpay.my/assets/images/logo.jpg" class="img-fluid rounded" width="26"
                                        height="26">
                                </div>
                                <span class="fw-bold">Provided by <span class="fw-bold text-primary">Direct Pay</span</span>
                            </div>
                        </div>
                    </div>
                   
                    <div class="detail-section">

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Content Name:</strong><br>{{ $content->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Package:</strong><br>{{ $package->name }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Estimated Reach:</strong><br>{{ $package->estimate_user }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Selected States:</strong><br>
                                    @foreach (json_decode($cp_id->target_audience) as $state)
                                        {{ $state }},
                                    @endforeach
                                </p>
                            </div>
                        </div>




                    </div>


                    <div class="detail-section">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class=" m-0 fw-bold">TOTAL AMOUNT</h6>

                            <div class="price-tag">RM {{ number_format($cp_id->promotion_price, 2) }}</div>
                        </div>
                    </div>
                    <form action="{{ route('directpayIndex') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cp_token" value="{{ $cp_id->id . '-' . preg_replace('/[^0-9]/', '', $cp_id->updated_at) }}">


                        <div class="text-center mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn confirm-button btn-primary btn-sm px-3 py-2">
                                <span class="me-2">Proceed to Payment</span>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                    <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                                </svg>
                            </button>
                        </div>
                
                    </form>

                    <div class="secure-badge d-flex">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="#5cb85c" class="">
                            <path
                                d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 6c1.4 0 2.8 1.1 2.8 2.5V11c.6 0 1.2.6 1.2 1.2v3.5c0 .7-.6 1.3-1.2 1.3H9.2c-.6 0-1.2-.6-1.2-1.2v-3.5c0-.7.6-1.3 1.2-1.3V9.5C9.2 8.1 10.6 7 12 7zm0 1c-.8 0-1.5.7-1.5 1.5V11h3V9.5c0-.8-.7-1.5-1.5-1.5z" />
                        </svg>
                        <span class="fw-bold">SSL SECURE PAYMENT</span>
                    </div>
                    <div class="secure-badge">
                        {{-- <svg width="25" height="25" viewBox="0 0 24 24" fill="#5cb85c" class="">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 6c1.4 0 2.8 1.1 2.8 2.5V11c.6 0 1.2.6 1.2 1.2v3.5c0 .7-.6 1.3-1.2 1.3H9.2c-.6 0-1.2-.6-1.2-1.2v-3.5c0-.7.6-1.3 1.2-1.3V9.5C9.2 8.1 10.6 7 12 7zm0 1c-.8 0-1.5.7-1.5 1.5V11h3V9.5c0-.8-.7-1.5-1.5-1.5z"/>
                    </svg> --}}
                        <p>Your encryption is protected by 256-bit SSL encryption</p>
                    </div>
                </div>

                <!-- Hidden field for cp_token -->

                <!-- Form to POST the data -->
            </div>
        </div>
    </div>

    <br><br>
@endsection
