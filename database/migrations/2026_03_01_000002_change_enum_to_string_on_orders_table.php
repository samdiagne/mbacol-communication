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
        Schema::table('orders', function (Blueprint $table) {
            // On transforme payment_method en string pour plus de flexibilité
            $table->string('payment_method')->default('cash')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // On repasse à l'enum originale si besoin
            $table->enum('payment_method', ['wave', 'orange_money', 'free_money', 'cash'])
                  ->default('cash')
                  ->change();
        });
    }
};