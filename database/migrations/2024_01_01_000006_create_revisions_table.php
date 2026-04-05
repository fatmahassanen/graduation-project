<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('revisionable_type')->comment('Polymorphic type');
            $table->unsignedBigInteger('revisionable_id')->comment('Polymorphic ID');
            $table->enum('action', ['created', 'updated', 'deleted', 'published', 'unpublished', 'restored']);
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index(['revisionable_type', 'revisionable_id']);
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revisions');
    }
};
