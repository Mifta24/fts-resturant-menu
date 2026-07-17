<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoRestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@ftsmenu.test'],
            [
                'name' => 'FTS Admin',
                'password' => Hash::make('password'),
                'is_super_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->createDemoRestaurant(
            ownerEmail: 'demo1@ftsmenu.test',
            ownerName: 'Pemilik Warung Sederhana',
            restaurantName: 'Warung Sederhana FTS',
            description: 'Warung makan rumahan dengan menu harian khas Nusantara.',
            categories: [
                'Makanan Utama' => [
                    ['name' => 'Nasi Goreng Spesial', 'price' => 25000, 'description' => 'Nasi goreng dengan telur, ayam suwir, dan kerupuk.', 'image_url' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&w=800&q=80'],
                    ['name' => 'Ayam Bakar', 'price' => 28000, 'description' => 'Ayam bakar bumbu kecap dengan lalapan.', 'image_url' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?auto=format&fit=crop&w=800&q=80'],
                    ['name' => 'Soto Ayam', 'price' => 22000, 'description' => 'Soto ayam kuah bening dengan suwiran ayam.', 'image_url' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&w=800&q=80'],
                ],
                'Minuman' => [
                    ['name' => 'Es Teh Manis', 'price' => 6000, 'description' => null, 'image_url' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=800&q=80'],
                    ['name' => 'Es Jeruk', 'price' => 8000, 'description' => null, 'image_url' => 'https://images.unsplash.com/photo-1600271886742-f049cd451bba?auto=format&fit=crop&w=800&q=80'],
                ],
            ]
        );

        $this->createDemoRestaurant(
            ownerEmail: 'demo2@ftsmenu.test',
            ownerName: 'Pemilik Kedai Kopi Nusantara',
            restaurantName: 'Kedai Kopi Nusantara',
            description: 'Kedai kopi santai dengan pilihan kopi lokal dan camilan.',
            categories: [
                'Kopi' => [
                    ['name' => 'Kopi Tubruk', 'price' => 15000, 'description' => 'Kopi hitam khas Nusantara.', 'image_url' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=800&q=80'],
                    ['name' => 'Es Kopi Susu Gula Aren', 'price' => 20000, 'description' => 'Kopi susu dengan gula aren asli.', 'image_url' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=800&q=80'],
                ],
                'Camilan' => [
                    ['name' => 'Pisang Goreng', 'price' => 12000, 'description' => 'Pisang goreng crispy dengan topping cokelat.', 'image_url' => 'https://images.unsplash.com/photo-1603833665858-e61d17a86224?auto=format&fit=crop&w=800&q=80'],
                    ['name' => 'Roti Bakar', 'price' => 15000, 'description' => 'Roti bakar dengan pilihan selai.', 'image_url' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?auto=format&fit=crop&w=800&q=80'],
                ],
            ]
        );

        $this->command?->info('Demo login: admin@ftsmenu.test / demo1@ftsmenu.test / demo2@ftsmenu.test — password: password');
    }

    private function createDemoRestaurant(
        string $ownerEmail,
        string $ownerName,
        string $restaurantName,
        string $description,
        array $categories,
    ): void {
        $owner = User::firstOrCreate(
            ['email' => $ownerEmail],
            [
                'name' => $ownerName,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $restaurant = Restaurant::firstOrCreate(
            ['name' => $restaurantName],
            [
                'slug' => Restaurant::generateUniqueSlug($restaurantName),
                'description' => $description,
                'whatsapp' => '6281234567890',
                'address' => 'Jl. Contoh No. 1, Jakarta',
                'public_status' => 'published',
            ]
        );

        $restaurant->users()->syncWithoutDetaching([
            $owner->id => ['role' => 'owner', 'status' => 'active'],
        ]);

        $categorySort = 0;
        foreach ($categories as $categoryName => $menuItems) {
            $category = $restaurant->categories()->updateOrCreate(
                ['name' => $categoryName],
                [
                    'sort_order' => $categorySort++,
                    'is_active' => true,
                ]
            );

            $menuSort = 0;
            foreach ($menuItems as $item) {
                $restaurant->menuItems()->updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'name' => $item['name'],
                    ],
                    [
                        'description' => $item['description'] ?? null,
                        'price' => $item['price'],
                        'image_url' => $item['image_url'] ?? null,
                        'is_available' => true,
                        'sort_order' => $menuSort++,
                    ]
                );
            }
        }
    }
}
