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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_code')->unique(); // misal: ORD-20250702-XYZ
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', ['pending', 'paid', 'shipped', 'completed', 'cancelled'])->default('pending');
            $table->integer('raja_ongkir_id');
            $table->decimal('shipping_cost', 10, 2);
            $table->text('shipping_address');
            $table->string('payment_method')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
