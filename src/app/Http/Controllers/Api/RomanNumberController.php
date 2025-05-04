<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RomanNumberController extends Controller
{
    public function convertToRoman(Request $request)
    {
        $number = $request->input('number');

        if (!is_numeric($number) || $number < 1 || $number > 10) {
            return response()->json(['error' => "Missing or invalid 'number' parameter."], 422);
        }

        $romanNumerals = $this->intToRoman($number);

        return response()->json(['roman' => $romanNumerals]);
    }

    private function intToRoman($num)
    {
        $n = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X'
        ];

        return $n[$num];
    }
}
