<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryReceiptItemsTable extends Migration
{
    public function up()
    {
        Schema::create('delivery_receipt_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_receipt_id')->constrained(); // Foreign key to delivery_receipts table
            $table->integer('qty');
            $table->string('item');
            $table->string('description')->nullable();
            $table->decimal('price_each', 10, 2);
            $table->decimal('amount', 10, 2);
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_receipt_items');
    }
}
