<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AstroHelper;
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
            $helper = new AstroHelper();
            $data = $helper->get($astroIndex);
            Cache::put("astro_{$astroIndex}", $data, now()->addHours(24));
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
