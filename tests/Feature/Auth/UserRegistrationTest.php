<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

// ----------------------------------------------------------
// ----------------------------------------------------------
// -----------------Register Access Test---------------------
// ----------------------------------------------------------
// ----------------------------------------------------------

test('can access register page', function () {
    $this->get(route('register'))->assertStatus(200);
});

test('register a new user and redirect to dashboard', function () {
    $response = $this->post('/register', [
        'name' => 'babak',
        'email' => 'babak@gmail.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect('/dashboard');
});

test('authenticated user cannot access register page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('register.show'));
    $response->assertRedirect(route('dashboard'));
});

// ----------------------------------------------------------
// ----------------------------------------------------------
// ------------------Validation Tests------------------------
// ----------------------------------------------------------
// ----------------------------------------------------------

test('name is required', function () {
    $response = $this->post(route('register'), [
        'name' => '',
        'email' => 'test@example.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('name must be string', function () {
    $response = $this->post(route('register'), [
        'name' => 123123213,
        'email' => 'test@example.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ]);
    $response->assertSessionHasErrors(['name']);
});

test('name must be at least 3 characters', function () {
    $response = $this->post('/register', [
        'name' => 'ab',
        'email' => 'test@example.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('name cannot be longer than 50 characters', function () {
    $longName = str_repeat('a', 51);
    $response = $this->post('/register', [
        'name' => $longName,
        'email' => 'test@example.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('email is required', function () {
    $response = $this->post('/register', [
        'name' => 'Babak',
        'email' => '',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ]);

    $response->assertSessionHasErrors(['email']);
});

test('email must be a valid format', function () {
    $response = $this->post('/register', [
        'name' => 'Babak',
        'email' => 'invalid-email',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ]);

    $response->assertSessionHasErrors(['email']);
});

test('cannot register with existing email', function () {
    User::factory()->create(['email' => 'babak@gmail.com']);

    $response = $this->post('/register', [
        'name' => 'Babak',
        'email' => 'babak@gmail.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ]);

    $response->assertSessionHasErrors(['email']);
});

test('password is required', function () {
    $response = $this->post('/register', [
        'name' => 'Babak',
        'email' => 'test@example.com',
        'password' => '',
        'password_confirmation' => '',
    ]);

    $response->assertSessionHasErrors(['password']);
});

test('password must be string', function () {
    $response = $this->post(route('register'), [
        'name' => '',
        'email' => 'test@example.com',
        'password' => 232321323,
        'password_confirmation' => '12345678',

    ]);
    $response->assertSessionHasErrors(['password']);
});

test('password must be at least 6 characters', function () {
    $response = $this->post('/register', [
        'name' => 'Babak',
        'email' => 'test@example.com',
        'password' => '12345',
        'password_confirmation' => '12345',
    ]);

    $response->assertSessionHasErrors(['password']);
});

test('password must be confirmed', function () {
    $response = $this->post('/register', [
        'name' => 'Babak',
        'email' => 'test@example.com',
        'password' => '12345678',
        'password_confirmation' => 'wrong',
    ]);

    $response->assertSessionHasErrors(['password']);
});

// ----------------------------------------------------------
// ----------------------------------------------------------
// ----------------Password Hashing Test---------------------
// ----------------------------------------------------------
// ----------------------------------------------------------


test('password is hashed in database', function () {
    $this->post('/register', [
        'name' => 'Babak',
        'email' => 'test@example.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ]);

    $user = User::first();
    expect(Hash::check('12345678', $user->password))->toBeTrue();
});
