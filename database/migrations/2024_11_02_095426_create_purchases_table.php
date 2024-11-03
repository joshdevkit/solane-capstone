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
            $table->date('date_added');
            $table->string('purchase_no');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->boolean('is_received');
            $table->decimal('order_tax', 8, 2);
            $table->decimal('discount', 8, 2);
            $table->string('shipping');
            $table->string('payment');
            $table->text('notes')->nullable();

            $table->timestamps();
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
