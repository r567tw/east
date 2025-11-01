<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function home()
    {
        return view("home");
    }

    public function poll()
    {
        return view("poll");
    }

    public function present()
    {
        $all = json_decode(file_get_contents(storage_path('present.json')), true);
        $features = $all['features'] ?? [];
        $technologies = $all['technologies'] ?? [];
        $monitors = $all['monitors'] ?? [];
        return view("present", compact('features', 'technologies', 'monitors'));
    }

    public function portal()
    {
        return view("portal");
    }

    public function demo()
    {
        return view("demo");
    }

    public function production()
    {
        return view("production");
    }

    public function changelog()
    {
        $logs = json_decode(file_get_contents(storage_path('changelog.json')), true);
        usort($logs, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        return view("changelog", compact('logs'));
    }
}
