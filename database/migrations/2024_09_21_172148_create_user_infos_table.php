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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Common Fields
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('phone_no')->unique();
            $table->string('address')->nullable();
            $table->string('profile_picture')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->json('social_links')->nullable();
            $table->string('timezone')->nullable();
            $table->string('language_preference')->nullable();
            $table->enum('profile_status', ['complete', 'incomplete'])->default('incomplete');
        
            // Admin-Specific Fields (if needed)
            $table->string('admin_privileges')->nullable(); // For managing custom admin roles or privileges
            
            // Learner-Specific Fields
            $table->string('education')->nullable();        // Educational background  // Learning style (e.g., visual, auditory, kinesthetic)
            
            // Instructor-Specific Fields
            $table->string('specialization')->nullable();   // Areas of expertise
            $table->text('bio')->nullable();                // Instructor bio
            $table->string('work_experience')->nullable();  // Professional background
            $table->string('certifications')->nullable();   // Professional or teaching certifications
            
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
