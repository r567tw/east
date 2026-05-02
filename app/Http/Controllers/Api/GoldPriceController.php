<?php

namespace App\Http\Controllers\Api;

use App\Helpers\GoldPriceHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GoldPriceController extends Controller
{
    //
    public function index()
    {
        $goldBuyPrice = intval(Cache::get('gold_buy_price', 0));
        $goldSellPrice = intval(Cache::get('gold_sell_price', 0));

        try {
            if ($goldBuyPrice === 0 || $goldSellPrice === 0) {
                [$goldSellPrice, $goldBuyPrice] = (new GoldPriceHelper)->getGoldPrice();
                Cache::put('gold_buy_price', $goldBuyPrice, now()->addMinutes(30));
                Cache::put('gold_sell_price', $goldSellPrice, now()->addMinutes(30));
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch gold price: '.$e->getMessage());

            return response()->json([
                'error' => 'Unable to fetch gold price at the moment. Please try again later.',
            ], 503);
        }

        return response()->json([
            'currency' => 'TWD',
            'gold_buy_price' => $goldBuyPrice,
            'gold_sell_price' => $goldSellPrice,
        ]);
    }
}
