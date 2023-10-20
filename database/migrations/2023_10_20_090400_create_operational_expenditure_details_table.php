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
        Schema::create('operational_expenditure_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operational_expenditure_id')->nullable();
            $table->foreign('operational_expenditure_id', 'operational_expenditure_detail_foreign')
                ->references('id')
                ->on('operational_expenditures')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('operational_expenditure_details');
    }
};
