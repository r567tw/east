<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    //
    public function getOurLocation(Request $request)
    {
        // Validate the request data
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        // Nominatim 反向地理編碼 API
        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $location = $this->getLocationFromCoordinates($lat, $lng);
        if ($location === null) {
            return response()->json(['error' => 'Unable to fetch location data'], 500);
        }

        return response()->json([
            'location' => $location
        ]);
    }

    public function setOurLocation(Request $request)
    {
        // Validate the request data
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        // Nominatim 反向地理編碼 API
        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $user = request()->user();
        $user->lat = $lat;
        $user->lng = $lng;
        $user->save();

        $location = $this->getLocationFromCoordinates($lat, $lng);
        if ($location === null) {
            return response()->json(['error' => 'Unable to fetch location data'], 500);
        }
        // Update the user's location
        $user->location = $location;
        $user->save();

        return response()->json([
            'message' => 'Location updated successfully',
        ]);
    }

    private function getLocationFromCoordinates($lat, $lng)
    {
        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$lat}&lon={$lng}&zoom=10&addressdetails=1";

        $response = Http::withHeaders(
            ['User-Agent' => 'Custom User Agent']
        )->get($url);

        if ($response->failed()) {
            return null;
        }

        $data = $response->json();

        return $data['address']['city'] ?? $data['address']['county'] ?? null;
    }
}
