<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Concerns\ResolvesCurrentRestaurant;
use App\Http\Controllers\Concerns\StreamsPaymentProof;
use App\Http\Controllers\Controller;
use App\Http\Requests\SelectPackageRequest;
use App\Http\Requests\UploadPaymentRequest;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Restaurant;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    use ResolvesCurrentRestaurant, StreamsPaymentProof;

    public function show(Request $request): View
    {
        $restaurant = $this->currentRestaurant($request);

        return view('restaurant.subscription.show', [
            'restaurant' => $restaurant,
            'activeSubscription' => $restaurant->activeSubscription()->with('package')->first(),
            'pendingSubscription' => $restaurant->pendingSubscription()->with('package')->first(),
            'packages' => Package::where('is_active', true)->orderBy('monthly_price')->get(),
            'payments' => $restaurant->payments()->with('subscription.package')->latest()->get(),
            'isOwner' => $restaurant->pivot->role === 'owner',
        ]);
    }

    public function selectPackage(SelectPackageRequest $request): RedirectResponse
    {
        $restaurant = $this->currentRestaurant($request);
        $this->ensureIsOwner($restaurant);

        $package = Package::where('is_active', true)->findOrFail($request->validated('package_id'));
        $billingCycle = $request->validated('billing_cycle');

        $restaurant->pendingSubscription?->update([
            'status' => Subscription::STATUS_CANCELLED,
            'cancelled_at' => now(),
        ]);

        if ($package->code === Package::CODE_FREE) {
            $restaurant->activeSubscription?->update([
                'status' => Subscription::STATUS_CANCELLED,
                'cancelled_at' => now(),
            ]);

            $restaurant->subscriptions()->create([
                'package_id' => $package->id,
                'billing_cycle' => $billingCycle,
                'status' => Subscription::STATUS_ACTIVE,
                'starts_at' => now(),
            ]);

            return back()->with('status', 'subscription-activated');
        }

        $restaurant->subscriptions()->create([
            'package_id' => $package->id,
            'billing_cycle' => $billingCycle,
            'status' => Subscription::STATUS_PENDING,
            'starts_at' => now(),
        ]);

        return back()->with('status', 'subscription-pending');
    }

    public function uploadPayment(UploadPaymentRequest $request): RedirectResponse
    {
        $restaurant = $this->currentRestaurant($request);
        $this->ensureIsOwner($restaurant);

        $subscription = $restaurant->pendingSubscription()->with('package')->first();
        abort_unless($subscription, 422, 'Tidak ada paket yang menunggu pembayaran.');

        $file = $request->file('proof');
        $filename = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
        $path = Storage::disk('local')->putFileAs("restaurants/{$restaurant->id}/payments", $file, $filename);

        Payment::create([
            'subscription_id' => $subscription->id,
            'restaurant_id' => $restaurant->id,
            'amount' => $subscription->package->priceFor($subscription->billing_cycle),
            'method' => 'bank_transfer',
            'reference_number' => $request->validated('reference_number'),
            'proof_path' => $path,
            'status' => Payment::STATUS_PENDING,
            'paid_at' => now(),
        ]);

        return back()->with('status', 'payment-uploaded');
    }

    public function downloadProof(Payment $payment): Response
    {
        $this->authorize('view', $payment);

        return $this->streamProof($payment);
    }

    private function ensureIsOwner(Restaurant $restaurant): void
    {
        abort_unless($restaurant->pivot->role === 'owner', 403, 'Hanya pemilik restoran yang dapat mengelola langganan.');
    }
}
