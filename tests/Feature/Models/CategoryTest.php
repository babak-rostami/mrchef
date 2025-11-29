<?php

use App\Models\Category;
use App\Models\CkeditorImage;

use function Pest\Laravel\assertDatabaseHas;

// ----------------------------------------------------------
// ----------------------------------------------------------
// ------------fills only just fillable columns--------------
// ----------------------------------------------------------
// ----------------------------------------------------------

test('create category', function () {
    $data = Category::factory()->make()->toArray();
    $category = Category::Create($data);

    assertDatabaseHas('categories', [
        'id' => $category->id
    ]);
});

// ----------------------------------------------------------
// ----------------------------------------------------------
// --------------Category Relations Tests--------------------
// ----------------------------------------------------------
// ----------------------------------------------------------

test('a category belong to parent', function () {
    $parent = Category::factory()->create();
    $child = Category::factory()->create(['parent_id' => $parent->id]);

    expect($child->parent->id)->toBe($parent->id);
});

test('a category has many children', function () {
    $parent = Category::factory()->create();
    Category::factory()->count(5)->create([
        'parent_id' => $parent->id
    ]);

    expect($parent->children->count())->toBe(5);

    foreach ($parent->children as $child) {
        expect($child->parent_id)->toBe($parent->id);
    }
});


test('a category has many editor image (morphMany)', function () {
    $category = Category::factory()->create();
    $editorImages = CkeditorImage::factory()->count(5)->forModel($category)->create();

    foreach ($editorImages as $editorImage) {
        expect($editorImage->editorable_id)->toBe($category->id);
        expect($editorImage->editorable_type)->toBe(get_class($category));
    }
    expect($category->editorImages->count())->toBe(5);
});

// ----------------------------------------------------------
// ----------------------------------------------------------
// --------------After Delete Category Tests-----------------
// ----------------------------------------------------------
// ----------------------------------------------------------

it('set children parent_id null after delete parent category', function () {
    $parent = Category::factory()->create();
    $children = Category::factory()->count(5)->create(['parent_id' => $parent->id]);

    $parent->delete();

    foreach ($children as $child) {
        expect($child->fresh()->parent_id)->toBeNull();
    }
});

it('child categories does not delete automatically', function () {
    $parent = Category::factory()->create();
    $child = Category::factory()->create([
        'parent_id' => $parent->id,
    ]);

    $parent->delete();

    expect(Category::find($child->id))->not()->toBeNull();
});
