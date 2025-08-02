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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->string('image')->nullable(); // image path
            $table->text('options'); // the possible options (stored as text)
            $table->string('answer'); // the correct answer
            $table->enum('difficulty', ['easy', 'medium', 'hard']);
            $table->enum('question_type', ['Multiple Choice', 'True/False', 'Open Ended', 'Fill in the Blank']);
            $table->enum('education_level', ['Elementary', 'Middle School', 'High School', 'University']);
            $table->foreignId('topic_id')->constrained()->onDelete('cascade');
            $table->string('institution');
            $table->string('source');
            $table->year('year');
            $table->string('region');
            $table->string('uf', 2); // Brazilian state code
            $table->string('doc'); // document path
            $table->string('answer_doc'); // type of document (e.g., PDF, DOCX)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
