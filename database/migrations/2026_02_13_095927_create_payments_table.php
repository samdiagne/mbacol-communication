<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('payment_method'); // wave, orange_money, free_money, yass, cash
            $table->string('transaction_id')->nullable()->unique(); // ID transaction opérateur
            $table->string('payment_status')->default('pending'); // pending, completed, failed, cancelled
            $table->decimal('amount', 10, 2);
            $table->string('phone_number')->nullable(); // Numéro pour mobile money
            $table->text('response_data')->nullable(); // Réponse API (JSON)
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};