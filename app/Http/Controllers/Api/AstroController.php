<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class AstroController extends Controller
{
    //
    public function show($name)
    {
        $astroMap = config('astro.chinese');

        if (! array_key_exists($name, $astroMap)) {
            return response()->json(['error' => 'Invalid'], 400);
        }

        $astroIndex = $astroMap[$name];

        $data = Cache::get("astro_{$astroIndex}");

        if (! $data) {
            return response()->json(['error' => 'No data found'], 404);
        }

        [$title, $all, $love,, $career, $money] = explode("\r\n", $data);

        return response()->json(['result' => [
            'title' => $title,
            'all' => $all,
            'love' => $love,
            'career' => $career,
            'money' => $money,
        ]]);
    }
}
