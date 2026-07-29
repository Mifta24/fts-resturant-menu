<?php

namespace App\Services;

use App\Models\Package;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlanLimitService
{
    public function canCreateCategory(Restaurant $restaurant): bool
    {
        $limit = $this->package($restaurant)->category_limit;

        return $limit === null || $restaurant->categories()->count() < $limit;
    }

    public function canCreateMenuItem(Restaurant $restaurant): bool
    {
        $limit = $this->package($restaurant)->menu_limit;

        return $limit === null || $restaurant->menuItems()->count() < $limit;
    }

    public function hasStatistics(Restaurant $restaurant): bool
    {
        return (bool) $this->package($restaurant)->has_statistics;
    }

    public function hasStorageRoom(Restaurant $restaurant, int $incomingBytes): bool
    {
        $limitMb = $this->package($restaurant)->storage_limit_mb;

        if ($limitMb === null) {
            return true;
        }

        $usedBytes = $this->storageUsedBytes($restaurant);

        return ($usedBytes + $incomingBytes) <= ($limitMb * 1024 * 1024);
    }

    public function limitReachedResponse(Request $request, string $message): RedirectResponse|JsonResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'upgrade_required' => true,
            ], 422);
        }

        return back()->withErrors(['plan_limit' => $message]);
    }

    private function package(Restaurant $restaurant): Package
    {
        return $restaurant->currentPackage() ?? Package::free() ?? new Package([
            'menu_limit' => 10,
            'category_limit' => 3,
            'storage_limit_mb' => 50,
        ]);
    }

    private function storageUsedBytes(Restaurant $restaurant): int
    {
        $prefix = "restaurants/{$restaurant->id}";
        $bytes = 0;

        foreach (['public', 'local'] as $disk) {
            foreach (Storage::disk($disk)->allFiles($prefix) as $file) {
                $bytes += Storage::disk($disk)->size($file);
            }
        }

        return $bytes;
    }
}
