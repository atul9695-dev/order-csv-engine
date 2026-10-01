<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empdata extends Model
{
    protected $table = 'empdatas';

    protected $fillable = [
        'customer_name',
        'mobile_number',
        'email',
        'city',
        'state',
        'pincode',
        'product_name',
        'quantity',
        'order_amount',
        'order_date',
    ];

    protected $casts = [
        'order_date' => 'date',
        'quantity' => 'integer',
        'order_amount' => 'decimal:2',
    ];
}