<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Concerns\ResolvesCurrentRestaurant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use ResolvesCurrentRestaurant;

    public function index(Request $request): View
    {
        $restaurant = $this->currentRestaurant($request);

        return view('restaurant.dashboard', [
            'restaurant' => $restaurant,
            'categoryCount' => $restaurant->categories()->count(),
            'menuItemCount' => $restaurant->menuItems()->count(),
        ]);
    }
}
