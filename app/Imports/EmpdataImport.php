<?php

namespace App\Imports;

use App\Models\Empdata;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class EmpdataImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // 1. Duplicate Check (Email or Mobile Number)
        $email = isset($row['email']) ? trim($row['email']) : '';
        $mobile = isset($row['mobile_number']) ? trim($row['mobile_number']) : '';

        $exists = Empdata::where('email', $email)
            ->orWhere('mobile_number', $mobile)
            ->exists();

        if ($exists) {
            return null; // Skip duplicate record
        }

        // 2. Date Formatting (DD-MM-YYYY / YYYY-MM-DD to YYYY-MM-DD for MySQL)
        $orderDate = Carbon::now()->format('Y-m-d');
        if (!empty($row['order_date'])) {
            try {
                // First try DD-MM-YYYY or DD/MM/YYYY
                $orderDate = Carbon::createFromFormat('d-m-Y', str_replace('/', '-', trim($row['order_date'])))->format('Y-m-d');
            } catch (\Exception $e) {
                try {
                    // Standard / ISO / Excel date parser
                    $orderDate = Carbon::parse($row['order_date'])->format('Y-m-d');
                } catch (\Exception $ex) {
                    $orderDate = Carbon::now()->format('Y-m-d');
                }
            }
        }

        // 3. Return Model Instance
        return new Empdata([
            'customer_name' => trim($row['customer_name'] ?? ''),
            'mobile_number' => $mobile,
            'email'         => $email,
            'city'          => trim($row['city'] ?? ''),
            'state'         => trim($row['state'] ?? ''),
            'pincode'       => trim($row['pincode'] ?? ''),
            'product_name'  => trim($row['product_name'] ?? ''),
            'quantity'      => (int) ($row['quantity'] ?? 1),
            'order_amount'  => (float) ($row['order_amount'] ?? 0),
            'order_date'    => $orderDate,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.customer_name' => 'required',
            '*.mobile_number' => 'required|digits:10',
            '*.email'         => 'required|email',
            '*.city'          => 'required',
            '*.state'         => 'required',
            '*.pincode'       => 'required',
            '*.product_name'  => 'required',
            '*.quantity'      => 'required|numeric',
            '*.order_amount'  => 'required|numeric',
            '*.order_date'    => 'required', 
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.customer_name.required' => 'Customer name is required',
            '*.mobile_number.required' => 'Mobile number is required',
            '*.mobile_number.digits'   => 'Mobile Number must be 10 digits',
            '*.email.required'         => 'Email is required',
            '*.email.email'            => 'Invalid Email Format',
            '*.quantity.numeric'       => 'Quantity must be numeric',
            '*.order_amount.numeric'   => 'Order Amount must be numeric',
            '*.order_date.required'    => 'Order date is required',
        ];
    }
}