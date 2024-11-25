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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_no');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->string('shipping');
            $table->enum('payment', ['Pending', 'Paid']);
            $table->text('notes')->nullable();
            $table->timestamps();


            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
