<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Free',
                'code' => 'free',
                'monthly_price' => 0,
                'yearly_price' => null,
                'menu_limit' => 10,
                'category_limit' => 3,
                'storage_limit_mb' => 50,
                'team_limit' => 1,
                'has_statistics' => false,
                'has_custom_theme' => false,
                'remove_branding' => false,
                'language_limit' => 1,
            ],
            [
                'name' => 'Starter',
                'code' => 'starter',
                'monthly_price' => 49000,
                'yearly_price' => 499000,
                'menu_limit' => 30,
                'category_limit' => 10,
                'storage_limit_mb' => 200,
                'team_limit' => 2,
                'has_statistics' => false,
                'has_custom_theme' => false,
                'remove_branding' => false,
                'language_limit' => 1,
            ],
            [
                'name' => 'Business',
                'code' => 'business',
                'monthly_price' => 99000,
                'yearly_price' => 999000,
                'menu_limit' => 100,
                'category_limit' => null,
                'storage_limit_mb' => 500,
                'team_limit' => 5,
                'has_statistics' => true,
                'has_custom_theme' => true,
                'remove_branding' => true,
                'language_limit' => 1,
            ],
            [
                'name' => 'Pro',
                'code' => 'pro',
                'monthly_price' => 149000,
                'yearly_price' => 1499000,
                'menu_limit' => null,
                'category_limit' => null,
                'storage_limit_mb' => 2000,
                'team_limit' => 10,
                'has_statistics' => true,
                'has_custom_theme' => true,
                'remove_branding' => true,
                'language_limit' => 2,
            ],
        ];

        foreach ($packages as $package) {
            Package::query()->updateOrCreate(
                ['code' => $package['code']],
                [...$package, 'is_active' => true]
            );
        }
    }
}
