<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;

class RestaurantPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->is_super_admin ? true : null;
    }

    public function view(User $user, Restaurant $restaurant): bool
    {
        return $user->restaurants()
            ->wherePivot('status', 'active')
            ->whereKey($restaurant->id)
            ->exists();
    }

    public function update(User $user, Restaurant $restaurant): bool
    {
        return $this->view($user, $restaurant);
    }
}
