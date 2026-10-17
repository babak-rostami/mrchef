<?php

use App\Models\Category;
use App\Models\CkeditorImage;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\assertDatabaseHas;

// ----------------------------------------------------------
// ------------fills only just fillable columns--------------
// ----------------------------------------------------------

test('creating a category stores exactly the fillable fields', function () {
    $data = Category::factory()->make()->toArray();

    $category = Category::create($data);

    assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => $data['name'],
        'name_en' => $data['name_en'],
        'slug' => $data['slug'],
        'description' => $data['description'],
    ]);
});

test('mass assignment ignores fields that are not in $fillable', function () {
    // id عمداً توی $fillable نیست؛ این تست همون ادعای تیترِ بالا رو
    // واقعاً اثبات می‌کنه، نه فقط اینکه «یه ردیفی ساخته شد»
    $data = array_merge(Category::factory()->make()->toArray(), ['id' => 999999]);

    $category = Category::create($data);

    expect($category->id)->not->toBe(999999);
});

// ----------------------------------------------------------
// --------------Category Relations Tests--------------------
// ----------------------------------------------------------

test('a category belongs to a parent category', function () {
    $parent = Category::factory()->create();
    $child = Category::factory()->create(['parent_id' => $parent->id]);

    expect($child->parent->id)->toBe($parent->id);
});

test('a category has many children', function () {
    $parent = Category::factory()->create();
    Category::factory()->count(5)->create(['parent_id' => $parent->id]);

    expect($parent->children)->toHaveCount(5);

    foreach ($parent->children as $child) {
        expect($child->parent_id)->toBe($parent->id);
    }
});

test('a category has many editor images (morphMany)', function () {
    $category = Category::factory()->create();
    $editorImages = CkeditorImage::factory()->count(5)->forModel($category)->create();

    foreach ($editorImages as $editorImage) {
        expect($editorImage->editorable_id)->toBe($category->id);
        expect($editorImage->editorable_type)->toBe(Category::class);
    }

    expect($category->editorImages)->toHaveCount(5);
});

// ----------------------------------------------------------
// --------------After Delete Category Tests-----------------
// ----------------------------------------------------------

test('deleting a parent category sets its children parent_id to null, it does not delete them', function () {
    $parent = Category::factory()->create();
    $children = Category::factory()->count(5)->create(['parent_id' => $parent->id]);

    $parent->delete();

    foreach ($children as $child) {
        expect($child->fresh())->not->toBeNull();
        expect($child->fresh()->parent_id)->toBeNull();
    }
});

test('child categories are not deleted automatically when the parent is deleted', function () {
    $parent = Category::factory()->create();
    $child = Category::factory()->create(['parent_id' => $parent->id]);

    $parent->delete();

    expect(Category::find($child->id))->not->toBeNull();
});

test('deleting a category removes its editor images from the database', function () {
    Storage::fake('ftp');

    $category = Category::factory()->create();
    $editorImages = CkeditorImage::factory()->count(3)->forModel($category)->create();

    $category->delete();

    foreach ($editorImages as $editorImage) {
        expect(CkeditorImage::find($editorImage->id))->toBeNull();
    }
});

test('deleting a category removes its main image and thumbnail from disk', function () {
    Storage::fake('ftp');

    $imagePath = 'category/images/test.webp';
    $thumbPath = 'category/images/test-thumb.webp'; // قرارداد نام‌گذاری تامبنیل، نگاه کن به Imageable::getThumbPathAttribute
    Storage::disk('ftp')->put($imagePath, 'fake image content');
    Storage::disk('ftp')->put($thumbPath, 'fake thumbnail content');

    $category = Category::factory()->create(['image' => $imagePath]);

    $category->delete();

    Storage::disk('ftp')->assertMissing($imagePath);
    Storage::disk('ftp')->assertMissing($thumbPath);
});
