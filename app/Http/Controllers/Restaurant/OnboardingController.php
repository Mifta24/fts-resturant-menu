<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOnboardingRequest;
use App\Models\Package;
use App\Models\Restaurant;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        if ($request->user()->currentRestaurant()) {
            return redirect()->route('dashboard.index');
        }

        return view('restaurant.onboarding.create');
    }

    public function store(StoreOnboardingRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->currentRestaurant()) {
            return redirect()->route('dashboard.index');
        }

        $data = $request->validated();

        DB::transaction(function () use ($data, $user) {
            $lockedUser = $user->newQuery()->whereKey($user->id)->lockForUpdate()->first();

            if ($lockedUser->currentRestaurant()) {
                return;
            }

            $restaurant = Restaurant::create([
                'name' => $data['name'],
                'slug' => Restaurant::generateUniqueSlug($data['name']),
                'description' => $data['description'] ?? null,
                'phone' => $data['phone'] ?? null,
                'public_status' => 'draft',
            ]);

            $restaurant->users()->attach($user->id, ['role' => 'owner', 'status' => 'active']);

            if ($freePackage = Package::free()) {
                $restaurant->subscriptions()->create([
                    'package_id' => $freePackage->id,
                    'billing_cycle' => 'monthly',
                    'status' => Subscription::STATUS_ACTIVE,
                    'starts_at' => now(),
                ]);
            }
        });

        return redirect()->route('dashboard.index')->with('status', 'restaurant-onboarded');
    }
}
