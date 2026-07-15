<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Concerns\ResolvesCurrentRestaurant;
use App\Http\Controllers\Controller;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class QrCodeController extends Controller
{
    use ResolvesCurrentRestaurant;

    public function __construct(private QrCodeService $qrCodeService) {}

    public function show(Request $request): View
    {
        $restaurant = $this->currentRestaurant($request);

        return view('restaurant.qr-code.show', [
            'restaurant' => $restaurant,
            'publicUrl' => route('public-menu.show', $restaurant->slug),
        ]);
    }

    public function download(Request $request): Response
    {
        $restaurant = $this->currentRestaurant($request);
        $result = $this->qrCodeService->forRestaurant($restaurant);

        return response($result->getString(), 200, [
            'Content-Type' => $result->getMimeType(),
            'Content-Disposition' => 'attachment; filename="qr-'.$restaurant->slug.'.png"',
        ]);
    }
}
