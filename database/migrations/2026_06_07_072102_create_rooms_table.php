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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('floor_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('room_no');

            $table->integer('capacity')->default(1);

            $table->integer('occupied')->default(0);

            $table->enum('status', [
                'available',
                'full',
                'maintenance',
                'inactive'
            ])->default('available');

            $table->timestamps();

            $table->unique(['floor_id', 'room_no']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
