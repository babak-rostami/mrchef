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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en');
            $table->string('slug');
            $table->string('image');
            $table->boolean('show_in_search');

            $table->decimal('calories_per_100g', 8, 2)->nullable();
            $table->decimal('fat_per_100g', 8, 2)->nullable();
            $table->decimal('carbs_per_100g', 8, 2)->nullable();
            $table->decimal('protein_per_100g', 8, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
