<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Package;
use App\Models\Restaurant;
use App\Models\Subscription;
use App\Models\User;
use Database\Seeders\PackageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageUploadValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PackageSeeder::class);
        Storage::fake('public');
    }

    public function test_disguised_non_image_file_is_rejected(): void
    {
        [$user, $restaurant, $category] = $this->restaurantContext();

        $file = UploadedFile::fake()->create('shell.jpg', 10, 'text/plain');

        $response = $this->actingAs($user)->post(route('dashboard.menu-items.store'), [
            'category_id' => $category->id,
            'name' => 'Menu Berbahaya',
            'price' => 10000,
            'image' => $file,
        ]);

        $response->assertSessionHasErrors('image');
        $this->assertDatabaseCount('menu_items', 0);
    }

    public function test_oversized_image_is_rejected(): void
    {
        [$user, $restaurant, $category] = $this->restaurantContext();

        $file = UploadedFile::fake()->image('big.jpg')->size(6000);

        $response = $this->actingAs($user)->post(route('dashboard.menu-items.store'), [
            'category_id' => $category->id,
            'name' => 'Menu Besar',
            'price' => 10000,
            'image' => $file,
        ]);

        $response->assertSessionHasErrors('image');
        $this->assertDatabaseCount('menu_items', 0);
    }

    public function test_valid_image_is_resized_and_stored_under_generated_filename(): void
    {
        [$user, $restaurant, $category] = $this->restaurantContext();

        $file = UploadedFile::fake()->image('photo.jpg', 2000, 2000);

        $response = $this->actingAs($user)->post(route('dashboard.menu-items.store'), [
            'category_id' => $category->id,
            'name' => 'Menu Foto',
            'price' => 10000,
            'image' => $file,
        ]);

        $response->assertSessionHasNoErrors();

        $menuItem = $restaurant->menuItems()->sole();
        $this->assertNotNull($menuItem->image_path);
        $this->assertStringNotContainsString('photo', $menuItem->image_path);

        Storage::disk('public')->assertExists($menuItem->image_path);

        $fullPath = Storage::disk('public')->path($menuItem->image_path);
        [$width, $height] = getimagesize($fullPath);
        $this->assertLessThanOrEqual(1600, $width);
        $this->assertLessThanOrEqual(1600, $height);
    }

    /**
     * @return array{User, Restaurant, Category}
     */
    private function restaurantContext(): array
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::create([
            'name' => 'Restoran Upload',
            'slug' => 'restoran-upload',
            'public_status' => 'published',
        ]);
        $restaurant->users()->attach($user->id, ['role' => 'owner', 'status' => 'active']);
        $restaurant->subscriptions()->create([
            'package_id' => Package::free()->id,
            'billing_cycle' => 'monthly',
            'status' => Subscription::STATUS_ACTIVE,
            'starts_at' => now(),
        ]);
        $category = $restaurant->categories()->create([
            'name' => 'Makanan',
            'sort_order' => 0,
            'is_active' => true,
        ]);

        return [$user, $restaurant, $category];
    }
}
