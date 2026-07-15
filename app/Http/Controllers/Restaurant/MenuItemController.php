<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Concerns\ResolvesCurrentRestaurant;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    use ResolvesCurrentRestaurant;

    public function index(Request $request): View
    {
        $restaurant = $this->currentRestaurant($request);

        return view('restaurant.menu-items.index', [
            'restaurant' => $restaurant,
            'categories' => $restaurant->categories()->orderBy('sort_order')->get(),
            'menuItems' => $restaurant->menuItems()->with('category')->orderBy('sort_order')->get(),
        ]);
    }

    public function store(StoreMenuItemRequest $request): RedirectResponse
    {
        $restaurant = $this->currentRestaurant($request);
        $this->ensureCategoryBelongsToRestaurant($restaurant->id, (int) $request->validated('category_id'));

        $data = $request->safe()->except(['image']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store("restaurants/{$restaurant->id}/menu-items", 'public');
        }

        $restaurant->menuItems()->create([
            ...$data,
            'sort_order' => $restaurant->menuItems()->max('sort_order') + 1,
        ]);

        return back()->with('status', 'menu-item-created');
    }

    public function edit(Request $request, MenuItem $menuItem): View
    {
        $restaurant = $this->currentRestaurant($request);
        $this->authorize('update', $menuItem);
        abort_unless($menuItem->restaurant_id === $restaurant->id, 404);

        return view('restaurant.menu-items.edit', [
            'restaurant' => $restaurant,
            'menuItem' => $menuItem,
            'categories' => $restaurant->categories()->orderBy('sort_order')->get(),
        ]);
    }

    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem): RedirectResponse
    {
        $restaurant = $this->currentRestaurant($request);
        $this->authorize('update', $menuItem);
        abort_unless($menuItem->restaurant_id === $restaurant->id, 404);
        $this->ensureCategoryBelongsToRestaurant($restaurant->id, (int) $request->validated('category_id'));

        $data = $request->safe()->except(['image']);

        if ($request->hasFile('image')) {
            if ($menuItem->image_path) {
                Storage::disk('public')->delete($menuItem->image_path);
            }
            $data['image_path'] = $request->file('image')->store("restaurants/{$restaurant->id}/menu-items", 'public');
        }

        $menuItem->update($data);

        return redirect()->route('dashboard.menu-items.index')->with('status', 'menu-item-updated');
    }

    public function destroy(Request $request, MenuItem $menuItem): RedirectResponse
    {
        $restaurant = $this->currentRestaurant($request);
        $this->authorize('delete', $menuItem);
        abort_unless($menuItem->restaurant_id === $restaurant->id, 404);

        if ($menuItem->image_path) {
            Storage::disk('public')->delete($menuItem->image_path);
        }

        $menuItem->delete();

        return back()->with('status', 'menu-item-deleted');
    }

    public function toggleAvailability(Request $request, MenuItem $menuItem): RedirectResponse
    {
        $restaurant = $this->currentRestaurant($request);
        $this->authorize('update', $menuItem);
        abort_unless($menuItem->restaurant_id === $restaurant->id, 404);

        $menuItem->update(['is_available' => ! $menuItem->is_available]);

        return back()->with('status', 'menu-item-availability-updated');
    }

    private function ensureCategoryBelongsToRestaurant(int $restaurantId, int $categoryId): void
    {
        abort_unless(
            \App\Models\Category::where('id', $categoryId)->where('restaurant_id', $restaurantId)->exists(),
            422,
            'Invalid category for this restaurant.'
        );
    }
}
