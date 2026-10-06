<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            $table->nullableMorphs('commentable');

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnDelete();
            $table->foreignId('reply_id')->nullable()->constrained('comments')->cascadeOnDelete();

            $table->text('body');
            $table->text('content')->nullable();

            $table->unsignedSmallInteger('reply_count')->default(0); //0 - 65,535 i think it's enough
            $table->unsignedInteger('like_count')->default(0); //0 - 4,294,967,295
            $table->unsignedInteger('dislike_count')->default(0); //0 - 4,294,967,295

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
