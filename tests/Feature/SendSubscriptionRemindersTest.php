<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\Restaurant;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\SubscriptionExpiringNotification;
use Database\Seeders\PackageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendSubscriptionRemindersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PackageSeeder::class);
    }

    public function test_it_notifies_owner_when_subscription_expires_soon(): void
    {
        Notification::fake();

        [$owner, $restaurant] = $this->restaurantWithOwner();
        $subscription = $this->activeSubscription($restaurant, now()->addDays(3));

        $this->artisan('subscriptions:send-reminders')->assertSuccessful();

        Notification::assertSentTo(
            $owner,
            SubscriptionExpiringNotification::class,
        );
    }

    public function test_it_notifies_owner_when_subscription_already_expired(): void
    {
        Notification::fake();

        [$owner, $restaurant] = $this->restaurantWithOwner();
        $this->activeSubscription($restaurant, now()->subDay());

        $this->artisan('subscriptions:send-reminders')->assertSuccessful();

        Notification::assertSentTo($owner, SubscriptionExpiringNotification::class);
    }

    public function test_it_does_not_notify_when_expiry_is_not_on_a_reminder_day(): void
    {
        Notification::fake();

        [, $restaurant] = $this->restaurantWithOwner();
        $this->activeSubscription($restaurant, now()->addDays(5));

        $this->artisan('subscriptions:send-reminders')->assertSuccessful();

        Notification::assertNothingSent();
    }

    public function test_it_does_not_notify_for_subscriptions_without_expiry(): void
    {
        Notification::fake();

        [, $restaurant] = $this->restaurantWithOwner();
        $restaurant->subscriptions()->create([
            'package_id' => Package::free()->id,
            'billing_cycle' => 'monthly',
            'status' => Subscription::STATUS_ACTIVE,
            'starts_at' => now(),
        ]);

        $this->artisan('subscriptions:send-reminders')->assertSuccessful();

        Notification::assertNothingSent();
    }

    /**
     * @return array{User, Restaurant}
     */
    private function restaurantWithOwner(): array
    {
        $owner = User::factory()->create();
        $restaurant = Restaurant::create([
            'name' => 'Restoran Uji',
            'slug' => 'restoran-uji-'.uniqid(),
            'public_status' => 'published',
        ]);
        $restaurant->users()->attach($owner->id, ['role' => 'owner', 'status' => 'active']);

        return [$owner, $restaurant];
    }

    private function activeSubscription(Restaurant $restaurant, $endsAt): Subscription
    {
        return $restaurant->subscriptions()->create([
            'package_id' => Package::query()->where('code', 'starter')->first()->id,
            'billing_cycle' => 'monthly',
            'status' => Subscription::STATUS_ACTIVE,
            'starts_at' => now()->subMonth(),
            'ends_at' => $endsAt,
        ]);
    }
}
