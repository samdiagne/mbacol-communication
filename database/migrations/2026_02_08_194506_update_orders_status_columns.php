<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Modifier la colonne status
            $table->enum('status', [
                'pending',
                'confirmed', 
                'processing',
                'shipped',
                'delivered',
                'cancelled'
            ])->default('pending')->change();
            
            // Modifier la colonne payment_status
            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'refunded'
            ])->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
            $table->string('payment_status')->default('pending')->change();
        });
    }
};