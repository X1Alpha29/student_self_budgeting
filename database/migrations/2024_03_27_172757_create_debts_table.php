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
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 8, 2); // Amount of the debt
            $table->date('date'); // Date the debt was incurred
            $table->date('payback_deadline'); // Deadline by which the debt should be paid back
            $table->string('name'); // Name of the debtor or the debt description
            $table->text('notes')->nullable(); // Any additional notes about the debt
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
