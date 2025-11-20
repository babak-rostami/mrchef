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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->text('description');
            $table->text('body');
            $table->string('image');
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('views')->nullable();
            $table->unsignedSmallInteger('time_prepare')->nullable();
            $table->unsignedSmallInteger('time_cook')->nullable();
            $table->unsignedTinyInteger('servings')->nullable();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
