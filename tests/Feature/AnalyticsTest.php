<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\Restaurant;
use App\Models\Subscription;
use App\Models\User;
use Database\Seeders\PackageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PackageSeeder::class);
    }

    public function test_visiting_public_menu_records_a_view(): void
    {
        $restaurant = $this->publishedRestaurant('a');

        $this->get(route('public-menu.show', $restaurant->slug))->assertOk();

        $this->assertDatabaseCount('menu_views', 1);
        $this->assertDatabaseHas('menu_views', ['restaurant_id' => $restaurant->id]);
    }

    public function test_owner_without_statistics_package_sees_upgrade_prompt(): void
    {
        [$owner] = $this->restaurantWithOwnerAndPackage('a', 'free');

        $response = $this->actingAs($owner)->get(route('dashboard.analytics.index'));

        $response->assertOk();
        $response->assertSee('Upgrade');
    }

    public function test_owner_with_statistics_package_sees_view_counts(): void
    {
        [$owner, $restaurant] = $this->restaurantWithOwnerAndPackage('a', 'business');

        $restaurant->menuViews()->create();
        $restaurant->menuViews()->create();
        $restaurant->menuViews()->create();

        $response = $this->actingAs($owner)->get(route('dashboard.analytics.index'));

        $response->assertOk();
        $response->assertSee('Total sepanjang waktu: 3');
    }

    private function publishedRestaurant(string $suffix): Restaurant
    {
        return Restaurant::create([
            'name' => "Restoran {$suffix}",
            'slug' => "restoran-{$suffix}",
            'public_status' => 'published',
        ]);
    }

    /**
     * @return array{User, Restaurant}
     */
    private function restaurantWithOwnerAndPackage(string $suffix, string $packageCode): array
    {
        $owner = User::factory()->create();
        $restaurant = $this->publishedRestaurant($suffix);
        $restaurant->users()->attach($owner->id, ['role' => 'owner', 'status' => 'active']);
        $restaurant->subscriptions()->create([
            'package_id' => Package::where('code', $packageCode)->firstOrFail()->id,
            'billing_cycle' => 'monthly',
            'status' => Subscription::STATUS_ACTIVE,
            'starts_at' => now(),
        ]);

        return [$owner, $restaurant];
    }
}
