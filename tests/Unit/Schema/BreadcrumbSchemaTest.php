<?php

use App\Support\Schema\BreadcrumbSchema;

// این کلاس خروجی‌اش مستقیم توی <script type="application/ld+json"> هر
// صفحه چاپ میشه (نگاه کن به x-schema-tag و Breadcrumb component) — اگه
// ساختارش خراب بشه، گوگل breadcrumb رو اشتباه می‌فهمه، ولی هیچ خطای
// قابل‌مشاهده‌ای توی سایت دیده نمیشه. برای همین این منطق رو مستقل از
// Blade تست می‌کنیم.

test('always starts with "خانه" as the first item, pointing at the home route', function () {
    $schema = BreadcrumbSchema::build([], 'صفحه فعلی');

    expect($schema['itemListElement'][0])->toMatchArray([
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'خانه',
        'item' => route('home'),
    ]);
});

test('appends each parent in order, with incrementing position', function () {
    $parents = [
        ['url' => 'https://example.test/recipes', 'title' => 'رسپی ها'],
        ['url' => 'https://example.test/recipes/cake', 'title' => 'کیک'],
    ];

    $schema = BreadcrumbSchema::build($parents, 'طرز تهیه کیک شکلاتی');

    expect($schema['itemListElement'][1])->toMatchArray([
        'position' => 2,
        'name' => 'رسپی ها',
        'item' => 'https://example.test/recipes',
    ]);

    expect($schema['itemListElement'][2])->toMatchArray([
        'position' => 3,
        'name' => 'کیک',
        'item' => 'https://example.test/recipes/cake',
    ]);
});

test('the current page is the last item and has no link — it is the page the user is already on', function () {
    $schema = BreadcrumbSchema::build(
        [['url' => 'https://example.test/recipes', 'title' => 'رسپی ها']],
        'طرز تهیه کیک شکلاتی'
    );

    $lastItem = end($schema['itemListElement']);

    expect($lastItem)->toMatchArray([
        'position' => 3,
        'name' => 'طرز تهیه کیک شکلاتی',
    ])->not->toHaveKey('item');
});

test('with no parents, the list has exactly two items: home and the current page', function () {
    $schema = BreadcrumbSchema::build([], 'درباره ما');

    expect($schema['itemListElement'])->toHaveCount(2);
});
