<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRestaurantOnboarded
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->currentRestaurant()) {
            return redirect()->route('dashboard.onboarding.create');
        }

        return $next($request);
    }
}
