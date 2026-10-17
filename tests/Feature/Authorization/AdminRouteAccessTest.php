<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

// همه‌ی روت‌های زیر پشت یه گروهِ واحد با middleware('role:admin') هستن
// (routes/web.php)، پس همه‌شون دقیقاً از یه مکانیزمِ یکسان رد میشن.
// به‌جای تکرار همین سه سناریو برای تک‌تکِ ده‌ها روتِ ادمین (که هیچ
// ارزشِ اضافه‌ای نداره، چون نتیجه‌ش از قبل مشخصه)، یه نمونه‌ی
// نماینده از بخش‌های مختلف (داشبورد، منابع resource، پیام‌ها، نظرات)
// انتخاب شده تا مطمئن بشیم خودِ میدل‌ور درست روی گروه اعمال شده.
$adminRoutes = [
    'admin.dashboard',
    'admin.category.index',
    'admin.recipes.index',
    'admin.unit.index',
    'admin.ingredient.index',
    'admin.messages.index',
    'admin.comments.index',
];

foreach ($adminRoutes as $routeName) {
    test("guest is redirected home (not shown a login form) when visiting {$routeName}", function () use ($routeName) {
        get(route($routeName))
            ->assertRedirect(route('home'))
            ->assertSessionHas('error');
    });

    test("a logged-in regular user CANNOT access {$routeName} just by requesting it directly", function () use ($routeName) {
        // این دقیقاً همون سناریوییه که باید همیشه مسدود بمونه: کاربر
        // عادی نباید صرفاً با زدن آدرس، به قابلیتِ مدیریتی برسه
        $user = User::factory()->create();

        actingAs($user)
            ->get(route($routeName))
            ->assertRedirect(route('home'))
            ->assertSessionHas('error');
    });

    test("an admin can access {$routeName}", function () use ($routeName) {
        $admin = User::factory()->admin()->create();

        actingAs($admin)->get(route($routeName))->assertOk();
    });
}
