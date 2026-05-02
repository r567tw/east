<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AirQualityController extends Controller
{
    //
    public function index(Request $request)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');

        if (! $lat || ! $lng) {
            return response()->json(['error' => '請提供 lat 和 lng 參數'], 400);
        }

        $airQuality = \App\Helpers\AirQualityHelper::getAirQuality((float) $lat, (float) $lng);

        return response()->json(['air_quality' => $airQuality]);
    }
}
