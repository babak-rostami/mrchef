<?php

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use App\Support\Schema\RecipeSchema;
use Illuminate\Support\Collection;

// نمونه‌ی Recipe رو هیچ‌وقت save() نمی‌کنیم — این تست‌ها واقعاً Unit ـن
// (بدون دیتابیس). رابطه‌های user/category دستی با setRelation ست
// میشن تا به‌جای query واقعی، lazy-load هم اتفاق نیفته.
function makeTestRecipe(array $overrides = []): Recipe
{
    $recipe = new Recipe(array_merge([
        'title' => 'کیک شکلاتی',
        'description' => 'یک کیک خوشمزه',
        'body' => '<p>مرحله اول</p><p>مرحله دوم</p>',
    ], $overrides));

    $recipe->created_at = now();
    $recipe->updated_at = now();
    $recipe->setRelation('user', null);
    $recipe->setRelation('category', null);

    return $recipe;
}

test('builds the base schema.org Recipe fields from the model', function () {
    $recipe = makeTestRecipe();

    $schema = RecipeSchema::build($recipe, new Collection());

    expect($schema)->toMatchArray([
        '@context' => 'https://schema.org',
        '@type' => 'Recipe',
        'name' => 'کیک شکلاتی',
        'description' => 'یک کیک خوشمزه',
    ]);
});

test('falls back to "Mrchef" as the author when the recipe has no user', function () {
    $recipe = makeTestRecipe();

    $schema = RecipeSchema::build($recipe, new Collection());

    expect($schema['author'])->toBe(['@type' => 'Person', 'name' => 'Mrchef']);
});

test('uses the real author name when the recipe has a user', function () {
    $recipe = makeTestRecipe();
    $recipe->setRelation('user', new User(['name' => 'بهنام رستمی']));

    $schema = RecipeSchema::build($recipe, new Collection());

    expect($schema['author'])->toBe(['@type' => 'Person', 'name' => 'بهنام رستمی']);
});

test('converts each ingredient into a trimmed "amount unit name" string', function () {
    $recipe = makeTestRecipe();

    $ingredients = new Collection([
        (object) ['amount' => 2, 'unit_name' => 'پیمانه', 'name' => 'آرد'],
        (object) ['amount' => 1, 'unit_name' => 'قاشق چایخوری', 'name' => 'بکینگ پودر'],
    ]);

    $schema = RecipeSchema::build($recipe, $ingredients);

    expect($schema['recipeIngredient'])->toBe([
        '2 پیمانه آرد',
        '1 قاشق چایخوری بکینگ پودر',
    ]);
});

test('omits prepTime, cookTime and totalTime entirely when neither is set', function () {
    $recipe = makeTestRecipe(['time_prepare' => null, 'time_cook' => null]);

    $schema = RecipeSchema::build($recipe, new Collection());

    expect($schema)->not->toHaveKeys(['prepTime', 'cookTime', 'totalTime']);
});

test('computes totalTime as the sum of prepTime and cookTime, in ISO 8601 duration format', function () {
    $recipe = makeTestRecipe(['time_prepare' => 20, 'time_cook' => 45]);

    $schema = RecipeSchema::build($recipe, new Collection());

    expect($schema['prepTime'])->toBe('PT20M');
    expect($schema['cookTime'])->toBe('PT45M');
    expect($schema['totalTime'])->toBe('PT65M');
});

test('still computes totalTime when only one of prepTime/cookTime is set', function () {
    $recipe = makeTestRecipe(['time_prepare' => 20, 'time_cook' => null]);

    $schema = RecipeSchema::build($recipe, new Collection());

    expect($schema)->toHaveKey('totalTime', 'PT20M');
    expect($schema)->not->toHaveKey('cookTime');
});

test('includes recipeYield only when servings is set', function () {
    $withServings = makeTestRecipe(['servings' => 4]);
    $withoutServings = makeTestRecipe(['servings' => null]);

    expect(RecipeSchema::build($withServings, new Collection())['recipeYield'])->toBe('4 نفر');
    expect(RecipeSchema::build($withoutServings, new Collection()))->not->toHaveKey('recipeYield');
});

test('includes recipeCategory only when the recipe actually has a category', function () {
    $recipe = makeTestRecipe();
    $recipe->setRelation('category', new Category(['name' => 'دسرها']));

    $schema = RecipeSchema::build($recipe, new Collection());

    expect($schema['recipeCategory'])->toBe('دسرها');
});

test('recipeInstructions uses the plain-text body, not raw HTML', function () {
    $recipe = makeTestRecipe(['body' => '<p>مرحله اول</p><p>مرحله دوم</p>']);

    $schema = RecipeSchema::build($recipe, new Collection());

    // یعنی getPlainBodyAttribute واقعاً صدا زده میشه، نه خودِ body خام —
    // Google هیچ‌وقت نباید تگ HTML توی recipeInstructions ببینه
    expect($schema['recipeInstructions'])->not->toContain('<p>');
    expect($schema['recipeInstructions'])->toContain('مرحله اول');
    expect($schema['recipeInstructions'])->toContain('مرحله دوم');
});
