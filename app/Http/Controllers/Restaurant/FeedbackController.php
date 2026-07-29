<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Concerns\ResolvesCurrentRestaurant;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeedbackRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    use ResolvesCurrentRestaurant;

    public function index(Request $request): View
    {
        $restaurant = $this->currentRestaurant($request);

        return view('restaurant.feedback.index', [
            'restaurant' => $restaurant,
            'feedback' => $restaurant->feedback()->orderByDesc('created_at')->paginate(10),
        ]);
    }

    public function store(StoreFeedbackRequest $request): RedirectResponse
    {
        $restaurant = $this->currentRestaurant($request);

        $restaurant->feedback()->create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return back()->with('status', 'feedback-created');
    }
}
