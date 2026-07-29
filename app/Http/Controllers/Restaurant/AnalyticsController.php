<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Concerns\ResolvesCurrentRestaurant;
use App\Http\Controllers\Controller;
use App\Services\PlanLimitService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    use ResolvesCurrentRestaurant;

    public function __construct(private PlanLimitService $planLimitService) {}

    public function index(Request $request): View
    {
        $restaurant = $this->currentRestaurant($request);
        $hasStatistics = $this->planLimitService->hasStatistics($restaurant);

        if (! $hasStatistics) {
            return view('restaurant.analytics.index', [
                'restaurant' => $restaurant,
                'hasStatistics' => false,
            ]);
        }

        $views = $restaurant->menuViews();

        $dailyViews = $restaurant->menuViews()
            ->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        return view('restaurant.analytics.index', [
            'restaurant' => $restaurant,
            'hasStatistics' => true,
            'totalViews' => (clone $views)->count(),
            'viewsToday' => (clone $views)->whereDate('created_at', now()->toDateString())->count(),
            'viewsLast7Days' => (clone $views)->where('created_at', '>=', now()->subDays(6)->startOfDay())->count(),
            'viewsLast30Days' => (clone $views)->where('created_at', '>=', now()->subDays(29)->startOfDay())->count(),
            'dailyViews' => $dailyViews,
        ]);
    }
}
