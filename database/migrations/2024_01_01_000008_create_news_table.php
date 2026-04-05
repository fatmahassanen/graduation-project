<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('body');
            $table->foreignId('featured_image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->foreignId('author_id')->constrained('users')->restrictOnDelete();
            $table->enum('category', ['announcement', 'achievement', 'research', 'partnership']);
            $table->boolean('is_featured')->default(false);
            $table->char('language', 2)->default('en');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            $table->index('slug');
            $table->index('category');
            $table->index('status');
            $table->index('published_at');
            $table->index('is_featured');
            
            // Fulltext index only for MySQL
            if (config('database.default') === 'mysql') {
                $table->fullText(['title', 'excerpt', 'body']);
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
