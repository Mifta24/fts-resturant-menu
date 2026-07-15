<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Concerns\ResolvesCurrentRestaurant;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRestaurantProfileRequest;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RestaurantProfileController extends Controller
{
    use ResolvesCurrentRestaurant;

    public function edit(Request $request): View
    {
        $restaurant = $this->currentRestaurant($request);
        $this->authorize('update', $restaurant);

        return view('restaurant.profile.edit', ['restaurant' => $restaurant]);
    }

    public function update(UpdateRestaurantProfileRequest $request): RedirectResponse
    {
        $restaurant = $this->currentRestaurant($request);
        $this->authorize('update', $restaurant);

        $data = $request->safe()->except(['logo', 'cover']);

        if ($request->hasFile('logo')) {
            $this->replaceFile($restaurant, 'logo_path', $request->file('logo'), 'logos');
            $data['logo_path'] = $restaurant->logo_path;
        }

        if ($request->hasFile('cover')) {
            $this->replaceFile($restaurant, 'cover_path', $request->file('cover'), 'covers');
            $data['cover_path'] = $restaurant->cover_path;
        }

        $restaurant->update($data);

        return back()->with('status', 'profile-updated');
    }

    private function replaceFile(Restaurant $restaurant, string $column, $file, string $folder): void
    {
        if ($restaurant->{$column}) {
            Storage::disk('public')->delete($restaurant->{$column});
        }

        $path = $file->store("restaurants/{$restaurant->id}/{$folder}", 'public');
        $restaurant->{$column} = $path;
    }
}
