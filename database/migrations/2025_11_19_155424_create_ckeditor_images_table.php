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
        Schema::create('ckeditor_images', function (Blueprint $table) {
            $table->id();
            $table->string('image');

            $table->nullableMorphs('editorable');
            // مشخص می‌کنه این عکس برای کدوم فیلدِ ادیتور هستش
            // (مثلاً 'body'، 'content'، 'description').
            $table->string('field')->nullable()->after('image');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ckeditor_images');
    }
};
