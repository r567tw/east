<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GoldPriceController extends Controller
{
    //
    public function index()
    {
        $goldBuyPrice = intval(Cache::get('gold_buy_price', 0));
        $goldSellPrice = intval(Cache::get('gold_sell_price', 0));

        return  response()->json([
            'currency' => 'TWD',
            'gold_buy_price' => $goldBuyPrice,
            'gold_sell_price' => $goldSellPrice,
        ]);
    }
}
