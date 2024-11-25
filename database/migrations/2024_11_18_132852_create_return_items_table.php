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
        Schema::create('return_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('serial_id');
            $table->date('date_return');
            $table->string('return_no');
            $table->string('attach_document')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();


            $table->foreign('sales_id')->references('id')->on('sales')->onDelete('cascade');
            $table->foreign('serial_id')->references('id')->on('product_barcodes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_items');
    }
};
