<?php

use App\Models\Category;
use App\Models\CkeditorImage;
use App\Models\User;
use App\Services\ImageService;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;

it('delete main image and editor images after delete category', function () {
    // Mock ImageService
    $mock = Mockery::mock(ImageService::class);
    $mock->shouldReceive('delete')->times(3);
    app()->instance(ImageService::class, $mock);

    //admin user that can delete category
    $user = User::factory()->create(['role' => 'admin']);
    //create category
    $category = Category::factory()->create([
        'image' => 'test.jpg',
    ]);
    // create category editor images
    $editorImages = CkeditorImage::factory()->count(2)->create([
        'editorable_id' => $category->id,
        'editorable_type' => Category::class,
    ]);

    $response = actingAs($user)->delete(route('admin.category.destroy', $category->id));

    $response->assertRedirect(route('admin.category.index'));

    // editor images should be deleted from DB
    foreach ($editorImages as $image) {
        expect(CkeditorImage::find($image->id))->toBeNull();
    }
});
