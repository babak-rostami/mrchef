<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\get;
use function Pest\Laravel\postJson;

// مودالِ لاگینِ واقعیِ سایت (resources/js/user/login.js) با axios.post
// درخواست می‌فرسته، پس همه‌جا عمداً postJson به کار می‌بریم.

test('guest can view the login page', function () {
    get(route('login.show'))->assertOk();
});

test('authenticated regular user is redirected to home instead of the login page', function () {
    $user = User::factory()->create();

    actingAs($user)->get(route('login.show'))->assertRedirect(route('home'));
});

test('authenticated admin is redirected to the admin dashboard instead of the login page', function () {
    $admin = User::factory()->admin()->create();

    actingAs($admin)->get(route('login.show'))->assertRedirect(route('admin.dashboard'));
});

test('user can log in with correct credentials', function () {
    $user = User::factory()->create(['password' => Hash::make('secret123')]);

    postJson(route('login'), ['email' => $user->email, 'password' => 'secret123'])
        ->assertOk()
        ->assertJson(['success' => true]);

    assertAuthenticatedAs($user);
});

test('user cannot log in with the wrong password', function () {
    $user = User::factory()->create(['password' => Hash::make('secret123')]);

    postJson(route('login'), ['email' => $user->email, 'password' => 'wrong-password'])
        ->assertStatus(401)
        ->assertJson(['success' => false]);

    assertGuest();
});

test('email must belong to an existing user', function () {
    postJson(route('login'), ['email' => 'nobody@example.com', 'password' => 'secret123'])
        ->assertJsonValidationErrors(['email']);
});

test('email is required', function () {
    postJson(route('login'), ['email' => '', 'password' => 'secret123'])
        ->assertJsonValidationErrors(['email']);
});

test('password is required', function () {
    $user = User::factory()->create();

    postJson(route('login'), ['email' => $user->email, 'password' => ''])
        ->assertJsonValidationErrors(['password']);
});

test('password must be at least 6 characters', function () {
    $user = User::factory()->create();

    postJson(route('login'), ['email' => $user->email, 'password' => '123'])
        ->assertJsonValidationErrors(['password']);
});

// باگِ واقعی: قبل از این fix، UserController::login همیشه
// Auth::attempt($credentials, 1) صدا می‌زد — یعنی remember token همیشه
// ساخته می‌شد، صرف‌نظر از اینکه کاربر واقعاً «مرا به خاطر بسپار» رو
// زده بود یا نه. این دو تست همون رفتار درست‌شده رو تثبیت می‌کنن.
test('remember token is NOT created when remember is not sent', function () {
    $user = User::factory()->create(['password' => Hash::make('secret123')]);

    postJson(route('login'), [
        'email' => $user->email,
        'password' => 'secret123',
        // عمداً remember رو نمی‌فرستیم — دقیقاً مثل مودالِ واقعیِ سایت
    ]);

    expect($user->fresh()->remember_token)->toBeNull();
});

test('remember token IS created when remember is sent as true', function () {
    $user = User::factory()->create(['password' => Hash::make('secret123')]);

    postJson(route('login'), [
        'email' => $user->email,
        'password' => 'secret123',
        'remember' => true,
    ]);

    expect($user->fresh()->remember_token)->not->toBeNull();
});
