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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('registration_no')->unique();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('cnic')->nullable()->unique();

            $table->string('department')->nullable();
            $table->string('session')->nullable();

            $table->string('hostel')->nullable();
            $table->string('room_no')->nullable();

            $table->string('phone')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('photo')->nullable();
            $table->string('blood_group')->nullable();
            $table->text('address')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->boolean('fingerprint_enrolled')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
