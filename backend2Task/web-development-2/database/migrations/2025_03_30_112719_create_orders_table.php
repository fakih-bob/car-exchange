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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->decimal('cost', 10, 2)->nullable();
            $table->boolean('paid')->default(false);
            $table->decimal('distance', 10, 2)->nullable();
            $table->enum('status', ['pending', 'accepted', 'in_progress', 'delivered', 'canceled'])->default('pending');            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

                $table->foreignId('driver_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
                
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->decimal('weight', 8, 2)->default(0);
            $table->decimal('height', 8, 2)->default(0);
            $table->decimal('width', 8, 2)->default(0);
            $table->enum('Urgency', ['Standard', 'Priority', 'Urgent']);         
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
    }
};
