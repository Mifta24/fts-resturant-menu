<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateRestaurantStatusRequest;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    public function index(): View
    {
        return view('admin.restaurants.index', [
            'restaurants' => Restaurant::with('activeSubscription.package')
                ->withCount(['categories', 'menuItems'])
                ->orderByDesc('created_at')
                ->paginate(20),
        ]);
    }

    public function show(Restaurant $restaurant): View
    {
        $restaurant->load(['activeSubscription.package', 'subscriptions.package', 'payments.subscription.package', 'users']);

        return view('admin.restaurants.show', [
            'restaurant' => $restaurant,
        ]);
    }

    public function updateStatus(UpdateRestaurantStatusRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $restaurant->update($request->validated());

        return back()->with('status', 'restaurant-status-updated');
    }
}
