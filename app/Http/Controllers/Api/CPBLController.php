<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CPBLHelper;
use App\Http\Controllers\Controller;

class CPBLController extends Controller
{
    public function index()
    {
        $result = CPBLHelper::fetchGames();
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
}
