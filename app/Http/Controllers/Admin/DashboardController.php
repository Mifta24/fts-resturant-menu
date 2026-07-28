<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Restaurant;
use App\Models\Subscription;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $activeSubscriptions = Subscription::with('package')
            ->where('status', Subscription::STATUS_ACTIVE)
            ->get();

        $estimatedMonthlyRevenue = $activeSubscriptions->sum(function (Subscription $subscription) {
            if (! $subscription->package) {
                return 0;
            }

            return $subscription->billing_cycle === 'yearly'
                ? $subscription->package->priceFor('yearly') / 12
                : $subscription->package->priceFor('monthly');
        });

        return view('admin.dashboard', [
            'totalRestaurants' => Restaurant::count(),
            'activeSubscriptions' => $activeSubscriptions->count(),
            'pendingPayments' => Payment::where('status', Payment::STATUS_PENDING)->count(),
            'estimatedMonthlyRevenue' => $estimatedMonthlyRevenue,
        ]);
    }
}
