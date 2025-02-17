<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->unique(); // PayPal payment ID
            $table->decimal('amount', 38, 2); // Payment amount
            $table->string('currency')->default('USD'); // Currency (e.g., USD)
            $table->string('status')->default('pending'); // Payment status (e.g., pending, completed, failed)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User who made the payment
            $table->foreignId('task_id')->constrained()->onDelete('cascade'); // Task associated with the payment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
