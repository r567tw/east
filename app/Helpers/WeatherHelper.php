<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WeatherHelper
{
    public function getWeather($locationName = '高雄市'): string
    {
        $weatherApiKey = config('app.cwb_api_key');
        $url = "https://opendata.cwa.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization={$weatherApiKey}&format=JSON&locationName={$locationName}&elementName=Wx,PoP,CI";
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();

            $weatherInfo = $this->getWeatherElement('Wx', $data);
            $rainyProbability = $this->getWeatherElement('PoP', $data);
            $comfortIndex = $this->getWeatherElement('CI', $data);

            return "天氣查詢結果：\n{$weatherInfo} \n舒適度:{$comfortIndex}\n降雨機率：{$rainyProbability}%";
        } else {
            return "天氣查詢失敗，請稍後再試。";
        }
    }

    private function getWeatherElement($name, $data): string
    {
        foreach ($data['records']['location'][0]['weatherElement'] as $element) {
            if ($element['elementName'] === $name) {
                return $element['time'][0]['parameter']['parameterName'];
            }
        }
        return '';
    }
}
