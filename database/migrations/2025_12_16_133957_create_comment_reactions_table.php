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
        Schema::create('comment_reactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('comment_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->char('visitor_id', 32);
            $table->enum('reaction', ['like', 'dislike']);

            $table->timestamps();

            $table->unique(['comment_id', 'visitor_id']);
            $table->index(['comment_id', 'reaction']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_reactions');
    }
};
