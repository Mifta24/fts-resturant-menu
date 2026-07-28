<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSubscriptionStatusRequest;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(): View
    {
        return view('admin.subscriptions.index', [
            'subscriptions' => Subscription::with(['restaurant', 'package'])
                ->orderByDesc('created_at')
                ->paginate(20),
        ]);
    }

    public function update(UpdateSubscriptionStatusRequest $request, Subscription $subscription): RedirectResponse
    {
        $data = $request->validated();

        if (in_array($data['status'], [Subscription::STATUS_CANCELLED, Subscription::STATUS_EXPIRED], true)) {
            $data['cancelled_at'] = now();
        }

        $subscription->update($data);

        return back()->with('status', 'subscription-updated');
    }
}
