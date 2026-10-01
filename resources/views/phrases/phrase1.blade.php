<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Import Management System</title>
    
    <!-- External UI Assets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8fafc;
            font-family: system-ui, -apple-system, sans-serif;
            color: #334155;
        }

        /* Container Card Setup */
        .form-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        /* Header Style */
        .form-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            padding: 24px 32px;
            color: #ffffff;
        }

        /* Form Inputs & Icons */
        .input-box {
            position: relative;
        }

        .input-box i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .form-control-custom {
            height: 48px;
            padding-left: 46px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
        }

        .form-control-custom:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15);
        }

        /* Error Text */
        .error-message {
            color: #dc2626;
            font-size: 0.825rem;
            margin-top: 4px;
        }

        /* Primary Button */
        .btn-submit {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #ffffff;
            height: 50px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            transition: opacity 0.2s;
        }

        .btn-submit:hover {
            opacity: 0.92;
            color: #ffffff;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="form-card">
                <!-- Header Section -->
                <div class="form-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h4 class="mb-1 fw-bold">Phase 1: Single Order Entry</h4>
                        <p class="mb-0 opacity-75 small">Enter order and customer details below</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-light text-dark fw-semibold">
                            <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
                        </a>
                        <span class="badge bg-white bg-opacity-25 text-white px-3 py-2 rounded-pill">
                            <i class="fa-solid fa-circle-check me-1"></i> Active
                        </span>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="card-body p-4 p-md-5">

                    <!-- Alerts -->
                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center gap-2 mb-4" role="alert">
                            <i class="fa-solid fa-circle-check"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" role="alert">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif

                    <form action="{{ route('phrase.store') }}" method="POST" id="orderForm">
                        @csrf

                        <!-- Section 1: Customer Information -->
                        <h6 class="fw-bold text-primary mb-3 pb-2 border-bottom">
                            <i class="fa-solid fa-user me-2"></i>Customer Details
                        </h6>

                        <div class="row g-3 mb-4">
                            <!-- Customer Name -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Customer Name</label>
                                <div class="input-box">
                                    <i class="fa-regular fa-user"></i>
                                    <input type="text" name="customer_name" class="form-control form-control-custom" placeholder="e.g. John Doe" value="{{ old('customer_name') }}">
                                </div>
                                @error('customer_name')
                                    <div class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mobile Number -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Mobile Number</label>
                                <div class="input-box">
                                    <i class="fa-solid fa-phone"></i>
                                    <input type="text" name="mobile_number" class="form-control form-control-custom" placeholder="10-digit mobile number" value="{{ old('mobile_number') }}">
                                </div>
                                @error('mobile_number')
                                    <div class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Email Address</label>
                                <div class="input-box">
                                    <i class="fa-regular fa-envelope"></i>
                                    <input type="email" name="email" class="form-control form-control-custom" placeholder="name@company.com" value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <div class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">City</label>
                                <div class="input-box">
                                    <i class="fa-solid fa-city"></i>
                                    <input type="text" name="city" class="form-control form-control-custom" placeholder="e.g. New York" value="{{ old('city') }}">
                                </div>
                                @error('city')
                                    <div class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">State</label>
                                <div class="input-box">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                    <input type="text" name="state" class="form-control form-control-custom" placeholder="e.g. California" value="{{ old('state') }}">
                                </div>
                                @error('state')
                                    <div class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pincode -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Pincode</label>
                                <div class="input-box">
                                    <i class="fa-solid fa-map-pin"></i>
                                    <input type="text" name="pincode" class="form-control form-control-custom" placeholder="Postal code" value="{{ old('pincode') }}">
                                </div>
                                @error('pincode')
                                    <div class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Section 2: Order Information -->
                        <h6 class="fw-bold text-primary mb-3 pb-2 border-bottom">
                            <i class="fa-solid fa-box-open me-2"></i>Order Details
                        </h6>

                        <div class="row g-3 mb-4">
                            <!-- Product Name -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Product Name</label>
                                <div class="input-box">
                                    <i class="fa-solid fa-tag"></i>
                                    <input type="text" name="product_name" class="form-control form-control-custom" placeholder="Item description" value="{{ old('product_name') }}">
                                </div>
                                @error('product_name')
                                    <div class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-3 col-6">
                                <label class="form-label small fw-semibold">Quantity</label>
                                <div class="input-box">
                                    <i class="fa-solid fa-layer-group"></i>
                                    <input type="number" name="quantity" class="form-control form-control-custom" placeholder="0" value="{{ old('quantity') }}">
                                </div>
                                @error('quantity')
                                    <div class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Order Amount -->
                            <div class="col-md-3 col-6">
                                <label class="form-label small fw-semibold">Amount (₹)</label>
                                <div class="input-box">
                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                    <input type="number" step="0.01" name="order_amount" class="form-control form-control-custom" placeholder="0.00" value="{{ old('order_amount') }}">
                                </div>
                                @error('order_amount')
                                    <div class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Order Date -->
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Order Date</label>
                                <div class="input-box">
                                    <i class="fa-regular fa-calendar-days"></i>
                                    <input type="date" name="order_date" class="form-control form-control-custom" value="{{ old('order_date') }}">
                                </div>
                                @error('order_date')
                                    <div class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-submit w-100" id="btnSubmit">
                            <span id="btnText"><i class="fa-solid fa-paper-plane me-2"></i> Submit Order</span>
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Form submission UI handling
    document.getElementById('orderForm').addEventListener('submit', function() {
        var btnText = document.getElementById('btnText');
        var btnSubmit = document.getElementById('btnSubmit');
        
        btnText.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i> Processing...';
        btnSubmit.style.pointerEvents = "none";
        btnSubmit.style.opacity = "0.75";
    });
</script>

</body>
</html>