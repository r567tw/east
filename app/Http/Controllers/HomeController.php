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
        $features = [
            [
                'icon' => 'fa-solid fa-list-check',
                'title' => 'Task List',
                'description' => '每次基礎能力應該做的展示',
                'link' => route('tasks.index'),
                'action' => 'Demo',
            ],
            [
                'icon' => 'fa-solid fa-calendar-days',
                'title' => 'Event API',
                'description' => '提供活動列表、報名(會寄信)',
                'link' => route('demo.swagger'),
                'action' => '查看 API Spec',
            ],
            [
                'icon' => 'fa-solid fa-vote-yea',
                'title' => '投票網站',
                'description' => '做簡單的投票網站(Livewire)',
                'link' => route('poll'),
                'action' => 'Demo',
            ],
            [
                'icon' => 'fa-brands fa-line',
                'title' => 'Line 個人助手(不開放)',
                'description' => '串接 Line Webhook 查詢天氣、黃金、空氣品質等資訊'
            ],
        ];

        $technologies = [
            ['title' => 'Laravel', 'image' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg'],
            ['title' => 'Postgresql', 'image' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/postgresql/postgresql-original.svg'],
            ['title' => 'Redis', 'image' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/redis/redis-original.svg'],
            ['title' => 'Livewire', 'image' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/livewire/livewire-original.svg'],
            ['title' => 'Github Action', 'image' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/githubactions/githubactions-original.svg']

        ];
        return view("present", compact('features', 'technologies'));
    }

    public function swagger()
    {
        return view("swagger");
    }

    public function production()
    {
        return view("production");
    }
}
