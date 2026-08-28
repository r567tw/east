<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CPBLHelper;
use App\Http\Controllers\Controller;

class CPBLController extends Controller
{
    public function index()
    {
        request()->validate([
            'date' => 'nullable|date_format:Y-m-d',
            'kind' => 'nullable|string|in:A,D'
        ]);

        $date = request()->query('date', date('Y-m-d'));
        $kindCode = request()->query('kind', 'A');

        $result = CPBLHelper::fetchGames($date, $kindCode);
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
}
