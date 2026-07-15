<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\View\View;

class PublicMenuController extends Controller
{
    public function show(string $restaurantSlug): View
    {
        $restaurant = Restaurant::where('slug', $restaurantSlug)->firstOrFail();

        abort_if(! $restaurant->isPublished(), 404);

        $categories = $restaurant->categories()
            ->where('is_active', true)
            ->with(['menuItems' => function ($query) {
                $query->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        return view('public-menu.show', [
            'restaurant' => $restaurant,
            'categories' => $categories,
        ]);
    }
}
