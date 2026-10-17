<?php

use App\Support\Schema\PageSchema;

test('builds the expected schema.org structure for a generic page', function () {
    $schema = PageSchema::build('ContactPage', 'تماس با ما', 'https://example.test/contact');

    expect($schema)->toMatchArray([
        '@context' => 'https://schema.org',
        '@type' => 'ContactPage',
        'name' => 'تماس با ما',
        'url' => 'https://example.test/contact',
    ]);
});

test('every page is nested under the site itself via isPartOf', function () {
    // این یعنی هر صفحه (ContactPage، AboutPage، ...) به گوگل میگه «من
    // بخشی از سایتِ Mrchef هستم» — اگه این قسمت خراب بشه، هیچ خطایی
    // توی سایت دیده نمیشه، فقط سئو ضعیف‌تر میشه
    $schema = PageSchema::build('AboutPage', 'درباره ما', 'https://example.test/about');

    expect($schema['isPartOf'])->toMatchArray([
        '@type' => 'WebSite',
        'name' => 'Mrchef',
        'url' => url('/'),
    ]);
});

test('the @type reflects whatever page type is passed in, not a fixed value', function () {
    $contact = PageSchema::build('ContactPage', 'x', 'https://example.test/x');
    $about = PageSchema::build('AboutPage', 'x', 'https://example.test/x');

    expect($contact['@type'])->toBe('ContactPage');
    expect($about['@type'])->toBe('AboutPage');
});
