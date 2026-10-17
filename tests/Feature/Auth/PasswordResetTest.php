<?php

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

use function Pest\Laravel\get;
use function Pest\Laravel\postJson;

test('sending a reset link to an existing email dispatches the custom reset notification', function () {
    Notification::fake();

    $user = User::factory()->create();

    postJson('/forgot-password', ['email' => $user->email])->assertOk();

    Notification::assertSentTo($user, ResetPasswordNotification::class);
});

test('sending a reset link to an email that does not exist returns 404 and sends nothing', function () {
    Notification::fake();

    postJson('/forgot-password', ['email' => 'nobody@example.com'])->assertStatus(404);

    Notification::assertNothingSent();
});

test('forgot-password requires a validly formatted email', function () {
    postJson('/forgot-password', ['email' => 'not-an-email'])->assertJsonValidationErrors(['email']);
});

test('guest can view the reset-password form page', function () {
    get(route('password.reset', ['token' => 'some-token', 'email' => 'test@example.com']))->assertOk();
});

test('authenticated user is redirected away from the reset-password form page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('password.reset', ['token' => 'some-token', 'email' => 'test@example.com']))
        ->assertRedirect(route('home'));
});

test('user can reset their password with a valid token', function () {
    $user = User::factory()->create(['password' => Hash::make('old-password')]);
    $token = Password::createToken($user);

    postJson('/reset-password', [
        'token' => $token,
        'email' => $user->email,
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ])->assertOk();

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

test('resetting the password rotates the remember token, logging out other sessions', function () {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
        'remember_token' => 'a-known-old-token',
    ]);
    $token = Password::createToken($user);

    postJson('/reset-password', [
        'token' => $token,
        'email' => $user->email,
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    expect($user->fresh()->remember_token)->not->toBe('a-known-old-token');
});

test('cannot reset the password with an invalid token', function () {
    $user = User::factory()->create();

    postJson('/reset-password', [
        'token' => 'this-is-not-a-real-token',
        'email' => $user->email,
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ])->assertStatus(422)->assertJsonValidationErrors(['token']);
});

test('password confirmation must match', function () {
    $user = User::factory()->create();
    $token = Password::createToken($user);

    postJson('/reset-password', [
        'token' => $token,
        'email' => $user->email,
        'password' => 'new-password',
        'password_confirmation' => 'a-different-password',
    ])->assertJsonValidationErrors(['password']);
});

test('new password must be at least 6 characters', function () {
    $user = User::factory()->create();
    $token = Password::createToken($user);

    postJson('/reset-password', [
        'token' => $token,
        'email' => $user->email,
        'password' => '123',
        'password_confirmation' => '123',
    ])->assertJsonValidationErrors(['password']);
});
