<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Concerns\ResolvesCurrentRestaurant;
use App\Http\Controllers\Controller;
use App\Http\Requests\BulkImportMenuItemsRequest;
use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Services\ImageProcessingService;
use App\Services\PlanLimitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    use ResolvesCurrentRestaurant;

    public function __construct(
        private PlanLimitService $planLimitService,
        private ImageProcessingService $imageProcessingService,
    ) {}

    public function index(Request $request): View
    {
        $restaurant = $this->currentRestaurant($request);

        return view('restaurant.menu-items.index', [
            'restaurant' => $restaurant,
            'categories' => $restaurant->categories()->orderBy('sort_order')->get(),
            'menuItems' => $restaurant->menuItems()->with('category')->orderBy('sort_order')->get(),
        ]);
    }

    public function store(StoreMenuItemRequest $request): RedirectResponse|JsonResponse
    {
        $restaurant = $this->currentRestaurant($request);
        $this->ensureCategoryBelongsToRestaurant($restaurant->id, (int) $request->validated('category_id'));

        if (! $this->planLimitService->canCreateMenuItem($restaurant)) {
            return $this->planLimitService->limitReachedResponse($request, 'Batas jumlah menu pada paket Anda sudah tercapai.');
        }

        if ($request->hasFile('image') && ! $this->planLimitService->hasStorageRoom($restaurant, $request->file('image')->getSize())) {
            return $this->planLimitService->limitReachedResponse($request, 'Kapasitas penyimpanan pada paket Anda sudah penuh.');
        }

        $data = $request->safe()->except(['image', 'image_url']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->imageProcessingService->process(
                $request->file('image'),
                "restaurants/{$restaurant->id}/menu-items",
                maxDimension: 1600,
            );
            $data['image_url'] = null;
        } elseif ($request->filled('image_url')) {
            $data['image_path'] = null;
            $data['image_url'] = $request->validated('image_url');
        }

        $restaurant->menuItems()->create([
            ...$data,
            'sort_order' => $restaurant->menuItems()->max('sort_order') + 1,
        ]);

        return back()->with('status', 'menu-item-created');
    }

    public function bulkImport(BulkImportMenuItemsRequest $request): RedirectResponse
    {
        $restaurant = $this->currentRestaurant($request);

        $created = 0;
        $skipped = 0;

        foreach (preg_split('/\r\n|\r|\n/', $request->validated('data')) as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $parts = array_map('trim', explode('|', $line));

            if (count($parts) !== 3 || $parts[0] === '' || $parts[1] === '') {
                $skipped++;

                continue;
            }

            [$categoryName, $name, $priceRaw] = $parts;
            $price = (int) preg_replace('/[^0-9]/', '', $priceRaw);

            if ($price <= 0) {
                $skipped++;

                continue;
            }

            $category = $this->findOrCreateCategory($restaurant, $categoryName);

            if (! $category || ! $this->planLimitService->canCreateMenuItem($restaurant)) {
                $skipped++;

                continue;
            }

            $restaurant->menuItems()->create([
                'category_id' => $category->id,
                'name' => $name,
                'price' => $price,
                'is_available' => true,
                'sort_order' => $restaurant->menuItems()->max('sort_order') + 1,
            ]);

            $created++;
        }

        return back()->with('status', 'menu-items-bulk-imported')
            ->with('bulkImportCreated', $created)
            ->with('bulkImportSkipped', $skipped);
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

        $data = $request->safe()->except(['image', 'image_url']);

        if ($request->hasFile('image')) {
            $this->deleteStoredImage($menuItem);
            $data['image_path'] = $this->imageProcessingService->process(
                $request->file('image'),
                "restaurants/{$restaurant->id}/menu-items",
                maxDimension: 1600,
            );
            $data['image_url'] = null;
        } elseif ($request->filled('image_url')) {
            $this->deleteStoredImage($menuItem);
            $data['image_path'] = null;
            $data['image_url'] = $request->validated('image_url');
        } elseif ($request->exists('image_url') && $menuItem->image_url) {
            $data['image_url'] = null;
        }

        $menuItem->update($data);

        return redirect()->route('dashboard.menu-items.index')->with('status', 'menu-item-updated');
    }

    public function destroy(Request $request, MenuItem $menuItem): RedirectResponse
    {
        $restaurant = $this->currentRestaurant($request);
        $this->authorize('delete', $menuItem);
        abort_unless($menuItem->restaurant_id === $restaurant->id, 404);

        $this->deleteStoredImage($menuItem);

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

    private function findOrCreateCategory(Restaurant $restaurant, string $name): ?Category
    {
        $category = $restaurant->categories()->whereRaw('LOWER(name) = ?', [mb_strtolower($name)])->first();

        if ($category) {
            return $category;
        }

        if (! $this->planLimitService->canCreateCategory($restaurant)) {
            return null;
        }

        return $restaurant->categories()->create([
            'name' => $name,
            'is_active' => true,
            'sort_order' => $restaurant->categories()->max('sort_order') + 1,
        ]);
    }

    private function ensureCategoryBelongsToRestaurant(int $restaurantId, int $categoryId): void
    {
        abort_unless(
            Category::where('id', $categoryId)->where('restaurant_id', $restaurantId)->exists(),
            422,
            'Invalid category for this restaurant.'
        );
    }

    private function deleteStoredImage(MenuItem $menuItem): void
    {
        if ($menuItem->image_path) {
            Storage::disk('public')->delete($menuItem->image_path);
        }
    }
}
