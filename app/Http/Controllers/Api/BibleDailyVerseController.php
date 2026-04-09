<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BibleDailyVerseController extends Controller
{
    public function index()
    {
        if (Cache::has('bible_daily_verse')) {
            $result = Cache::get('bible_daily_verse');
        } else {
            /** @var \Illuminate\Http\Client\Response $response */
            $response = Http::retry(3,5000)->get('https://taiwanbible.com/blog/dailyverse.jsp');
            if ($response->successful()) {
                $result = trim(str_replace(["\r","\n","\t"],"",$response->body()));
            }
        }

        return response()->json([
            'result' => $result
        ]);

    }
}
