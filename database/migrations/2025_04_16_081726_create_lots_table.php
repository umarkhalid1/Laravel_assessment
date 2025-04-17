<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('lot_number')->unique();
            $table->decimal('quantity');
            $table->decimal('price_per_unit');
            $table->decimal('total_price'); // total price for the lot
            $table->string('date');
            $table->string('location');
            $table->timestamps();

            $table->index(['product_id', 'lot_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
