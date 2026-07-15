<?php

namespace App\Services;

use App\Models\Restaurant;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\Result\ResultInterface;

class QrCodeService
{
    public function forRestaurant(Restaurant $restaurant): ResultInterface
    {
        $url = route('public-menu.show', $restaurant->slug);

        return (new Builder(
            data: $url,
            size: 480,
            margin: 16,
        ))->build();
    }
}
