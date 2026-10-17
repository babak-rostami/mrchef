<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

$guestOnlyRoutes = ['login.show', 'register.show'];

foreach ($guestOnlyRoutes as $routeName) {
    test("a guest can access {$routeName}", function () use ($routeName) {
        get(route($routeName))->assertOk();
    });

    test("an authenticated regular user is redirected home away from {$routeName}", function () use ($routeName) {
        $user = User::factory()->create();

        actingAs($user)->get(route($routeName))->assertRedirect(route('home'));
    });

    test("an authenticated admin is redirected to the dashboard away from {$routeName}", function () use ($routeName) {
        $admin = User::factory()->admin()->create();

        actingAs($admin)->get(route($routeName))->assertRedirect(route('admin.dashboard'));
    });
}
