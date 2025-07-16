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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->integer('credits_purchased');
            $table->decimal('amount_paid', 8, 2);
            $table->string('payment_method')->default('paypal');
            $table->string('transaction_id')->nullable();
            $table->string('subscription_id')->nullable();
            $table->date('expire_date')->nullable(); // <-- Add this line
            $table->integer('validity_days')->nullable();
            $table->string('status')->default('Active');
            $table->text('paypal_data')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
