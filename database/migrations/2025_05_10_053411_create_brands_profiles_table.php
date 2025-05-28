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
        Schema::create('brands_profiles', function (Blueprint $table) {
            $table->id();
            $table->date('brand_date');
            $table->string('brand_name');
            $table->string('industry')->nullable();
            $table->string('other_industry')->nullable();
            $table->string('web_address')->nullable();
            $table->string('brand_audience')->nullable();
            $table->string('brand_description')->nullable();
            $table->string('logo')->nullable(); // File path
            $table->string('color_codes')->nullable();
            $table->string('fonts')->nullable();
            $table->string('brand_guide')->nullable(); // File path
            $table->string('additional_assets')->nullable(); // File path
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands_profiles');
    }
};
