<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Database\Seeders\PackageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PackageSeeder::class);
    }

    /**
     * @return array<int, string>
     */
    public static function adminRoutes(): array
    {
        return [
            ['admin.dashboard'],
            ['admin.restaurants.index'],
            ['admin.packages.index'],
            ['admin.subscriptions.index'],
            ['admin.payments.index'],
        ];
    }

    #[DataProvider('adminRoutes')]
    public function test_non_super_admin_cannot_access_admin_routes(string $routeName): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route($routeName))
            ->assertForbidden();
    }

    #[DataProvider('adminRoutes')]
    public function test_super_admin_can_access_admin_routes(string $routeName): void
    {
        $admin = User::factory()->create(['is_super_admin' => true]);

        $this->actingAs($admin)
            ->get(route($routeName))
            ->assertOk();
    }

    public function test_guest_is_redirected_to_login_for_admin_routes(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_super_admin_without_restaurant_visiting_dashboard_lands_on_admin_console(): void
    {
        $admin = User::factory()->create(['is_super_admin' => true]);

        $this->actingAs($admin)
            ->get(route('dashboard.index'))
            ->assertRedirect(route('admin.dashboard'));
    }
}
