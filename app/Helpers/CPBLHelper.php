<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class CPBLHelper
{
    public static function get()
    {
        // 假設這裡有一個 API 可以獲取空氣品質數據
        $day = date('Y-m-d');
        $url = "https://www.thesportsdb.com/api/v1/json/123/eventsday.php?d={$day}&l=Chinese Professional Baseball League";

        $response = Http::retry(3, 5000)->get($url);

        $events = $response->json()['events'] ?? [];
        $teams = [
            'Uni-President Lions' => '統一獅',
            'CTBC Brothers'  => '中信兄弟',
            'Fubon Guardians' => '富邦悍將',
            'Rakuten Monkeys'   => '樂天桃猿',
            'TSG Hawks'      => '台鋼雄鷹',
            'Wei Chuan Dragons' => '味全龍',
        ];

        $result = '';
        foreach ($events as $event) {
            $homeTeam  = $teams[$event['strHomeTeam']] ?? $event['strHomeTeam'];
            $awayTeam  = $teams[$event['strAwayTeam']] ?? $event['strAwayTeam'];
            $homeScore = $event['intHomeScore'] ?? 0;
            $awayScore = $event['intAwayScore'] ?? 0;

            $result .= "{$awayTeam}vs{$homeTeam} {$awayScore}:{$homeScore}\n";
        }


        return $result;
    }
}
