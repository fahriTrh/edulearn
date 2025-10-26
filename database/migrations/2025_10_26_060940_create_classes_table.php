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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('instructors')->onDelete('cascade');
            $table->string('code')->unique(); // CS301
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('semester'); // Ganjil 2024/2025
            $table->enum('status', ['active', 'inactive', 'archived'])->default('active');
            $table->integer('max_students')->default(50);
            $table->string('cover_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
