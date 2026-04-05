<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('filename')->unique();
            $table->string('original_name');
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size')->comment('Size in bytes');
            $table->string('path', 500);
            $table->foreignId('uploaded_by')->constrained('users')->restrictOnDelete();
            $table->string('alt_text')->nullable();
            $table->timestamps();
            
            $table->index('mime_type');
            $table->index('uploaded_by');
            
            // Fulltext index only for MySQL
            if (config('database.default') === 'mysql') {
                $table->fullText(['original_name', 'alt_text']);
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
