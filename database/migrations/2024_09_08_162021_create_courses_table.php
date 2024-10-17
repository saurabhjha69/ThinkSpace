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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('about');
            $table->integer('duration')->nullable();
            $table->string('language')->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->boolean('is_free')->default('false');
            $table->enum('difficulty', ['easy', 'intermediate', 'advanced'])->nullable();
            $table->integer('max_students')->nullable();
            $table->integer('price');
            $table->integer('est_price');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('thumbnail_url');
            $table->foreignId('video_id')->constrained('videos','id')->nullable();
            $table->softDeletes(); // Add soft delete column for tracking deleted courses.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
