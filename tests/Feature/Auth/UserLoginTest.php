<?php

use App\Models\User;

// ----------------------------------------------------------
// ----------------------------------------------------------
// ----------------------Login Access Test-------------------
// ----------------------------------------------------------
// ----------------------------------------------------------

test('guest can access login page', function () {
    $this->get(route('login'))->assertStatus(200);
});

test('authenticated user cannot access login page', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->get(route('login'))->assertRedirect(route('dashboard'));
});

test('authenticated user can see dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertStatus(200);
});

// ----------------------------------------------------------
// ----------------------------------------------------------
// --------------------Login Validation Test-----------------
// ----------------------------------------------------------
// ----------------------------------------------------------

test('email is required', function () {
    $this->post(route('login'), [
        'email' => '',
        'password' => '123456',
    ])->assertSessionHasErrors(['email']);
});

test('email must be valid format', function () {
    $this->post(route('login'), [
        'email' => 'invalid-email',
        'password' => '123456',
    ])->assertSessionHasErrors(['email']);
});

test('email must exist in database', function () {
    $this->post(route('login'), [
        'email' => 'notfound@mail.com',
        'password' => '123456',
    ])->assertSessionHasErrors(['email']);
});

test('password is required', function () {
    $this->post(route('login'), [
        'email' => 'user@example.com',
        'password' => '',
    ])->assertSessionHasErrors(['password']);
});


// ----------------------------------------------------------
// ----------------------------------------------------------
// ----------------------Login Attempt Test------------------
// ----------------------------------------------------------
// ----------------------------------------------------------

test('user can login with correct credentials', function () {
    $user = User::factory()->create([
        'password' => bcrypt('123456'),
    ]);
    $this->post(route('login'), [
        'email' => $user->email,
        'password' => '123456',
    ])->assertRedirect(route('home'));

    $this->assertAuthenticatedAs($user);
});

test('user cannot login with wrong password', function () {
    $user = User::factory()->create([
        'password' => bcrypt('123456'),
    ]);

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrongpass',
    ])->assertSessionHasErrors(['email']);

    $this->assertGuest();
});


// ----------------------------------------------------------
// ----------------------------------------------------------
// -----------------------Remember Me Test--------------------
// ----------------------------------------------------------
// ----------------------------------------------------------

test('remember me sets remember_token in database', function () {
    $user = User::factory()->create([
        'password' => bcrypt('123456'),
    ]);

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => '123456',
        'remember' => true,
    ]);

    //با remember یوزر آپدیت میشه برای همین با user->fresh() یوزر آپدیت شده رو میگیریم

    expect($user->fresh()->remember_token)->not->toBeNull();
});


// ----------------------------------------------------------
// ----------------------------------------------------------
// --------------------Intended Redirect Test----------------
// ----------------------------------------------------------
// ----------------------------------------------------------

test('user is redirected to intended page after login', function () {
    $user = User::factory()->create([
        'password' => bcrypt('123456'),
    ]);

    $this->withSession(['url.intended' => '/profile']);

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => '123456',
    ])->assertRedirect('/profile');
});


// ----------------------------------------------------------
// ----------------------------------------------------------
// -------------------------Logout Test-----------------------
// ----------------------------------------------------------
// ----------------------------------------------------------

test('authenticated user can logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect(route('home'));

    $this->assertGuest();
});
