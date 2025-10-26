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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // student

            // Component details
            $table->enum('component_type', ['assignment', 'quiz', 'midterm', 'final', 'project', 'participation'])->default('assignment');
            $table->unsignedBigInteger('component_id')->nullable(); // ID assignment/quiz
            $table->string('component_name'); // nama komponen

            // Scores
            $table->decimal('score', 5, 2); // nilai yang didapat
            $table->decimal('max_score', 5, 2)->default(100); // nilai maksimal
            $table->decimal('percentage', 5, 2)->nullable(); // persentase (score/max_score * 100)
            $table->decimal('weight', 5, 2)->default(0); // bobot komponen (%)
            $table->decimal('weighted_score', 5, 2)->nullable(); // nilai berbobot

            // Grading info
            $table->string('letter_grade')->nullable(); // A, B+, B, etc
            $table->foreignId('graded_by')->constrained('users')->onDelete('cascade');
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['class_id', 'user_id']);
            $table->index(['component_type', 'component_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
