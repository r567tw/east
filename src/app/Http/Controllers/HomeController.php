<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view("home");
    }

    public function index()
    {
        return response()->json([
            "message" => "Hello World"
        ]);
    }

    public function poll()
    {
        return view("poll");
    }
}
