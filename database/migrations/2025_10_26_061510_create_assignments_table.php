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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('instructions')->nullable();
            $table->timestamp('deadline');
            $table->timestamp('available_from')->nullable();
            $table->integer('weight_percentage')->default(10); // bobot nilai (%)
            $table->integer('max_score')->default(100);
            $table->enum('submission_type', ['file', 'text', 'link'])->default('file');
            $table->string('allowed_file_types')->nullable(); // pdf,docx,zip
            $table->integer('max_file_size')->nullable(); // dalam MB
            $table->boolean('allow_late_submission')->default(false);
            $table->integer('late_penalty_percentage')->nullable();
            $table->integer('total_submissions')->default(0);
            $table->enum('status', ['draft', 'published', 'closed'])->default('published');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
