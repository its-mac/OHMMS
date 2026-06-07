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
        Schema::table('students', function (Blueprint $table) {
            $table->string('email')->nullable()->unique()->after('phone');
            $table->string('photo')->nullable()->after('email');
            $table->string('blood_group')->nullable()->after('photo');
            $table->text('address')->nullable()->after('blood_group');
            $table->string('guardian_name')->nullable()->after('address');
            $table->string('guardian_phone')->nullable()->after('guardian_name');
            $table->string('emergency_contact')->nullable()->after('guardian_phone');
            $table->boolean('fingerprint_enrolled')->default(false)->after('emergency_contact');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropUnique(['email']);

            $table->dropColumn([
                'email',
                'photo',
                'blood_group',
                'address',
                'guardian_name',
                'guardian_phone',
                'emergency_contact',
                'fingerprint_enrolled',
            ]);
        });
    }
};
