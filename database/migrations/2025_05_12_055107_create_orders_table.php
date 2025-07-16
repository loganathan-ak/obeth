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
            
            $table->string('order_id')->nullable()->unique();

            $table->string('project_title');
            
            $table->string('request_type');

            $table->string('sub_service')->nullable();
        
            $table->text('instructions')->nullable();

            $table->string('colors')->nullable();

            $table->string('other_color_format')->nullable();
        
            $table->string('size')->nullable();

            $table->string('other_size')->nullable();
        
            $table->string('software')->nullable();

            $table->string('other_software')->nullable();
        
            $table->foreignId('brands_profile_id')->nullable();

            $table->json('formats')->nullable(); // From checkbox input
        
            $table->string('pre_approve')->nullable();
        
            $table->json('reference_files')->nullable(); // Store paths or filenames
        
            $table->boolean('rush')->default(false);
        
            $table->foreignId('created_by');

            $table->string('obeth_id');

            $table->foreignId('assigned_to')->nullable();
        
            $table->string('status')->default('Pending'); // optional default

            $table->boolean('seen')->default(false);
        
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
