<?php

use App\Models\Category;
use App\Models\CkeditorImage;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

test('active scope only returns recipes with status = 1', function () {
    Recipe::factory()->create(['status' => Recipe::STATUS_PUBLISHED]);
    Recipe::factory()->create(['status' => Recipe::STATUS_DRAFT]);
    Recipe::factory()->create(['status' => Recipe::STATUS_PENDING]);

    expect(Recipe::active()->count())->toBe(1);
});

test('latest scope orders recipes from newest to oldest', function () {
    $older = Recipe::factory()->create(['created_at' => now()->subDays(2)]);
    $newer = Recipe::factory()->create(['created_at' => now()]);

    expect(Recipe::latest()->pluck('id')->all())->toBe([$newer->id, $older->id]);
});

test('plain body strips HTML tags and turns block-level breaks into newlines', function () {
    $recipe = Recipe::factory()->create([
        'body' => '<p>مرحله اول</p><p>مرحله دوم</p><h2>یادداشت</h2>بدون تگ',
    ]);

    $plain = $recipe->plain_body;

    expect($plain)->not->toContain('<p>');
    expect($plain)->not->toContain('<h2>');
    expect($plain)->toContain("مرحله اول\nمرحله دوم");
    expect($plain)->toContain('یادداشت');
});

test('plain body collapses multiple consecutive blank lines into one', function () {
    $recipe = Recipe::factory()->create([
        'body' => '<p>مرحله اول</p><br><br><br><p>مرحله دوم</p>',
    ]);

    expect($recipe->plain_body)->not->toContain("\n\n\n");
});

test('sitemap chunk is derived purely from the recipe id', function () {
    // عمداً SITEMAP_CHUNK_SIZE رو هاردکد نمی‌کنیم؛ مستقیم از خودِ ثابتِ
    // کلاس می‌خونیم تا اگه یه روز عوض شد، این تست با واقعیت هماهنگ بمونه
    $chunkSize = Recipe::SITEMAP_CHUNK_SIZE;

    $recipe = Recipe::factory()->create();
    // یه idِ فرضیِ خیلی بزرگ‌تر، فقط برای چک کردنِ خودِ محاسبه — بدون
    // نیاز به واقعاً ساختنِ هزاران رکورد
    $recipe->id = $recipe->id + $chunkSize + 5;

    expect($recipe->sitemap_chunk)->toBe(intdiv($recipe->id - 1, $chunkSize) + 1);
});

test('a recipe belongs to a category and a user', function () {
    $category = Category::factory()->create();
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create(['category_id' => $category->id, 'user_id' => $user->id]);

    expect($recipe->category->id)->toBe($category->id);
    expect($recipe->user->id)->toBe($user->id);
});

test('ingredientsWithUnit returns the amount and unit name alongside each ingredient', function () {
    $unit = Unit::factory()->create(['name' => 'پیمانه']);
    $ingredient = Ingredient::factory()->create(['name' => 'آرد']);
    $recipe = Recipe::factory()->create();

    RecipeIngredient::create([
        'recipe_id' => $recipe->id,
        'ingredient_id' => $ingredient->id,
        'unit_id' => $unit->id,
        'amount' => 3,
    ]);

    $result = $recipe->ingredientsWithUnit()->first();

    expect($result->name)->toBe('آرد');
    expect($result->amount)->toBe(3);
    expect($result->unit_name)->toBe('پیمانه');
});

test('deleting a recipe removes its editor images from the database', function () {
    Storage::fake('ftp');

    $recipe = Recipe::factory()->create();
    $editorImages = CkeditorImage::factory()->count(2)->forModel($recipe)->create();

    $recipe->delete();

    foreach ($editorImages as $editorImage) {
        expect(CkeditorImage::find($editorImage->id))->toBeNull();
    }
});

test('deleting a recipe removes its main image and thumbnail from disk', function () {
    Storage::fake('ftp');

    $imagePath = 'recipe/images/test.webp';
    $thumbPath = 'recipe/images/test-thumb.webp';
    Storage::disk('ftp')->put($imagePath, 'fake content');
    Storage::disk('ftp')->put($thumbPath, 'fake content');

    $recipe = Recipe::factory()->create(['image' => $imagePath]);

    $recipe->delete();

    Storage::disk('ftp')->assertMissing($imagePath);
    Storage::disk('ftp')->assertMissing($thumbPath);
});
