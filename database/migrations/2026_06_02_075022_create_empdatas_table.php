<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empdatas', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('mobile_number', 10);
            $table->string('email');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('product_name');
            $table->integer('quantity');
            $table->decimal('order_amount', 10, 2);
            $table->date('order_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empdatas');
    }
};
