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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('staff_id')->nullable()->constrained('users');
            $table->date('transaction_date');
            $table->enum('transaction_status', ['Pending', 'In Progress', 'Completed', 'Picked Up', 'Cancelled'])->default('Pending');
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_status', ['Unpaid', 'Paid', 'Partial'])->default('Unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
