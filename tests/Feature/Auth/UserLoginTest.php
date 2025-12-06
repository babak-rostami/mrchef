<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\withSession;

// ----------------------------------------------------------
// ----------------------------------------------------------
// ----------------------Login Access Test-------------------
// ----------------------------------------------------------
// ----------------------------------------------------------
describe('access tests', function () {

    test('guest can access login page', function () {
        get(route('login'))->assertStatus(200);
    });

    test('authenticated user cannot access login page', function () {
        $user = User::factory()->create();
        actingAs($user);
        if ($user->role == 'admin') {
            get(route('login'))->assertRedirect(route('admin.dashboard'));
        } else {
            get(route('login'))->assertRedirect(route('home'));
        }
    });

    test('authenticated admin can see admin dashboard', function () {
        // ایجاد یوزر ادمین
        $admin = User::factory()->admin()->create();

        actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertStatus(200);
    });

    test('authenticated user can not see admin dashboard', function () {
        $user = User::factory()->create(['role' => 'user']);
        actingAs($user)->get(route('admin.dashboard'))->assertStatus(status: 302);
    });
});

// ----------------------------------------------------------
// ----------------------------------------------------------
// --------------------Login Validation Test-----------------
// ----------------------------------------------------------
// ----------------------------------------------------------

describe('validations tests', function () {
    test('email is required', function () {
        post(route('login'), [
            'email' => '',
            'password' => '123456',
        ])->assertSessionHasErrors(['email']);
    });

    test('email must be valid format', function () {
        post(route('login'), [
            'email' => 'invalid-email',
            'password' => '123456',
        ])->assertSessionHasErrors(['email']);
    });

    test('email must exist in database', function () {
        post(route('login'), [
            'email' => 'notfound@mail.com',
            'password' => '123456',
        ])->assertSessionHasErrors(['email']);
    });

    test('password is required', function () {
        post(route('login'), [
            'email' => 'user@example.com',
            'password' => '',
        ])->assertSessionHasErrors(['password']);
    });
});


// ----------------------------------------------------------
// ----------------------------------------------------------
// ----------------------Login Attempt Test------------------
// ----------------------------------------------------------
// ----------------------------------------------------------

describe('attemt to login', function () {
    test('user can login with correct credentials', function () {
        $user = User::factory()->create([
            'password' => bcrypt('123456'),
        ]);
        post(route('login'), [
            'email' => $user->email,
            'password' => '123456',
        ])->assertRedirect(route('home'));

        assertAuthenticatedAs($user);
    });

    test('user cannot login with wrong password', function () {
        $user = User::factory()->create([
            'password' => bcrypt('123456'),
        ]);

        post(route('login'), [
            'email' => $user->email,
            'password' => 'wrongpass',
        ])->assertSessionHasErrors(['email']);

        assertGuest();
    });
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

    post(route('login'), [
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

    withSession(['url.intended' => '/profile']);

    post(route('login'), [
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

    actingAs($user)
        ->post(route('logout'))
        ->assertRedirect(route('home'));

    assertGuest();
});
