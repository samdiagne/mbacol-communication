<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('search_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable();
            $table->string('query');
            $table->integer('results_count')->default(0);
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['session_id', 'created_at']);
        });

        // Table pour analytics des recherches populaires
        Schema::create('popular_searches', function (Blueprint $table) {
            $table->id();
            $table->string('query')->unique();
            $table->integer('search_count')->default(1);
            $table->integer('click_count')->default(0);
            $table->timestamp('last_searched_at');
            $table->timestamps();

            $table->index('search_count');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('search_history');
        Schema::dropIfExists('popular_searches');
    }
};