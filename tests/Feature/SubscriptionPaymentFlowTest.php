<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\Payment;
use App\Models\Restaurant;
use App\Models\Subscription;
use App\Models\User;
use Database\Seeders\PackageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SubscriptionPaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PackageSeeder::class);
        Storage::fake('local');
    }

    public function test_owner_can_select_paid_package_and_upload_payment_proof(): void
    {
        [$owner, $restaurant] = $this->onboardedRestaurant();
        $starter = Package::where('code', 'starter')->firstOrFail();

        $this->actingAs($owner)->post(route('dashboard.subscription.select-package'), [
            'package_id' => $starter->id,
            'billing_cycle' => 'monthly',
        ])->assertSessionHasNoErrors();

        $pending = $restaurant->pendingSubscription()->first();
        $this->assertNotNull($pending);
        $this->assertSame($starter->id, $pending->package_id);

        $this->actingAs($owner)->post(route('dashboard.subscription.upload-payment'), [
            'proof' => UploadedFile::fake()->image('proof.jpg'),
            'reference_number' => 'TRX-001',
        ])->assertSessionHasNoErrors();

        $payment = Payment::sole();
        $this->assertSame(Payment::STATUS_PENDING, $payment->status);
        $this->assertSame($pending->id, $payment->subscription_id);
        Storage::disk('local')->assertExists($payment->proof_path);
    }

    public function test_admin_approving_payment_activates_subscription_and_ends_previous_one(): void
    {
        [$owner, $restaurant] = $this->onboardedRestaurant();
        $admin = User::factory()->create(['is_super_admin' => true]);
        $starter = Package::where('code', 'starter')->firstOrFail();
        $previousActive = $restaurant->activeSubscription;

        $this->actingAs($owner)->post(route('dashboard.subscription.select-package'), [
            'package_id' => $starter->id,
            'billing_cycle' => 'monthly',
        ]);
        $this->actingAs($owner)->post(route('dashboard.subscription.upload-payment'), [
            'proof' => UploadedFile::fake()->image('proof.jpg'),
        ]);

        $payment = Payment::sole();

        $this->actingAs($admin)
            ->post(route('admin.payments.approve', $payment))
            ->assertSessionHasNoErrors();

        $payment->refresh();
        $this->assertSame(Payment::STATUS_APPROVED, $payment->status);
        $this->assertSame($admin->id, $payment->verified_by);

        $subscription = $payment->subscription->fresh();
        $this->assertSame(Subscription::STATUS_ACTIVE, $subscription->status);
        $this->assertNotNull($subscription->ends_at);

        $this->assertSame(Subscription::STATUS_CANCELLED, $previousActive->fresh()->status);
    }

    public function test_admin_rejecting_payment_keeps_subscription_pending(): void
    {
        [$owner, $restaurant] = $this->onboardedRestaurant();
        $admin = User::factory()->create(['is_super_admin' => true]);
        $starter = Package::where('code', 'starter')->firstOrFail();

        $this->actingAs($owner)->post(route('dashboard.subscription.select-package'), [
            'package_id' => $starter->id,
            'billing_cycle' => 'monthly',
        ]);
        $this->actingAs($owner)->post(route('dashboard.subscription.upload-payment'), [
            'proof' => UploadedFile::fake()->image('proof.jpg'),
        ]);

        $payment = Payment::sole();

        $this->actingAs($admin)->post(route('admin.payments.reject', $payment), [
            'notes' => 'Bukti tidak jelas.',
        ])->assertSessionHasNoErrors();

        $payment->refresh();
        $this->assertSame(Payment::STATUS_REJECTED, $payment->status);
        $this->assertSame(Subscription::STATUS_PENDING, $payment->subscription->fresh()->status);
    }

    public function test_non_owner_cannot_select_package_or_upload_payment(): void
    {
        [$owner, $restaurant] = $this->onboardedRestaurant();
        $staff = User::factory()->create();
        $restaurant->users()->attach($staff->id, ['role' => 'staff', 'status' => 'active']);
        $starter = Package::where('code', 'starter')->firstOrFail();

        $this->actingAs($staff)->post(route('dashboard.subscription.select-package'), [
            'package_id' => $starter->id,
            'billing_cycle' => 'monthly',
        ])->assertForbidden();

        $this->actingAs($staff)->post(route('dashboard.subscription.upload-payment'), [
            'proof' => UploadedFile::fake()->image('proof.jpg'),
        ])->assertForbidden();
    }

    /**
     * @return array{User, Restaurant}
     */
    private function onboardedRestaurant(): array
    {
        $owner = User::factory()->create();
        $restaurant = Restaurant::create([
            'name' => 'Restoran Langganan',
            'slug' => 'restoran-langganan',
            'public_status' => 'published',
        ]);
        $restaurant->users()->attach($owner->id, ['role' => 'owner', 'status' => 'active']);
        $restaurant->subscriptions()->create([
            'package_id' => Package::free()->id,
            'billing_cycle' => 'monthly',
            'status' => Subscription::STATUS_ACTIVE,
            'starts_at' => now(),
        ]);

        return [$owner, $restaurant];
    }
}
