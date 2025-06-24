<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RomanNumberController extends Controller
{
    public function convertToRoman(Request $request)
    {
        $number = $request->input('number');

        if (!is_numeric($number) || $number < 1 || $number > 3999) {
            return response()->json(['error' => "Missing or invalid 'number' parameter."], 422);
        }

        $roman = $this->toRoman((int)$number);

        return response()->json(['roman' => $roman]);
    }

    public function toRoman($number)
    {
        $map = [
            1000 => 'M',
            900 => 'CM',
            500 => 'D',
            400 => 'CD',
            100 => 'C',
            90 => 'XC',
            50 => 'L',
            40 => 'XL',
            10 => 'X',
            9 => 'IX',
            5 => 'V',
            4 => 'IV',
            1 => 'I'
        ];

        $result = '';

        foreach ($map as $value => $symbol) {
            while ($number >= $value) {
                $result .= $symbol;
                $number -= $value;
            }
        }

        return $result;
    }
}
