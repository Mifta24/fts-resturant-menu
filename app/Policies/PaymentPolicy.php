<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->is_super_admin ? true : null;
    }

    public function view(User $user, Payment $payment): bool
    {
        return $user->restaurants()
            ->wherePivot('status', 'active')
            ->whereKey($payment->restaurant_id)
            ->exists();
    }
}
