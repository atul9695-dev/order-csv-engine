# 📦 Enterprise Bulk Order & CSV Processing Engine

An enterprise-grade **Order Management & Bulk CSV Processing Engine** built with **Laravel 12, MySQL, and Maatwebsite Excel**. Designed for high-throughput batch processing, duplicate detection, dynamic live multi-row records creation, and asynchronous export capabilities.

---

## 🚀 Key Highlights & Architectural Modules

### 🔹 Phase 1: Single Record Entry & Instant Validation
- Instant client-side & server-side validation for phone digits, email structure, and postal codes.
- Sanitized database insertion with standardized date formatting.

### 🔹 Phase 2: Dynamic Multi-Row Batch Processing
- Interactive dynamic DOM table allowing users to dynamically add, remove, and configure unlimited order rows.
- **Atomic Database Transactions (`DB::transaction`)**: Guarantees zero data corruption during batch inserts (All-or-Nothing execution).

### 🔹 Phase 3: High-Performance CSV Bulk Import & Pipeline
- **Validation Pipeline**: Validates columns, required headers, phone numbers, and formats before ingestion.
- **Duplicate Prevention**: Intelligently skips existing records by matching Unique Email / Phone credentials.
- **Smart Date Parser**: Supports multiple date formats (`DD-MM-YYYY`, `YYYY-MM-DD`, Excel serialized timestamps).
- **Downloadable Sample Template**: Provides pre-formatted sample CSV for end users.

### 🔹 Phase 4: Analytics & Real-Time Search Dashboard
- **Live Debounced Search**: Filters dynamically by customer name, contact number, product title, and city.
- **Date-Range Filtering**: Multi-condition date filtering for custom date ranges.
- **Real-Time KPI Metrics**: Displays Total Records, Today's Order volume, Monthly counts, and Total Gross Revenue.
- **Structured CSV Export**: Instant streaming export with custom headers and formatted columns.

---

## 🛠️ Technology Stack

- **Backend Framework**: Laravel 12 (PHP 8.2+)
- **Database**: MySQL / MariaDB (InnoDB with ACID Transactions)
- **Spreadsheet Processing**: `maatwebsite/excel` (PhpSpreadsheet Engine)
- **Frontend / UI**: Bootstrap 5.3, FontAwesome 6, SweetAlert2, Blade Templating
- **Autoloading & Standards**: PSR-4, Strict Type-Hinting, RESTful Routing

---

## 📋 Database Schema (`empdatas`)

| Column | Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | Primary Key, Auto Increment | Unique Identifier |
| `customer_name` | VARCHAR(255) | NOT NULL | Customer Full Name |
| `mobile_number` | VARCHAR(10) | NOT NULL | 10-digit Phone Number |
| `email` | VARCHAR(255) | NOT NULL | Customer Email Address |
| `city` | VARCHAR(100) | NOT NULL | Customer City |
| `state` | VARCHAR(100) | NOT NULL | Customer State |
| `pincode` | VARCHAR(15) | NOT NULL | Postal Code |
| `product_name` | VARCHAR(255) | NOT NULL | Item / SKU Title |
| `quantity` | INT | NOT NULL | Units Purchased |
| `order_amount` | DECIMAL(10,2) | NOT NULL | Total Order Price (INR) |
| `order_date` | DATE | NOT NULL | Date of purchase |
| `created_at` / `updated_at` | TIMESTAMP | NULLABLE | Audit Timestamps |

---

## ⚙️ Installation & Local Setup

### 1. Clone & Dependencies
```bash
git clone <your-repository-url>
cd "CSV Upload task"
composer install
npm install
```

### 2. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```
Update your `.env` database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Run Migrations
```bash
php artisan migrate
```

### 4. Start Local Development Server
```bash
php artisan serve
```
Open `http://127.0.0.1:8000` in your browser.

---

## 🧪 Testing Features
1. **Root Redirect**: Visit `http://localhost:8000/` &rarr; Automatically redirects to the Dashboard.
2. **Phase 1**: Add single customer order at `/phrase/create`.
3. **Phase 2**: Add multiple rows dynamically and click *Save All Records* at `/phrase2/create`.
4. **Phase 3**: Download sample CSV at `/csv/sample/download`, upload via `/csv/create`.
5. **Search & Filter**: Test live search and date filters on `/orders`.
6. **Export**: Click *Export CSV* to download database records.

---

## 📄 License
This project is open-source and available under the [MIT License](LICENSE).
