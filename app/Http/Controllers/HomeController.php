<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function home()
    {
        return view("home");
    }

    public function index()
    {
        return response()->json([
            "message" => "Hello World"
        ]);
    }

    public function poll()
    {
        return view("poll");
    }

    public function testing()
    {
        return response()->json([
            "message" => "Testing endpoint"
        ]);
    }

    public function goldPrice()
    {
        $goldHelper = new \App\Helpers\gold();
        [$goldSellPrice, $goldBuyPrice] = $goldHelper::getGoldPrice();

        return  response()->json([
            'gold_buy_price' => $goldBuyPrice,
            'gold_sell_price' => $goldSellPrice,
        ]);
    }
}
