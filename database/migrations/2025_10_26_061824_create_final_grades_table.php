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
        Schema::create('final_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // student

            // Grade breakdown
            $table->decimal('assignment_score', 5, 2)->nullable();
            $table->decimal('quiz_score', 5, 2)->nullable();
            $table->decimal('midterm_score', 5, 2)->nullable();
            $table->decimal('final_score', 5, 2)->nullable();
            $table->decimal('project_score', 5, 2)->nullable();
            $table->decimal('participation_score', 5, 2)->nullable();

            // Final calculation
            $table->decimal('total_score', 5, 2); // total weighted score
            $table->string('letter_grade', 5); // A, A-, B+, B, B-, C+, C, D, E
            $table->decimal('grade_point', 3, 2); // 4.00, 3.67, 3.33, etc

            // Status
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('calculated_by')->constrained('users')->onDelete('cascade');

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['class_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_grades');
    }
};
