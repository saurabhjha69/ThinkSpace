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
        Schema::create('bundle_course', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses','id')->cascadeOnDelete();
            $table->foreignId('bundle_id')->constrained('bundles','id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
