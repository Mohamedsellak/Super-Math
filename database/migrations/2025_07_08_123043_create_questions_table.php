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
            $table->json('options'); // the possible options (stored as JSON)
            $table->string('answer'); // the correct answer
            $table->enum('difficulty', ['easy', 'medium', 'hard']);
            $table->enum('question_type', ['Multiple Choice', 'True/False', 'Open Ended', 'Fill in the Blank']);
            $table->enum('education_level', ['Elementary', 'Middle School', 'High School', 'University']);
            $table->string('institution')->nullable();
            $table->string('source')->nullable();
            $table->year('year')->nullable();
            $table->string('region')->nullable();
            $table->string('uf', 2)->nullable(); // Brazilian state code
            $table->string('doc')->nullable(); // document path

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
