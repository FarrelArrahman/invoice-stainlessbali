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
        Schema::create('technician_expenditure_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('technician_expenditure_id')->constrained('technician_expenditures');
            $table->string('item_name');
            $table->double('price')->default(0);
            $table->integer('qty')->default(0);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technician_expenditure_details');
    }
};
