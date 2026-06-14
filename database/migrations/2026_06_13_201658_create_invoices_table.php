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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            $table->string('invoice_no')->unique();
            $table->date('invoice_date');
            $table->date('due_date');

            $table->unsignedTinyInteger('month');
            $table->unsignedSmallInteger('year');

            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);

            $table->enum('status', ['unpaid', 'partial', 'paid'])->default('unpaid');

            $table->timestamps();

            $table->unique(['student_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
