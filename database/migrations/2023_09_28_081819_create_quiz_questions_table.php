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
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('hide_title')->nullable();
            $table->string('correct_answner')->nullable();
            $table->string('question_answner_info')->nullable();
            $table->string('hints')->nullable();
            $table->integer('question_order')->nullable();
            $table->integer('question_type')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('quiz_id');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
