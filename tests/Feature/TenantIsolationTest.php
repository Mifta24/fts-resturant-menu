<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Restaurant;
use App\Models\Subscription;
use App\Models\User;
use Database\Seeders\PackageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PackageSeeder::class);
    }

    public function test_owner_cannot_update_another_restaurants_category(): void
    {
        [$ownerA] = $this->restaurantWithCategoryAndMenuItem('a');
        [, $restaurantB, $categoryB] = $this->restaurantWithCategoryAndMenuItem('b');

        $this->actingAs($ownerA)
            ->patch(route('dashboard.categories.update', $categoryB), ['name' => 'Diretas'])
            ->assertForbidden();

        $this->assertDatabaseHas('categories', ['id' => $categoryB->id, 'name' => $categoryB->name]);
    }

    public function test_owner_cannot_delete_another_restaurants_category(): void
    {
        [$ownerA] = $this->restaurantWithCategoryAndMenuItem('a');
        [, , $categoryB] = $this->restaurantWithCategoryAndMenuItem('b');

        $this->actingAs($ownerA)
            ->delete(route('dashboard.categories.destroy', $categoryB))
            ->assertForbidden();

        $this->assertDatabaseHas('categories', ['id' => $categoryB->id]);
    }

    public function test_owner_cannot_update_or_delete_another_restaurants_menu_item(): void
    {
        [$ownerA] = $this->restaurantWithCategoryAndMenuItem('a');
        [, , , $menuItemB] = $this->restaurantWithCategoryAndMenuItem('b');

        $this->actingAs($ownerA)
            ->get(route('dashboard.menu-items.edit', $menuItemB))
            ->assertForbidden();

        $this->actingAs($ownerA)
            ->patch(route('dashboard.menu-items.update', $menuItemB), [
                'category_id' => $menuItemB->category_id,
                'name' => 'Diretas',
                'price' => 1000,
            ])
            ->assertForbidden();

        $this->actingAs($ownerA)
            ->delete(route('dashboard.menu-items.destroy', $menuItemB))
            ->assertForbidden();

        $this->assertDatabaseHas('menu_items', ['id' => $menuItemB->id, 'name' => $menuItemB->name]);
    }

    public function test_owner_cannot_view_another_restaurants_payment_proof(): void
    {
        [$ownerA] = $this->restaurantWithCategoryAndMenuItem('a');
        [, $restaurantB] = $this->restaurantWithCategoryAndMenuItem('b');

        $subscriptionB = $restaurantB->subscriptions()->create([
            'package_id' => Package::free()->id,
            'billing_cycle' => 'monthly',
            'status' => Subscription::STATUS_PENDING,
            'starts_at' => now(),
        ]);

        $paymentB = Payment::create([
            'subscription_id' => $subscriptionB->id,
            'restaurant_id' => $restaurantB->id,
            'amount' => 49000,
            'method' => 'bank_transfer',
            'proof_path' => 'restaurants/'.$restaurantB->id.'/payments/fake.jpg',
            'status' => Payment::STATUS_PENDING,
        ]);

        $this->actingAs($ownerA)
            ->get(route('dashboard.subscription.payments.proof', $paymentB))
            ->assertForbidden();
    }

    /**
     * @return array{User, Restaurant, Category, MenuItem}
     */
    private function restaurantWithCategoryAndMenuItem(string $suffix): array
    {
        $owner = User::factory()->create();
        $restaurant = Restaurant::create([
            'name' => "Restoran {$suffix}",
            'slug' => "restoran-{$suffix}",
            'public_status' => 'published',
        ]);
        $restaurant->users()->attach($owner->id, ['role' => 'owner', 'status' => 'active']);
        $restaurant->subscriptions()->create([
            'package_id' => Package::free()->id,
            'billing_cycle' => 'monthly',
            'status' => Subscription::STATUS_ACTIVE,
            'starts_at' => now(),
        ]);

        $category = $restaurant->categories()->create([
            'name' => "Kategori {$suffix}",
            'sort_order' => 0,
            'is_active' => true,
        ]);

        $menuItem = $restaurant->menuItems()->create([
            'category_id' => $category->id,
            'name' => "Menu {$suffix}",
            'price' => 15000,
            'is_available' => true,
            'sort_order' => 0,
        ]);

        return [$owner, $restaurant, $category, $menuItem];
    }
}
