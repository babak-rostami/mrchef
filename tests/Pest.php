<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Unit tests still need the app
|--------------------------------------------------------------------------
|
| تست‌های Unit به container و هلپرهای لاراول (url()، route()، config())
| نیاز دارن — مثلاً app/Support/Schema/*.php همه‌شون از url()/route()
| استفاده می‌کنن. برای همین Unit هم به TestCase وصل میشه.
|
| عمداً RefreshDatabase نداره: تست‌های این پوشه نباید اصلاً به دیتابیس
| دست بزنن. اگه یه تست به DB نیاز داشت، جاش توی Feature ئه، نه Unit.
|
*/

pest()->extend(TestCase::class)
    ->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/