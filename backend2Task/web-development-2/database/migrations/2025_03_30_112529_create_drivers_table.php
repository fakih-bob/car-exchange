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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
        
            // Vehicle & license info
            $table->integer('plate_number');
            $table->enum('vehicle_type', ['sedan', 'suv', 'van', 'truck']);
            $table->string('license_number', 50);
            $table->date('license_expiry')->nullable();
        
            // Status & work availability
            $table->enum('status', ['available', 'on_trip', 'offline'])->default('offline');
            $table->time('shift_start')->nullable();
            $table->time('shift_end')->nullable();
            $table->string('working_area', 100)->nullable();
        
            // Optional fields
            $table->decimal('rating', 2, 1)->default(0.0);
            $table->boolean('verified')->default(false);
          //  $table->integer('pricing_model')->default(0);
            // Link to users table
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
            $table->timestamps();
      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
