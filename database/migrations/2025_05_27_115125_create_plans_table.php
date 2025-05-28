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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Basic Plan", "100 Credits", etc.
            $table->integer('credits'); // Number of credits provided
            $table->decimal('price', 8, 2); // Price of the plan (e.g., 9.99)
            $table->text('description')->nullable(); // Optional description
            $table->boolean('is_active')->default(true); // Plan active or not
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
