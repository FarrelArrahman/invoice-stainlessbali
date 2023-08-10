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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_breakdown_id')->constrained('transaction_breakdowns');
            $table->foreignId('item_id')->nullable()->constrained('items');
            $table->text('name')->nullable();
            $table->string('image')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->double('width')->default(0);
            $table->double('depth')->default(0);
            $table->double('height')->default(0);
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
        Schema::dropIfExists('transaction_items');
    }
};
