<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StreamsPaymentProof;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RejectPaymentRequest;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PaymentController extends Controller
{
    use StreamsPaymentProof;

    public function index(): View
    {
        return view('admin.payments.index', [
            'payments' => Payment::with(['restaurant', 'subscription.package'])
                ->orderByRaw("status = 'pending' desc")
                ->orderByDesc('created_at')
                ->paginate(20),
        ]);
    }

    public function show(Payment $payment): View
    {
        $payment->load(['restaurant', 'subscription.package', 'verifier']);

        return view('admin.payments.show', ['payment' => $payment]);
    }

    public function proof(Payment $payment): Response
    {
        return $this->streamProof($payment);
    }

    public function approve(Payment $payment): RedirectResponse
    {
        abort_unless($payment->status === Payment::STATUS_PENDING, 422, 'Pembayaran ini sudah diproses.');

        $subscription = $payment->subscription;
        $startsAt = now();
        $endsAt = $subscription->billing_cycle === 'yearly'
            ? $startsAt->copy()->addYear()
            : $startsAt->copy()->addMonth();

        $subscription->restaurant->activeSubscription()
            ->where('id', '!=', $subscription->id)
            ->get()
            ->each(fn ($other) => $other->update([
                'status' => Subscription::STATUS_CANCELLED,
                'cancelled_at' => now(),
            ]));

        $subscription->update([
            'status' => Subscription::STATUS_ACTIVE,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
        ]);

        $payment->update([
            'status' => Payment::STATUS_APPROVED,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return back()->with('status', 'payment-approved');
    }

    public function reject(RejectPaymentRequest $request, Payment $payment): RedirectResponse
    {
        abort_unless($payment->status === Payment::STATUS_PENDING, 422, 'Pembayaran ini sudah diproses.');

        $payment->update([
            'status' => Payment::STATUS_REJECTED,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'notes' => $request->validated('notes'),
        ]);

        return back()->with('status', 'payment-rejected');
    }
}
