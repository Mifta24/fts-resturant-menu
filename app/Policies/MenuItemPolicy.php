<?php

namespace App\Policies;

use App\Models\MenuItem;
use App\Models\User;

class MenuItemPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->is_super_admin ? true : null;
    }

    public function view(User $user, MenuItem $menuItem): bool
    {
        return $user->restaurants()
            ->wherePivot('status', 'active')
            ->whereKey($menuItem->restaurant_id)
            ->exists();
    }

    public function update(User $user, MenuItem $menuItem): bool
    {
        return $this->view($user, $menuItem);
    }

    public function delete(User $user, MenuItem $menuItem): bool
    {
        return $this->view($user, $menuItem);
    }
}
