<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\postJson;

// فرم ثبت‌نامِ واقعیِ سایت (مودالِ auth) همیشه با AJAX ارسال میشه
// (resources/js/user/register.js از axios استفاده می‌کنه و یه پاسخِ
// JSON انتظار داره)، پس همه‌جا عمداً postJson به کار می‌بریم، نه یه
// POSTِ فرم‌محورِ ساده که عملاً هیچ‌وقت توی اپِ واقعی اتفاق نمی‌افته.

test('guest can view the register page', function () {
    get(route('register.show'))->assertOk();
});

test('authenticated regular user is redirected to home instead of the register page', function () {
    $user = User::factory()->create();

    actingAs($user)->get(route('register.show'))->assertRedirect(route('home'));
});

test('authenticated admin is redirected to the admin dashboard instead of the register page', function () {
    // تستِ قبلی اینجا از $user->role استفاده می‌کرد که اصلاً ستونی روی
    // User نیست (نقش‌ها با Spatie/hasRole مدیریت میشن) — یعنی همیشه
    // null بود و این مسیر هیچ‌وقت واقعاً تست نمی‌شد. این‌طوری تضمینی‌تره.
    $admin = User::factory()->admin()->create();

    actingAs($admin)->get(route('register.show'))->assertRedirect(route('admin.dashboard'));
});

test('a guest can register with valid data and is logged in immediately', function () {
    postJson(route('register'), [
        'name' => 'بابک رستمی',
        'username' => 'babak',
        'email' => 'babak@example.com',
        'password' => 'secret123',
    ])->assertOk()->assertJson(['success' => true]);

    assertAuthenticated();
    assertDatabaseHas('users', [
        'email' => 'babak@example.com',
        'username' => 'babak',
    ]);
});

test('the password is hashed, not stored as plain text', function () {
    postJson(route('register'), [
        'name' => 'بابک رستمی',
        'username' => 'babak',
        'email' => 'babak@example.com',
        'password' => 'secret123',
    ]);

    $user = User::where('email', 'babak@example.com')->firstOrFail();

    expect($user->password)->not->toBe('secret123');
    expect(Hash::check('secret123', $user->password))->toBeTrue();
});

test('name is required', function () {
    postJson(route('register'), [
        'name' => '',
        'username' => 'babak',
        'email' => 'babak@example.com',
        'password' => 'secret123',
    ])->assertStatus(422)->assertJsonValidationErrors(['name']);
});

test('name must be a string, not a number', function () {
    postJson(route('register'), [
        'name' => 12345,
        'username' => 'babak',
        'email' => 'babak@example.com',
        'password' => 'secret123',
    ])->assertJsonValidationErrors(['name']);
});

test('name must be at least 3 characters', function () {
    postJson(route('register'), [
        'name' => 'ab',
        'username' => 'babak',
        'email' => 'babak@example.com',
        'password' => 'secret123',
    ])->assertJsonValidationErrors(['name']);
});

test('name cannot be longer than 50 characters', function () {
    postJson(route('register'), [
        'name' => str_repeat('a', 51),
        'username' => 'babak',
        'email' => 'babak@example.com',
        'password' => 'secret123',
    ])->assertJsonValidationErrors(['name']);
});

test('username only accepts letters and numbers', function () {
    postJson(route('register'), [
        'name' => 'بابک',
        'username' => 'babak-rostami!',
        'email' => 'babak@example.com',
        'password' => 'secret123',
    ])->assertJsonValidationErrors(['username']);
});

test('username must be unique', function () {
    User::factory()->create(['username' => 'babak']);

    postJson(route('register'), [
        'name' => 'یکی دیگه',
        'username' => 'babak',
        'email' => 'other@example.com',
        'password' => 'secret123',
    ])->assertJsonValidationErrors(['username']);
});

test('email is required', function () {
    postJson(route('register'), [
        'name' => 'بابک',
        'username' => 'babak',
        'email' => '',
        'password' => 'secret123',
    ])->assertJsonValidationErrors(['email']);
});

test('email must be a valid format', function () {
    postJson(route('register'), [
        'name' => 'بابک',
        'username' => 'babak',
        'email' => 'not-an-email',
        'password' => 'secret123',
    ])->assertJsonValidationErrors(['email']);
});

test('cannot register with an email that is already taken', function () {
    User::factory()->create(['email' => 'babak@example.com']);

    postJson(route('register'), [
        'name' => 'بابک',
        'username' => 'babak2',
        'email' => 'babak@example.com',
        'password' => 'secret123',
    ])->assertJsonValidationErrors(['email']);
});

test('password is required', function () {
    postJson(route('register'), [
        'name' => 'بابک',
        'username' => 'babak',
        'email' => 'babak@example.com',
        'password' => '',
    ])->assertJsonValidationErrors(['password']);
});

test('password must be at least 6 characters', function () {
    postJson(route('register'), [
        'name' => 'بابک',
        'username' => 'babak',
        'email' => 'babak@example.com',
        'password' => '12345',
    ])->assertJsonValidationErrors(['password']);
});
