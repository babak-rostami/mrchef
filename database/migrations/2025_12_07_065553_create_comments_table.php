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

            $table->unsignedBigInteger('commentable_id')->nullable();
            $table->string('commentable_type')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('reply_id')->nullable();

            $table->text('body');
            $table->text('content')->nullable();

            $table->unsignedSmallInteger('reply_count')->default(0); //0 - 65,535 i think it's enough
            $table->unsignedInteger('like_count')->default(0); //0 - 4,294,967,295
            $table->unsignedInteger('unlike_count')->default(0); //0 - 4,294,967,295

            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id')
                ->onDelete('cascade');
            $table->foreign('parent_id')->on('comments')->references('id')
                ->onDelete('cascade');
            $table->foreign('reply_id')->on('comments')->references('id')
                ->onDelete('cascade');
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
