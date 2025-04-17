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
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->id();
            
            $table->enum('type', ['time_based', 'quantity_based']);
            $table->enum('discount_type', ['discount', 'markup'])->default('discount');
            $table->decimal('discount_value', 8, 2);
            
            $table->unsignedInteger('min_quantity')->nullable();
            
            $table->enum('day_of_week', [
                'monday', 'tuesday', 'wednesday',
                'thursday', 'friday', 'saturday', 'sunday'
            ])->nullable();
            
            $table->integer('precedence')->default(0);
            $table->boolean('is_active')->default(true);
            
            // Indexes
            $table->index('precedence');
            $table->index('is_active');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_rules');
    }
};
