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
        Schema::create('item_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items');
            $table->foreignId('transaction_item_id')->nullable()->constrained('transaction_items')->onDelete('cascade');
            $table->enum('change_type', ['In', 'Out']);
            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->foreignId('staff_id')->nullable()->constrained('users');
            $table->timestamp('log_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_logs');
    }
};
