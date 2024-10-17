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
        Schema::create('multianswers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->text('question');
            $table->text('option1');
            $table->text('option2');
            $table->text('option3');
            $table->text('option4');            
            $table->text('choice1')->nullable();
            $table->text('choice2')->nullable();
            $table->text('choice3')->nullable();
            $table->text('choice4')->nullable(); 
            $table->integer('marks')->nullable();           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multianswers');
    }
};
