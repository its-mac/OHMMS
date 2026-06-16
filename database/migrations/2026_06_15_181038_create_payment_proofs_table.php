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
        Schema::create('payment_proofs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            $table->decimal('amount', 10, 2);
            $table->date('payment_date');

            $table->enum('payment_method', [
                'bank_transfer',
                'jazzcash',
                'easypaisa',
                'cheque',
                'cash',
            ]);

            $table->string('reference_no')->nullable();
            $table->string('receipt');

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->text('manager_remarks')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_proofs');
    }
};
