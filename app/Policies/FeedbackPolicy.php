<?php

namespace App\Policies;

use App\Models\Feedback;
use App\Models\User;

class FeedbackPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->is_super_admin ? true : null;
    }

    public function view(User $user, Feedback $feedback): bool
    {
        return $user->restaurants()
            ->wherePivot('status', 'active')
            ->whereKey($feedback->restaurant_id)
            ->exists();
    }
}
