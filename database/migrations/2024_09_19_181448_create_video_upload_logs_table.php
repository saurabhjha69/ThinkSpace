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
        Schema::create('video_upload_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submodule_id')->nullable()->constrained()->onDelete('cascade'); // Add onDelete if you want to cascade on delete
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('video_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('video_url')->nullable();
            $table->enum('status', ['success', 'failed', 'pending'])->default('pending');
            $table->string('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_upload_logs');
    }
};
