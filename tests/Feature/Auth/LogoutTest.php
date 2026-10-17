<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\post;

test('authenticated user can logout and is redirected home', function () {
    $user = User::factory()->create();

    actingAs($user)->post(route('logout'))->assertRedirect(route('home'));

    assertGuest();
});

test('guest cannot reach the logout endpoint directly — auth middleware redirects first', function () {
    post(route('logout'))->assertRedirect(route('login'));
});

test('logout invalidates the whole session, not just the auth guard', function () {
    $user = User::factory()->create();

    actingAs($user);
    session(['some-test-key' => 'some-value']);

    post(route('logout'));

    expect(session('some-test-key'))->toBeNull();
});
