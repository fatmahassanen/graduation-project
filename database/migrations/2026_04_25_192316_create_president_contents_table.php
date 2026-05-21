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
        Schema::create('president_contents', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->text('welcome_text')->nullable();
            $table->text('education')->nullable();
            $table->text('postdoctoral')->nullable();
            $table->text('administrative')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('president_contents');
    }
};
