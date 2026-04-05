<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->enum('category', ['admissions', 'faculties', 'events', 'about', 'quality', 'media', 'campus', 'staff', 'student_services']);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->char('language', 2)->default('en')->comment('ISO 639-1 code');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            $table->unique(['slug', 'language']);
            $table->index('status');
            $table->index('category');
            $table->index('language');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
