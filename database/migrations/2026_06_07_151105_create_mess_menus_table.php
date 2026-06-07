<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mess_menus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('meal_session_id')
                ->constrained('meal_sessions')
                ->cascadeOnDelete();

            $table->date('menu_date');
            $table->text('menu_items');
            $table->timestamps();

            $table->unique(['meal_session_id', 'menu_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mess_menus');
    }
};
