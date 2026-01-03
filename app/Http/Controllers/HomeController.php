<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function present()
    {
        $content = File::json(storage_path('present.json'));

        return view('present', compact('content'));
    }

    public function demo()
    {
        return view('demo');
    }

    public function changelog()
    {
        $logs = json_decode(file_get_contents(storage_path('changelog.json')), true);
        usort($logs, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return view('changelog', compact('logs'));
    }
}
