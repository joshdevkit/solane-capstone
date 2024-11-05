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
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->date('date_added');
            $table->string('reference_no');
            $table->string('biller');
            $table->unsignedBigInteger('customer_id');
            $table->decimal('order_tax', 11, 2)->default(0);
            $table->decimal('discount', 11, 2)->default(0);
            $table->string('shipping');
            $table->string('attach_document');
            $table->string('return_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
