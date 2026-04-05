<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('location')->nullable();
            $table->enum('category', ['competition', 'conference', 'exhibition', 'workshop', 'seminar']);
            $table->foreignId('image_id')->nullable()->constrained('media')->nullOnDelete();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_rule')->nullable()->comment('iCalendar RRULE format');
            $table->char('language', 2)->default('en');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
            
            $table->index(['start_date', 'end_date']);
            $table->index('category');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
