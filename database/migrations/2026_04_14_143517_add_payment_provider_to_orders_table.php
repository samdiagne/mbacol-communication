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
        if (!Schema::hasColumn('orders', 'payment_provider')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_provider')->nullable()->after('payment_method');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'payment_provider')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('payment_provider');
            });
        }
    }
};
