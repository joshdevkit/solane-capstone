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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('form_name');
            $table->string('file_path');
            // Pullout form fields
            $table->date('date');
            $table->string('plate');
            $table->string('customer');
            $table->string('dr');
            $table->string('driver');
            $table->string('seal_number');
            $table->decimal('total_cylinder_weight', 10, 2);
            $table->decimal('tare_weight', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
