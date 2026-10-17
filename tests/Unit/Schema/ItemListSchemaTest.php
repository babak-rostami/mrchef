<?php

use App\Models\Recipe;
use App\Support\Schema\ItemListSchema;
use Illuminate\Support\Collection;

test('builds one ListItem per recipe, numbered from 1', function () {
    $recipes = new Collection([
        new Recipe(['slug' => 'cake-1']),
        new Recipe(['slug' => 'cake-2']),
    ]);

    $schema = ItemListSchema::buildForRecipes($recipes);

    expect($schema)->toMatchArray(['@context' => 'https://schema.org', '@type' => 'ItemList']);
    expect($schema['itemListElement'])->toHaveCount(2);

    expect($schema['itemListElement'][0])->toMatchArray([
        '@type' => 'ListItem',
        'position' => 1,
        'url' => route('recipes.show', 'cake-1'),
    ]);
    expect($schema['itemListElement'][1]['position'])->toBe(2);
});

test('positions are re-indexed from 1 even when the collection keys are not sequential', function () {
    // دقیقاً همون چیزی که IndexController::home() واقعاً انجام میده:
    // بعد از skip(1) روی یه Collection، کلیدهای داخلیش دیگه از 0 شروع
    // نمیشن — buildForRecipes باید positionِ نمایشی رو مستقل از این
    // کلیدهای داخلی بسازه، نه مستقیم ازشون استفاده کنه
    $recipes = (new Collection([
        new Recipe(['slug' => 'a']),
        new Recipe(['slug' => 'b']),
        new Recipe(['slug' => 'c']),
    ]))->skip(1);

    $schema = ItemListSchema::buildForRecipes($recipes);

    expect(array_column($schema['itemListElement'], 'position'))->toBe([1, 2]);
});

test('an empty collection produces an empty item list, not an error', function () {
    $schema = ItemListSchema::buildForRecipes(new Collection());

    expect($schema['itemListElement'])->toBe([]);
});
