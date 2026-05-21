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
        Schema::create('media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename');
            $table->string('original_filename');
            $table->string('path');
            $table->string('mime_type', 100);
            $table->bigInteger('size');
            $table->string('alt_text')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable()->index('media_uploaded_by_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
