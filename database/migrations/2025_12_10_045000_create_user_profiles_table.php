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
        // Drop table if it exists to avoid conflicts
        Schema::dropIfExists('user_profiles');
        
        // Create user_profiles table for additional information
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            
            // Personal information
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            
            // Social media profiles
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('twitter')->nullable();
            $table->string('website')->nullable();
            
            // CV file
            $table->string('cv_file')->nullable();
            $table->timestamp('cv_updated_at')->nullable();
            
            // Profile photo and summary
            $table->string('profile_photo')->nullable();
            $table->text('summary')->nullable();
            
            $table->timestamps();
            
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};