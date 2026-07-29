<?php

namespace Tests\Feature;

use App\Models\Feedback;
use App\Models\Package;
use App\Models\Restaurant;
use App\Models\Subscription;
use App\Models\User;
use Database\Seeders\PackageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PackageSeeder::class);
    }

    public function test_restaurant_owner_can_submit_feedback(): void
    {
        [$owner, $restaurant] = $this->restaurantWithOwner('a');

        $this->actingAs($owner)
            ->post(route('dashboard.feedback.store'), [
                'type' => Feedback::TYPE_BUG,
                'message' => 'Tombol simpan tidak berfungsi.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('feedback', [
            'restaurant_id' => $restaurant->id,
            'user_id' => $owner->id,
            'type' => Feedback::TYPE_BUG,
            'status' => Feedback::STATUS_NEW,
        ]);
    }

    public function test_restaurant_owner_only_sees_own_feedback(): void
    {
        [$ownerA, $restaurantA] = $this->restaurantWithOwner('a');
        [, $restaurantB] = $this->restaurantWithOwner('b');

        $restaurantA->feedback()->create([
            'user_id' => $ownerA->id,
            'type' => Feedback::TYPE_SUGGESTION,
            'message' => 'Feedback A',
            'status' => Feedback::STATUS_NEW,
        ]);

        $restaurantB->feedback()->create([
            'user_id' => $ownerA->id,
            'type' => Feedback::TYPE_SUGGESTION,
            'message' => 'Feedback B',
            'status' => Feedback::STATUS_NEW,
        ]);

        $response = $this->actingAs($ownerA)->get(route('dashboard.feedback.index'));

        $response->assertSee('Feedback A');
        $response->assertDontSee('Feedback B');
    }

    public function test_super_admin_can_update_feedback_status(): void
    {
        $admin = User::factory()->create(['is_super_admin' => true]);
        [$owner, $restaurant] = $this->restaurantWithOwner('a');

        $feedback = $restaurant->feedback()->create([
            'user_id' => $owner->id,
            'type' => Feedback::TYPE_SUGGESTION,
            'message' => 'Tambahkan mode gelap.',
            'status' => Feedback::STATUS_NEW,
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.feedback.update', $feedback), [
                'status' => Feedback::STATUS_RESOLVED,
                'admin_note' => 'Sudah ditambahkan.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('feedback', [
            'id' => $feedback->id,
            'status' => Feedback::STATUS_RESOLVED,
            'admin_note' => 'Sudah ditambahkan.',
        ]);
    }

    public function test_owner_cannot_update_another_restaurants_feedback(): void
    {
        [$ownerA] = $this->restaurantWithOwner('a');
        [$ownerB, $restaurantB] = $this->restaurantWithOwner('b');

        $feedbackB = $restaurantB->feedback()->create([
            'user_id' => $ownerB->id,
            'type' => Feedback::TYPE_SUGGESTION,
            'message' => 'Feedback B',
            'status' => Feedback::STATUS_NEW,
        ]);

        $this->actingAs($ownerA)
            ->patch(route('admin.feedback.update', $feedbackB), [
                'status' => Feedback::STATUS_RESOLVED,
            ])
            ->assertForbidden();
    }

    /**
     * @return array{User, Restaurant}
     */
    private function restaurantWithOwner(string $suffix): array
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

        return [$owner, $restaurant];
    }
}
