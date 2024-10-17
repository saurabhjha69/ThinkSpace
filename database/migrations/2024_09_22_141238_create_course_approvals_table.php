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
        Schema::create('course_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses','id')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users','id')->onDelete('cascade');
            $table->enum('status',['approved','pending','rejected'])->default('pending');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_approvals');
    }
};
