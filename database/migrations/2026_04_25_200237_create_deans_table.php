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
        Schema::create('deans', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('title')->nullable();
            $table->string('position')->nullable();
            $table->string('faculty')->nullable();
            $table->string('image')->nullable();
            $table->text('welcome_text')->nullable();
            $table->text('education')->nullable();
            $table->text('experience')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deans');
    }
};
