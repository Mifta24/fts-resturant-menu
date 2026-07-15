<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RestaurantUser extends Pivot
{
    protected $table = 'restaurant_users';

    public $incrementing = true;

    protected function casts(): array
    {
        return [
            'role' => 'string',
            'status' => 'string',
        ];
    }
}
