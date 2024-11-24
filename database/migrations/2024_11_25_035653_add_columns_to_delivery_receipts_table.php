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
        Schema::create('delivery_receipts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('invoice_number')->nullable();
            $table->string('invoice_to')->nullable();
            $table->string('attention')->nullable();
            $table->string('po_number')->nullable();
            $table->string('terms')->nullable();
            $table->string('rep')->nullable();
            $table->date('ship_date')->nullable();
            $table->string('fob')->nullable();
            $table->string('project')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_receipts', function (Blueprint $table) {
            //
        });
    }
};
