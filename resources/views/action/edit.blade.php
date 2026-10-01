<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order #{{ $order->id }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            background-color: #f8fafc;
            font-family: system-ui, -apple-system, sans-serif;
            color: #334155;
        }
        .form-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        .form-header {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            padding: 24px 32px;
            color: #ffffff;
        }
        .form-control-custom {
            height: 46px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
        }
        .form-control-custom:focus {
            border-color: #d97706;
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.15);
        }
        .error-message {
            color: #dc2626;
            font-size: 0.825rem;
            margin-top: 4px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="form-card">
                <div class="form-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h4 class="mb-1 fw-bold"><i class="fas fa-edit me-2"></i>Edit Order #{{ $order->id }}</h4>
                        <p class="mb-0 opacity-90 small">Update customer and order details below</p>
                    </div>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-light text-dark fw-semibold">
                        <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                    </a>
                </div>

                <div class="card-body p-4 p-md-5">

                    @if($errors->any())
                        <div class="alert alert-danger rounded-3 mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h6 class="fw-bold text-warning mb-3 pb-2 border-bottom">
                            <i class="fas fa-user me-2"></i>Customer Information
                        </h6>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Customer Name</label>
                                <input type="text" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" class="form-control form-control-custom" required>
                                @error('customer_name')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Mobile Number</label>
                                <input type="text" name="mobile_number" value="{{ old('mobile_number', $order->mobile_number) }}" class="form-control form-control-custom" required>
                                @error('mobile_number')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $order->email) }}" class="form-control form-control-custom" required>
                                @error('email')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">City</label>
                                <input type="text" name="city" value="{{ old('city', $order->city) }}" class="form-control form-control-custom" required>
                                @error('city')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">State</label>
                                <input type="text" name="state" value="{{ old('state', $order->state) }}" class="form-control form-control-custom" required>
                                @error('state')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Pincode</label>
                                <input type="text" name="pincode" value="{{ old('pincode', $order->pincode) }}" class="form-control form-control-custom" required>
                                @error('pincode')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h6 class="fw-bold text-warning mb-3 pb-2 border-bottom">
                            <i class="fas fa-box me-2"></i>Order Details
                        </h6>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Product Name</label>
                                <input type="text" name="product_name" value="{{ old('product_name', $order->product_name) }}" class="form-control form-control-custom" required>
                                @error('product_name')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 col-6">
                                <label class="form-label small fw-semibold">Quantity</label>
                                <input type="number" name="quantity" value="{{ old('quantity', $order->quantity) }}" class="form-control form-control-custom" min="1" required>
                                @error('quantity')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 col-6">
                                <label class="form-label small fw-semibold">Order Amount (₹)</label>
                                <input type="number" step="0.01" name="order_amount" value="{{ old('order_amount', $order->order_amount) }}" class="form-control form-control-custom" min="0" required>
                                @error('order_amount')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Order Date</label>
                                <input type="date" name="order_date" value="{{ old('order_date', \Carbon\Carbon::parse($order->order_date)->format('Y-m-d')) }}" class="form-control form-control-custom" required>
                                @error('order_date')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning px-4 py-2 fw-semibold text-dark">
                                <i class="fas fa-check me-1"></i> Update Order
                            </button>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary px-4 py-2 fw-semibold">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>