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

class PlanLimitTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PackageSeeder::class);
    }

    public function test_free_tier_restaurant_is_blocked_after_reaching_menu_item_limit(): void
    {
        [$user, $restaurant, $category] = $this->subscribedRestaurant('free');

        for ($i = 0; $i < 10; $i++) {
            $restaurant->menuItems()->create([
                'category_id' => $category->id,
                'name' => "Menu {$i}",
                'price' => 10000,
                'is_available' => true,
                'sort_order' => $i,
            ]);
        }

        $response = $this->actingAs($user)->post(route('dashboard.menu-items.store'), [
            'category_id' => $category->id,
            'name' => 'Menu Ke-11',
            'price' => 10000,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('plan_limit');
        $this->assertSame(10, $restaurant->menuItems()->count());
    }

    public function test_free_tier_restaurant_is_blocked_via_json_with_upgrade_flag(): void
    {
        [$user, $restaurant, $category] = $this->subscribedRestaurant('free');

        for ($i = 0; $i < 3; $i++) {
            $restaurant->categories()->create([
                'name' => "Kategori {$i}",
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }

        $response = $this->actingAs($user)
            ->postJson(route('dashboard.categories.store'), [
                'name' => 'Kategori Ke-4',
            ]);

        $response->assertStatus(422);
        $response->assertJson(['upgrade_required' => true]);
    }

    public function test_pro_tier_restaurant_is_never_blocked_on_menu_items(): void
    {
        [$user, $restaurant, $category] = $this->subscribedRestaurant('pro');

        for ($i = 0; $i < 15; $i++) {
            $restaurant->menuItems()->create([
                'category_id' => $category->id,
                'name' => "Menu {$i}",
                'price' => 10000,
                'is_available' => true,
                'sort_order' => $i,
            ]);
        }

        $response = $this->actingAs($user)->post(route('dashboard.menu-items.store'), [
            'category_id' => $category->id,
            'name' => 'Menu Ke-16',
            'price' => 10000,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertSame(16, $restaurant->menuItems()->count());
    }

    /**
     * @return array{User, Restaurant, Category}
     */
    private function subscribedRestaurant(string $packageCode): array
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::create([
            'name' => 'Restoran '.$packageCode,
            'slug' => 'restoran-'.$packageCode,
            'public_status' => 'published',
        ]);
        $restaurant->users()->attach($user->id, ['role' => 'owner', 'status' => 'active']);
        $category = $restaurant->categories()->create([
            'name' => 'Makanan',
            'sort_order' => 0,
            'is_active' => true,
        ]);

        $restaurant->subscriptions()->create([
            'package_id' => Package::where('code', $packageCode)->firstOrFail()->id,
            'billing_cycle' => 'monthly',
            'status' => Subscription::STATUS_ACTIVE,
            'starts_at' => now(),
        ]);

        return [$user, $restaurant, $category];
    }
}
