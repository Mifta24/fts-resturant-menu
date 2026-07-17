<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuItemImageUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_restaurant_owner_can_create_menu_item_with_image_url(): void
    {
        [$user, $restaurant, $category] = $this->restaurantContext();
        $imageUrl = 'https://images.example.com/nasi-goreng.jpg';

        $response = $this->actingAs($user)->post(route('dashboard.menu-items.store'), [
            'category_id' => $category->id,
            'name' => 'Nasi Goreng',
            'description' => 'Nasi goreng spesial.',
            'price' => 25000,
            'image_url' => $imageUrl,
            'is_available' => true,
        ]);

        $response->assertSessionHasNoErrors();

        $menuItem = $restaurant->menuItems()->sole();
        $this->assertSame($imageUrl, $menuItem->image_url);
        $this->assertNull($menuItem->image_path);
        $this->assertSame($imageUrl, $menuItem->image_source);
    }

    public function test_image_url_must_use_http_or_https(): void
    {
        [$user, , $category] = $this->restaurantContext();

        $response = $this->actingAs($user)
            ->from(route('dashboard.menu-items.index'))
            ->post(route('dashboard.menu-items.store'), [
                'category_id' => $category->id,
                'name' => 'Menu Tidak Valid',
                'price' => 10000,
                'image_url' => 'javascript:alert(1)',
            ]);

        $response->assertRedirect(route('dashboard.menu-items.index'));
        $response->assertSessionHasErrors('image_url');
        $this->assertDatabaseCount('menu_items', 0);
    }

    public function test_public_menu_renders_external_image_url(): void
    {
        [, $restaurant, $category] = $this->restaurantContext();
        $imageUrl = 'https://images.example.com/soto-ayam.jpg';

        $restaurant->menuItems()->create([
            'category_id' => $category->id,
            'name' => 'Soto Ayam',
            'price' => 22000,
            'image_url' => $imageUrl,
            'is_available' => true,
        ]);

        $this->get(route('public-menu.show', $restaurant->slug))
            ->assertOk()
            ->assertSee($imageUrl, false);
    }

    /**
     * @return array{User, Restaurant, Category}
     */
    private function restaurantContext(): array
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::create([
            'name' => 'Restoran Test',
            'slug' => 'restoran-test',
            'public_status' => 'published',
        ]);
        $restaurant->users()->attach($user->id, [
            'role' => 'owner',
            'status' => 'active',
        ]);
        $category = $restaurant->categories()->create([
            'name' => 'Makanan',
            'sort_order' => 0,
            'is_active' => true,
        ]);

        return [$user, $restaurant, $category];
    }
}
