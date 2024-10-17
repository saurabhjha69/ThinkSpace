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
        Schema::table('attemptedquizzes', function (Blueprint $table) {
            $table->integer('total_correct_ans')->default(0);
            $table->integer('total_wrong_ans')->default(0);
            $table->integer('total_attempted_ans')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attemptedquizzes', function (Blueprint $table) {
            $table->dropColumn('total_correct_ans');
            $table->dropColumn('total_wrong_ans');
            $table->dropColumn('total_attempted_ans');
        });
    }
};
