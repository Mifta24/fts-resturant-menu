<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use Database\Seeders\PackageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OnboardingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PackageSeeder::class);
    }

    public function test_unverified_user_is_redirected_to_verification_notice(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->get(route('dashboard.onboarding.create'))
            ->assertRedirect(route('verification.notice'));
    }

    public function test_verified_user_without_restaurant_is_redirected_to_onboarding_from_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard.index'))
            ->assertRedirect(route('dashboard.onboarding.create'));
    }

    public function test_onboarding_creates_restaurant_membership_and_free_subscription(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('dashboard.onboarding.store'), [
            'name' => 'Warung Baru',
            'description' => 'Deskripsi warung.',
        ]);

        $response->assertRedirect(route('dashboard.index'));

        $restaurant = $user->fresh()->currentRestaurant();

        $this->assertNotNull($restaurant);
        $this->assertSame('Warung Baru', $restaurant->name);
        $this->assertTrue($user->isOwnerOf($restaurant));

        $subscription = $restaurant->activeSubscription;
        $this->assertNotNull($subscription);
        $this->assertSame(Subscription::STATUS_ACTIVE, $subscription->status);
        $this->assertSame(Package::CODE_FREE, $subscription->package->code);
    }

    public function test_already_onboarded_user_visiting_onboarding_redirects_to_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('dashboard.onboarding.store'), [
            'name' => 'Warung Baru',
        ]);

        $this->actingAs($user)
            ->get(route('dashboard.onboarding.create'))
            ->assertRedirect(route('dashboard.index'));
    }
}
