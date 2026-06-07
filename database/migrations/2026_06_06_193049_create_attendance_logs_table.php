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
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->foreignId('meal_session_id')
                ->constrained('meal_sessions')
                ->cascadeOnDelete();

            $table->date('attendance_date');
            $table->time('attendance_time');

            $table->enum('verification_method', ['fingerprint', 'manual'])
                ->default('fingerprint');
            $table->timestamps();

            $table->unique([
                'student_id',
                'meal_session_id',
                'attendance_date'
            ], 'unique_student_meal_attendance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};
