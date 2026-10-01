<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phase 3 - CSV Import System</title>

    <!-- Bootstrap 5 & FontAwesome -->
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

        /* Main Card */
        .main-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        /* Upload Area */
        .upload-box {
            border: 2px dashed #3b82f6;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            background: #f0f9ff;
            transition: all 0.2s ease;
        }

        .upload-box:hover {
            background: #e0f2fe;
            border-color: #2563eb;
        }

        .upload-icon {
            font-size: 3rem;
            color: #2563eb;
            margin-bottom: 12px;
        }

        /* Buttons */
        .btn-upload {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: #ffffff;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            padding: 10px 24px;
        }

        .btn-upload:hover {
            opacity: 0.92;
            color: #ffffff;
        }

        .btn-sample {
            background-color: #10b981;
            color: #ffffff;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            padding: 10px 20px;
        }

        .btn-sample:hover {
            background-color: #059669;
            color: #ffffff;
        }

        /* Instruction Cards */
        .instruction-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
        }

        .file-name {
            margin-top: 12px;
            color: #2563eb;
            font-weight: 600;
        }

        .badge-column {
            background-color: #f1f5f9;
            color: #475569;
            font-family: monospace;
            font-size: 0.85rem;
            border: 1px solid #cbd5e1;
            padding: 4px 8px;
            border-radius: 6px;
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="container-fluid px-4 py-4">

    <!-- Header Section -->
    <div class="page-header mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="fas fa-file-csv me-2"></i>Phase 3: Bulk CSV Import System
            </h3>
            <p class="mb-0 opacity-75 small">Bulk Data Upload & Processing via CSV File</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-light text-dark fw-semibold">
                <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
            </a>
            <span class="badge bg-white bg-opacity-25 text-white px-3 py-2 rounded-pill fs-6 fw-normal">
                <i class="fas fa-cloud-arrow-up me-1"></i> Bulk Entry Module
            </span>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success rounded-3 mb-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-3 mb-3">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-3">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Card -->
    <div class="main-card">
        <div class="row g-4">

            <!-- Upload Section -->
            <div class="col-lg-7">
                <form action="{{ route('csv.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="upload-box">
                        <i class="fas fa-cloud-arrow-up upload-icon"></i>
                        <h5 class="fw-bold mb-1">Upload CSV File</h5>
                        <p class="text-muted small mb-3">Select a valid CSV file containing customer order details.</p>

                        <input type="file" name="file" id="csvFile" class="form-control w-75 mx-auto" accept=".csv" required>

                        <div class="file-name" id="fileName"></div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-upload">
                            <i class="fas fa-file-import me-1"></i> Import CSV
                        </button>

                        <a href="{{ route('csv.sample') }}" class="btn btn-sample">
                            <i class="fas fa-download me-1"></i> Download Sample CSV
                        </a>
                    </div>
                </form>
            </div>

            <!-- Instructions Section -->
            <div class="col-lg-5">
                <div class="instruction-card mb-3">
                    <h6 class="fw-bold mb-3 text-primary">
                        <i class="fas fa-circle-info me-1"></i> CSV File Instructions
                    </h6>
                    <ul class="text-muted small ps-3 mb-0 d-flex flex-column gap-1">
                        <li>File format must strictly be <strong>.CSV</strong>.</li>
                        <li>Maximum allowable file size: <strong>5 MB</strong>.</li>
                        <li>Do not alter or remove column header names.</li>
                        <li>All mandatory field rows must be populated.</li>
                        <li>Mobile numbers must consist of 10 digits.</li>
                        <li>Provide a valid email address format.</li>
                        <li>Date format required: <strong>YYYY-MM-DD</strong>.</li>
                    </ul>
                </div>

                <div>
                    <h6 class="fw-bold small text-muted mb-2">Expected CSV Columns:</h6>
                    <div class="d-flex flex-wrap gap-1">
                        <span class="badge-column">customer_name</span>
                        <span class="badge-column">mobile_number</span>
                        <span class="badge-column">email</span>
                        <span class="badge-column">city</span>
                        <span class="badge-column">state</span>
                        <span class="badge-column">pincode</span>
                        <span class="badge-column">product_name</span>
                        <span class="badge-column">quantity</span>
                        <span class="badge-column">order_amount</span>
                        <span class="badge-column">order_date</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    document.getElementById('csvFile').addEventListener('change', function() {
        const fileName = this.files[0]?.name || '';
        const displayContainer = document.getElementById('fileName');

        if (fileName) {
            displayContainer.innerHTML = `<i class="fas fa-file-csv me-1"></i> ${fileName}`;
        } else {
            displayContainer.innerHTML = '';
        }
    });
</script>

</body>
</html>