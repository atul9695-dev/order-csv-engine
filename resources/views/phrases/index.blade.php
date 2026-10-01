<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --bg-main: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #1e293b;
            --border-color: #e2e8f0;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-dark);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .dash-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: #ffffff;
            border-radius: 12px;
            padding: 24px;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            height: 100%;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .quick-action-card {
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .content-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
        }

        .custom-table th {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 0.825rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border-color);
        }

        .custom-table td {
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <div class="container-fluid px-4 py-3">

        <div class="dash-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1 fw-bold"><i class="fas fa-boxes me-2"></i>Order Management</h3>
                    <p class="mb-0 opacity-75">Overview, customer records, and daily imports</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-light text-dark fs-6 font-monospace px-3 py-2">
                        {{ date('d M Y') }}
                    </span>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3 mb-0" role="alert">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3 mb-0" role="alert">
                    <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted fw-semibold">TOTAL RECORDS</small>
                            <h3 class="mb-0 mt-1 fw-bold">{{ $totalRecords ?? 0 }}</h3>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-database"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted fw-semibold">TODAY'S ORDERS</small>
                            <h3 class="mb-0 mt-1 fw-bold">{{ $todayOrders ?? 0 }}</h3>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted fw-semibold">THIS MONTH</small>
                            <h3 class="mb-0 mt-1 fw-bold">{{ $monthOrders ?? 0 }}</h3>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted fw-semibold">TOTAL REVENUE</small>
                            <h3 class="mb-0 mt-1 fw-bold">₹{{ number_format($totalRevenue ?? 0, 2) }}</h3>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <a href="{{ route('phrase.create') }}" class="quick-action-card">
                    <div class="stat-card border-start border-primary border-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-plus text-primary fs-4 me-3"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Phase 1</h6>
                                <small class="text-muted">Single Entry Form</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('phrase2.create') }}" class="quick-action-card">
                    <div class="stat-card border-start border-warning border-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users text-warning fs-4 me-3"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Phase 2</h6>
                                <small class="text-muted">Multiple Entry Form</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('csv.create') }}" class="quick-action-card">
                    <div class="stat-card border-start border-danger border-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-csv text-danger fs-4 me-3"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Phase 3</h6>
                                <small class="text-muted">CSV Upload</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="content-card">
            
            <form method="GET" action="{{ route('orders.index') }}" id="searchForm" class="mb-3">
                <div class="row g-2 align-items-center">
                    <div class="col-lg-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" id="searchInput" value="{{ request('search') }}" class="form-control border-start-0" placeholder="Search customer, mobile, product...">
                        </div>
                    </div>
                    <div class="col-sm-3 col-lg-2">
                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control" title="From Date">
                    </div>
                    <div class="col-sm-3 col-lg-2">
                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control" title="To Date">
                    </div>
                    <div class="col-sm-3 col-lg-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="col-sm-3 col-lg-2 text-end">
                        <a href="{{ route('orders.export') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-download me-1"></i> Export CSV
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover custom-table align-middle">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Location</th>
                            <th>Product</th>
                            <th class="text-center">Qty</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="fw-bold">#{{ $order->id }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->mobile_number }}</td>
                                <td><span class="text-muted">{{ $order->email }}</span></td>
                                <td>{{ $order->city }}, {{ $order->state }} <small class="text-muted">({{ $order->pincode }})</small></td>
                                <td>{{ $order->product_name }}</td>
                                <td class="text-center">{{ $order->quantity }}</td>
                                <td class="fw-semibold">₹{{ number_format($order->order_amount, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d-M-Y') }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-light btn-action text-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-light btn-action text-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="delete-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light btn-action text-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">No records found matching your query.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $orders->links() }}
                </div>
            @endif

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // SweetAlert Delete Confirmation
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This record will be permanently deleted.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, delete it',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });

            // Live Search Debounce
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                let timer;
                searchInput.addEventListener('keyup', () => {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        document.getElementById('searchForm').submit();
                    }, 600);
                });
            }
        });
    </script>
</body>
</html>