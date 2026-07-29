<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Package;
use App\Models\Restaurant;
use App\Models\Subscription;
use App\Models\User;
use Database\Seeders\PackageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuItemBulkImportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PackageSeeder::class);
    }

    public function test_owner_can_bulk_import_menu_items_creating_categories_as_needed(): void
    {
        [$user, $restaurant] = $this->subscribedRestaurant('pro');

        $data = implode("\n", [
            'Makanan | Nasi Goreng | 25000',
            'Makanan | Mie Goreng | 22000',
            'Minuman | Es Teh Manis | 5000',
        ]);

        $this->actingAs($user)
            ->post(route('dashboard.menu-items.bulk-import'), ['data' => $data])
            ->assertRedirect();

        $this->assertSame(2, $restaurant->categories()->count());
        $this->assertSame(3, $restaurant->menuItems()->count());
        $this->assertDatabaseHas('menu_items', ['name' => 'Nasi Goreng', 'price' => 25000]);
        $this->assertDatabaseHas('categories', ['name' => 'Minuman']);
    }

    public function test_bulk_import_reuses_existing_category_case_insensitively(): void
    {
        [$user, $restaurant, $category] = $this->subscribedRestaurantWithCategory('pro', 'Makanan');

        $this->actingAs($user)
            ->post(route('dashboard.menu-items.bulk-import'), [
                'data' => 'makanan | Sate Ayam | 20000',
            ])
            ->assertRedirect();

        $this->assertSame(1, $restaurant->categories()->count());
        $this->assertSame($category->id, $restaurant->menuItems()->first()->category_id);
    }

    public function test_bulk_import_skips_malformed_lines(): void
    {
        [$user, $restaurant] = $this->subscribedRestaurant('pro');

        $data = implode("\n", [
            'Makanan | Nasi Goreng | 25000',
            'baris tidak valid',
            'Makanan | Tanpa Harga |',
        ]);

        $this->actingAs($user)
            ->post(route('dashboard.menu-items.bulk-import'), ['data' => $data])
            ->assertRedirect()
            ->assertSessionHas('bulkImportCreated', 1)
            ->assertSessionHas('bulkImportSkipped', 2);

        $this->assertSame(1, $restaurant->menuItems()->count());
    }

    public function test_bulk_import_respects_menu_item_limit(): void
    {
        [$user, $restaurant, $category] = $this->subscribedRestaurantWithCategory('free', 'Makanan');

        for ($i = 0; $i < 9; $i++) {
            $restaurant->menuItems()->create([
                'category_id' => $category->id,
                'name' => "Menu {$i}",
                'price' => 10000,
                'is_available' => true,
                'sort_order' => $i,
            ]);
        }

        $this->assertSame(9, $restaurant->menuItems()->count());

        $data = implode("\n", [
            'Makanan | Menu Ke-10 | 10000',
            'Makanan | Menu Ke-11 | 10000',
        ]);

        $this->actingAs($user)
            ->post(route('dashboard.menu-items.bulk-import'), ['data' => $data])
            ->assertSessionHas('bulkImportCreated', 1)
            ->assertSessionHas('bulkImportSkipped', 1);

        $this->assertSame(10, $restaurant->menuItems()->count());
    }

    /**
     * @return array{User, Restaurant}
     */
    private function subscribedRestaurant(string $packageCode): array
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::create([
            'name' => 'Restoran '.$packageCode,
            'slug' => 'restoran-'.$packageCode.'-'.uniqid(),
            'public_status' => 'published',
        ]);
        $restaurant->users()->attach($user->id, ['role' => 'owner', 'status' => 'active']);
        $restaurant->subscriptions()->create([
            'package_id' => Package::where('code', $packageCode)->firstOrFail()->id,
            'billing_cycle' => 'monthly',
            'status' => Subscription::STATUS_ACTIVE,
            'starts_at' => now(),
        ]);

        return [$user, $restaurant];
    }

    /**
     * @return array{User, Restaurant, Category}
     */
    private function subscribedRestaurantWithCategory(string $packageCode, string $categoryName): array
    {
        [$user, $restaurant] = $this->subscribedRestaurant($packageCode);
        $category = $restaurant->categories()->create([
            'name' => $categoryName,
            'sort_order' => 0,
            'is_active' => true,
        ]);

        return [$user, $restaurant, $category];
    }
}
