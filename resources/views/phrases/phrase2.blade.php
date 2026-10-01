<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phase 2 - Multiple Record Upload</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            background-color: #f8fafc;
            font-family: system-ui, -apple-system, sans-serif;
            color: #334155;
        }

        /* Header UI */
        .page-header {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: #ffffff;
            padding: 24px 30px;
            border-radius: 16px;
        }

        /* Stats Cards */
        .stat-card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .stat-card i {
            font-size: 1.5rem;
            color: #2563eb;
            margin-bottom: 8px;
        }

        /* Main Form & Table Setup */
        .main-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .table standard-inputs input {
            min-width: 130px;
            border-radius: 8px;
        }

        .table thead {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: #ffffff;
        }

        .table th {
            font-weight: 600;
            font-size: 0.875rem;
            white-space: nowrap;
            text-align: center;
        }

        /* Button Customizations */
        .btn-add-row {
            background-color: #10b981;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            padding: 10px 20px;
        }

        .btn-add-row:hover {
            background-color: #059669;
            color: white;
        }

        .btn-save-all {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            padding: 10px 24px;
        }

        .btn-save-all:hover {
            opacity: 0.92;
            color: white;
        }
    </style>
</head>
<body>

<div class="container-fluid px-4 py-4">

    <div class="page-header mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="fas fa-layer-group me-2"></i>Phase 2: Multiple Record Entry
            </h3>
            <p class="mb-0 opacity-75 small">Create and save multiple customer orders in a single submission.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-light text-dark fw-semibold">
                <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
            </a>
            <span class="badge bg-white bg-opacity-25 text-white px-3 py-2 rounded-pill fs-6 fw-normal">
                <i class="fas fa-database me-1"></i> <span id="rowCounter">1 Record</span>
            </span>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <i class="fas fa-list"></i>
                <h4 class="fw-bold mb-0" id="totalRows">1</h4>
                <small class="text-muted">Total Rows</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <i class="fas fa-check-circle"></i>
                <h4 class="fw-bold mb-0">Ready</h4>
                <small class="text-muted">System Status</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h4 class="fw-bold mb-0">Phase 2</h4>
                <small class="text-muted">Multiple Entry Module</small>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3 mb-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-3 mb-3">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="main-card">
        <form action="{{ route('phrase2.store') }}" method="POST">
            @csrf

            <div class="table-responsive">
                <table class="table table-hover align-middle border">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Pincode</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Amount (₹)</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="standard-inputs">
                        <tr>
                            <td><input type="text" name="customer_name[]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="mobile_number[]" class="form-control form-control-sm"></td>
                            <td><input type="email" name="email[]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="city[]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="state[]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="pincode[]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="product_name[]" class="form-control form-control-sm"></td>
                            <td><input type="number" name="quantity[]" class="form-control form-control-sm"></td>
                            <td><input type="number" step="0.01" name="order_amount[]" class="form-control form-control-sm"></td>
                            <td><input type="date" name="order_date[]" class="form-control form-control-sm"></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm removeRow">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <button type="button" id="addRow" class="btn btn-add-row">
                    <i class="fas fa-plus me-1"></i> Add New Row
                </button>

                <button type="submit" class="btn btn-save-all">
                    <i class="fas fa-floppy-disk me-1"></i> Save All Records
                </button>
            </div>
        </form>

        <div class="mt-3 text-muted small">
            <i class="fas fa-info-circle me-1"></i> Multiple records can be added dynamically and submitted together in one request.
        </div>
    </div>

</div>

<script>
    // Total row counter updater
    function updateCounter() {
        const count = document.querySelectorAll('#tableBody tr').length;
        document.getElementById('rowCounter').innerText = `${count} ${count === 1 ? 'Record' : 'Records'}`;
        document.getElementById('totalRows').innerText = count;
    }

    // Dynamic row addition
    document.getElementById('addRow').addEventListener('click', function () {
        const tableBody = document.getElementById('tableBody');
        const firstRow = tableBody.querySelector('tr');
        const newRow = firstRow.cloneNode(true);

        // Clear newly appended inputs
        newRow.querySelectorAll('input').forEach(input => input.value = '');

        tableBody.appendChild(newRow);
        updateCounter();
    });

    // Event delegation for removing individual rows
    document.addEventListener('click', function (e) {
        if (e.target.closest('.removeRow')) {
            const rows = document.querySelectorAll('#tableBody tr');

            if (rows.length > 1) {
                e.target.closest('tr').remove();
                updateCounter();
            } else {
                alert('At least one row is required.');
            }
        }
    });

    // Initial counter evaluation
    updateCounter();
</script>

</body>
</html>