<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MLBHelper;
use App\Http\Controllers\Controller;

class MLBController extends Controller
{
    public function index()
    {
        request()->validate([
            'date' => 'nullable|date_format:Y-m-d',
        ]);

        $date = request()->query('date', date('Y-m-d', strtotime("-1 day")));

        $result = MLBHelper::fetchGames($date);
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
}
