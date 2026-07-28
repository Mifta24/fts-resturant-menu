<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Concerns\ResolvesCurrentRestaurant;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRestaurantProfileRequest;
use App\Models\Restaurant;
use App\Services\ImageProcessingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RestaurantProfileController extends Controller
{
    use ResolvesCurrentRestaurant;

    public function __construct(private ImageProcessingService $imageProcessingService) {}

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
            $this->replaceFile($restaurant, 'logo_path', $request->file('logo'), 'logos', 800);
            $data['logo_path'] = $restaurant->logo_path;
        }

        if ($request->hasFile('cover')) {
            $this->replaceFile($restaurant, 'cover_path', $request->file('cover'), 'covers', 1920);
            $data['cover_path'] = $restaurant->cover_path;
        }

        $restaurant->update($data);

        return back()->with('status', 'profile-updated');
    }

    private function replaceFile(Restaurant $restaurant, string $column, UploadedFile $file, string $folder, int $maxDimension): void
    {
        if ($restaurant->{$column}) {
            Storage::disk('public')->delete($restaurant->{$column});
        }

        $restaurant->{$column} = $this->imageProcessingService->process(
            $file,
            "restaurants/{$restaurant->id}/{$folder}",
            $maxDimension,
        );
    }
}
