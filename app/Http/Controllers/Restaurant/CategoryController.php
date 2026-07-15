<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Concerns\ResolvesCurrentRestaurant;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    use ResolvesCurrentRestaurant;

    public function index(Request $request): View
    {
        $restaurant = $this->currentRestaurant($request);

        return view('restaurant.categories.index', [
            'restaurant' => $restaurant,
            'categories' => $restaurant->categories()->orderBy('sort_order')->get(),
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $restaurant = $this->currentRestaurant($request);

        $restaurant->categories()->create([
            ...$request->validated(),
            'sort_order' => $restaurant->categories()->max('sort_order') + 1,
        ]);

        return back()->with('status', 'category-created');
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $restaurant = $this->currentRestaurant($request);
        $this->authorize('update', $category);
        abort_unless($category->restaurant_id === $restaurant->id, 404);

        $category->update($request->validated());

        return back()->with('status', 'category-updated');
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $restaurant = $this->currentRestaurant($request);
        $this->authorize('delete', $category);
        abort_unless($category->restaurant_id === $restaurant->id, 404);

        $category->delete();

        return back()->with('status', 'category-deleted');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $restaurant = $this->currentRestaurant($request);

        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ])['ids'];

        $categories = $restaurant->categories()->whereIn('id', $ids)->get()->keyBy('id');

        foreach ($ids as $index => $id) {
            $categories->get($id)?->update(['sort_order' => $index]);
        }

        return back()->with('status', 'category-reordered');
    }
}
