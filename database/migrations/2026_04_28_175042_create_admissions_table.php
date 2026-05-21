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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();

            // Student Information
            $table->string('first_name');
            $table->string('second_name');
            $table->string('third_name');
            $table->string('fourth_name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('student_photo')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('qualification_certificate')->nullable();
            $table->string('student_id_document')->nullable();

            // Parent Information
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->string('parent_id_document')->nullable();

            // Application Status
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('student_code')->nullable()->unique();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();

            $table->timestamps();

            // Foreign key
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
