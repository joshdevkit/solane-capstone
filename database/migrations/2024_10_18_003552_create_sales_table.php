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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->date('date_added');
            $table->string('reference_no');
            $table->string('biller');
            $table->unsignedBigInteger('customer_id');
            $table->string('order_tax');
            $table->string('order_discount');
            $table->string('shipping');
            $table->string('attached_documents');
            $table->string('sale_status');
            $table->string('payment_status');
            $table->string('sales_note');
            $table->timestamps();



            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
