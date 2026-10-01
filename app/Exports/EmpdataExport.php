<?php

namespace App\Exports;

use App\Models\Empdata;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class EmpdataExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Empdata::all();
    }

    /**
     * Define CSV Header Row
     */
    public function headings(): array
    {
        return [
            'ID',
            'Customer Name',
            'Mobile Number',
            'Email',
            'City',
            'State',
            'Pincode',
            'Product Name',
            'Quantity',
            'Order Amount',
            'Order Date',
        ];
    }

    /**
     * Map each record to the defined columns
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->customer_name,
            $row->mobile_number,
            $row->email,
            $row->city,
            $row->state,
            $row->pincode,
            $row->product_name,
            $row->quantity,
            $row->order_amount,
            $row->order_date ? Carbon::parse($row->order_date)->format('Y-m-d') : '',
        ];
    }
}
