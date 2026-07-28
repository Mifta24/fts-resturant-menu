<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Payment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

trait StreamsPaymentProof
{
    protected function streamProof(Payment $payment): Response
    {
        abort_unless($payment->proof_path && Storage::disk('local')->exists($payment->proof_path), 404);

        return Storage::disk('local')->response($payment->proof_path);
    }
}
