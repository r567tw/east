<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WeatherHelper
{
    public function getWeather($locationName = '高雄市'): string
    {
        $weatherApiKey = config('app.cwb_api_key');
        $url = "https://opendata.cwa.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization={$weatherApiKey}&format=JSON&locationName={$locationName}";
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            $weatherInfo = $data['records']['location'][0]['weatherElement'][0]['time'][0]['parameter']['parameterName'];
            $rainyProbability = $data['records']['location'][0]['weatherElement'][1]['time'][0]['parameter']['parameterName'];
            return "天氣查詢結果：{$weatherInfo}\n降雨機率：{$rainyProbability}%";
        } else {
            return "天氣查詢失敗，請稍後再試。";
        }
    }
}
