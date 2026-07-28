<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;

class SubscriptionPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->is_super_admin ? true : null;
    }

    public function view(User $user, Subscription $subscription): bool
    {
        return $user->restaurants()
            ->wherePivot('status', 'active')
            ->whereKey($subscription->restaurant_id)
            ->exists();
    }
}
