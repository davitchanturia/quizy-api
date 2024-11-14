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
        Schema::create('user_choices', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('quiz_id')
                ->constrained('quizzes')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('owner_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        
            $table->foreignId('question_id')
                ->constrained('questions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->foreignId('answer_id')
                ->constrained('answers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_choices');
    }
};
