<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order #{{ $order->id }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            background-color: #f8fafc;
            font-family: system-ui, -apple-system, sans-serif;
            color: #334155;
        }
        .detail-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        .detail-header {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            padding: 24px 32px;
            color: #ffffff;
        }
        .detail-table th {
            width: 30%;
            background-color: #f8fafc;
            color: #475569;
            font-size: 0.9rem;
        }
        .detail-table td {
            font-size: 0.95rem;
            color: #1e293b;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="detail-card">
                <div class="detail-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h4 class="mb-1 fw-bold"><i class="fas fa-file-invoice me-2"></i>Order #{{ $order->id }} Details</h4>
                        <p class="mb-0 opacity-75 small">Customer and transaction summary</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-warning fw-semibold">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-light text-dark fw-semibold">
                            <i class="fas fa-arrow-left me-1"></i> Dashboard
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">

                    <div class="table-responsive">
                        <table class="table table-bordered detail-table mb-4 align-middle">
                            <tbody>
                                <tr>
                                    <th>Order ID</th>
                                    <td class="fw-bold">#{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <th>Customer Name</th>
                                    <td>{{ $order->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile Number</th>
                                    <td>{{ $order->mobile_number }}</td>
                                </tr>
                                <tr>
                                    <th>Email Address</th>
                                    <td>{{ $order->email }}</td>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <td>{{ $order->city }}, {{ $order->state }} ({{ $order->pincode }})</td>
                                </tr>
                                <tr>
                                    <th>Product Purchased</th>
                                    <td><span class="badge bg-primary fs-6 fw-normal">{{ $order->product_name }}</span></td>
                                </tr>
                                <tr>
                                    <th>Quantity</th>
                                    <td>{{ $order->quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Order Amount</th>
                                    <td class="fs-5 fw-bold text-success">₹{{ number_format($order->order_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td class="text-muted">{{ $order->created_at ? $order->created_at->format('d M Y, h:i A') : 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary px-4">
                            <i class="fas fa-arrow-left me-1"></i> Back to All Orders
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>