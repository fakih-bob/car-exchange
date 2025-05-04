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
        Schema::create('pricing_models', function (Blueprint $table) {
            $table->id();
        
            // Short distance: flat price if distance <= limit
            $table->decimal('short_distance_limit', 5, 2)->default(5.00); // e.g. 5 km
            $table->decimal('short_distance_price', 8, 2)->default(0.00); // e.g. $4.00
        
            // Long distance: charge per km beyond limit
            $table->decimal('long_distance_rate', 8, 2)->default(0.00); // e.g. $0.80
        
            // Volume-based pricing (height × width × length)
            $table->decimal('per_volume_rate', 8, 4)->default(0.00); // e.g. $0.005 / unit
            
            $table->decimal('per_weight_rate', 8, 4)->default(0.00); // new line
            // Link to driver
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_models');
    }
};
