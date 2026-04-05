<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->cascadeOnDelete();
            $table->enum('type', ['hero', 'text', 'card_grid', 'video', 'faq', 'testimonial', 'gallery', 'contact_form']);
            $table->json('content')->comment('Type-specific content structure');
            $table->integer('display_order')->default(0);
            $table->boolean('is_reusable')->default(false);
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            $table->index(['page_id', 'display_order']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};
