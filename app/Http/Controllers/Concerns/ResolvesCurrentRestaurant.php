<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait ResolvesCurrentRestaurant
{
    protected function currentRestaurant(Request $request): Restaurant
    {
        $restaurant = $request->user()->currentRestaurant();

        if (! $restaurant) {
            throw new HttpException(403, 'No restaurant is linked to this account yet.');
        }

        return $restaurant;
    }
}
