<?php

use App\Models\Category;
use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// it('number add currectly', function () {
//     expect(1 + 1)->toBe(2);
// });

// it('home page work', function () {
//     $this->get('/')->assertStatus(200);
// });

// uses()->group('category');
// uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// it('stores a category successfully', function () {

//     // Fake storage for image upload
//     Storage::fake('local');

//     // Mock image service
//     $mock = Mockery::mock(ImageService::class);
//     $mock->shouldReceive('upload')
//         ->once()
//         ->andReturn('category/test-image.webp');

//     $this->app->instance(ImageService::class, $mock);

//     $response = $this->post(route('category.store'), [
//         'name' => 'دسته تست',
//         'name_en' => 'test category',
//         'description' => 'A test description',
//         'image' => UploadedFile::fake()->image('test.jpg'),
//     ]);

//     $response->assertRedirect();
//     $response->assertSessionHas('message', 'دسته بندی با موفقیت ایجاد شد');

//     // Database stored?
//     $this->assertDatabaseHas('categories', [
//         'name' => 'دسته تست',
//         'name_en' => 'test category',
//         'slug' => 'test-category',
//         'image' => 'category/test-image.webp'
//     ]);
// });

// it('validates the store request', function () {

//     $response = $this->post(route('category.store'), [
//         'name' => '',
//         'name_en' => '',
//         'description' => '',
//     ]);

//     $response->assertSessionHasErrors([
//         'name',
//         'name_en',
//         'description'
//     ]);
// });


// it('generates a valid slug from name_en', function () {
//     Storage::fake('local');

//     $mock = Mockery::mock(ImageService::class);
//     $mock->shouldReceive('upload')->andReturn(null);

//     $this->app->instance(ImageService::class, $mock);

//     $this->post(route('category.store'), [
//         'name' => 'test',
//         'name_en' => 'My Category! Name__Test',
//         'description' => 'desc'
//     ]);

//     $this->assertDatabaseHas('categories', [
//         'slug' => 'my-category-name-test'
//     ]);
// });


// it('stores category without image', function () {
//     $this->post(route('category.store'), [
//         'name' => 'test',
//         'name_en' => 'test en',
//         'description' => 'desc'
//     ]);

//     $this->assertDatabaseHas('categories', [
//         'name' => 'test',
//         'image' => null
//     ]);
// });
