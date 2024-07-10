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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_type')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('transaction_url')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('order_service_games_id')->nullable();
            $table->decimal('price', 8, 2)->default(0.00);
            $table->string('transaction_status')->nullable();
            $table->boolean('is_success')->nullable();
            $table->date('transaction_date')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->foreign('order_service_games_id')->references('id')->on('order_service_games')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
