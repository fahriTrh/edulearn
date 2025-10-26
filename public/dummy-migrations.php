<?php

// 1. create_users_table.php (sudah ada default Laravel, tinggal modifikasi)
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'instructor', 'student'])->default('student');
            $table->string('nim')->nullable()->unique(); // untuk mahasiswa
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->date('birth_date')->nullable();
            $table->string('address')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};

// 2. create_instructors_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable(); // Gelar akademik
            $table->text('specialization'); // Keahlian
            $table->text('description')->nullable();
            $table->decimal('rating', 3, 2)->default(0); // Rating 0-5
            $table->integer('total_students')->default(0);
            $table->integer('total_courses')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instructors');
    }
};

// 3. create_categories_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // emoji atau icon class
            $table->string('color')->nullable(); // warna untuk badge
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};

// 4. create_courses_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('instructors')->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('thumbnail')->nullable();
            $table->integer('duration_hours')->default(0); // durasi dalam jam
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->decimal('price', 10, 2)->default(0);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('max_students')->nullable();
            $table->integer('enrolled_students')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};

// 5. create_course_enrollments_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->date('enrolled_at');
            $table->date('completed_at')->nullable();
            $table->integer('progress')->default(0); // 0-100%
            $table->enum('status', ['active', 'completed', 'dropped'])->default('active');
            $table->decimal('final_score', 5, 2)->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'course_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_enrollments');
    }
};

// 6. create_modules_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('modules');
    }
};

// 7. create_lessons_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content')->nullable();
            $table->enum('type', ['video', 'text', 'pdf', 'quiz'])->default('text');
            $table->string('video_url')->nullable();
            $table->string('file_path')->nullable();
            $table->integer('duration_minutes')->default(0);
            $table->integer('order')->default(0);
            $table->boolean('is_preview')->default(false); // bisa dilihat tanpa enroll
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lessons');
    }
};

// 8. create_lesson_completions_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('lesson_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->timestamp('completed_at');
            $table->timestamps();
            
            $table->unique(['user_id', 'lesson_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('lesson_completions');
    }
};

// 9. create_assignments_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('file_path')->nullable(); // file instruksi
            $table->integer('max_score')->default(100);
            $table->integer('weight')->default(0); // bobot nilai
            $table->dateTime('due_date');
            $table->boolean('allow_late_submission')->default(false);
            $table->enum('status', ['draft', 'published', 'closed'])->default('published');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignments');
    }
};

// 10. create_assignment_submissions_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content')->nullable();
            $table->string('file_path')->nullable();
            $table->dateTime('submitted_at');
            $table->enum('status', ['submitted', 'graded', 'late', 'revision'])->default('submitted');
            $table->decimal('score', 5, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->dateTime('graded_at')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->unique(['assignment_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignment_submissions');
    }
};

// 11. create_quizzes_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('duration_minutes')->default(30);
            $table->integer('passing_score')->default(70); // nilai minimal lulus
            $table->integer('max_attempts')->default(1);
            $table->boolean('show_results')->default(true);
            $table->boolean('shuffle_questions')->default(false);
            $table->dateTime('available_from')->nullable();
            $table->dateTime('available_until')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
};

// 12. create_quiz_questions_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->text('question');
            $table->enum('type', ['multiple_choice', 'true_false', 'essay'])->default('multiple_choice');
            $table->integer('points')->default(1);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_questions');
    }
};

// 13. create_quiz_options_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('quiz_questions')->onDelete('cascade');
            $table->text('option_text');
            $table->boolean('is_correct')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_options');
    }
};

// 14. create_quiz_attempts_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('attempt_number')->default(1);
            $table->dateTime('started_at');
            $table->dateTime('completed_at')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->boolean('passed')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_attempts');
    }
};

// 15. create_quiz_answers_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('quiz_attempts')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('quiz_questions')->onDelete('cascade');
            $table->foreignId('option_id')->nullable()->constrained('quiz_options')->onDelete('cascade');
            $table->text('essay_answer')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->decimal('points_earned', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_answers');
    }
};

// 16. create_schedules_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['live_session', 'webinar', 'deadline'])->default('live_session');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('platform')->nullable(); // Zoom, Google Meet, etc
            $table->string('meeting_link')->nullable();
            $table->string('meeting_id')->nullable();
            $table->string('meeting_password')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};

// 17. create_discussions_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->enum('category', ['general', 'help', 'feedback', 'announcement'])->default('general');
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_answered')->default(false);
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discussions');
    }
};

// 18. create_discussion_replies_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('discussion_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->boolean('is_answer')->default(false); // jawaban terbaik
            $table->integer('likes')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discussion_replies');
    }
};

// 19. create_discussion_likes_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('discussion_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('likeable_type'); // Discussion atau DiscussionReply
            $table->unsignedBigInteger('likeable_id');
            $table->timestamps();
            
            $table->unique(['user_id', 'likeable_type', 'likeable_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('discussion_likes');
    }
};

// 20. create_certificates_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('certificate_number')->unique();
            $table->date('issued_date');
            $table->date('expiry_date')->nullable();
            $table->string('file_path')->nullable(); // PDF sertifikat
            $table->decimal('final_score', 5, 2);
            $table->text('skills')->nullable(); // JSON array skills
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificates');
    }
};

// 21. create_notifications_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // assignment, quiz, discussion, announcement
            $table->string('title');
            $table->text('message');
            $table->string('link')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};

// 22. create_reviews_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->timestamps();
            
            $table->unique(['course_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};

// 23. create_activity_logs_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('action'); // login, logout, enroll, submit, etc
            $table->string('description');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};

// 24. create_settings_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, number, boolean, json
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};