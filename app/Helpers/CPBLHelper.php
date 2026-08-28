<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class CPBLHelper
{
    private const SCHEDULE_PATH = '/schedule/index';

    private const GAMES_PATH = '/schedule/getgamedatas';

    /**
     * Fetch and simplify CPBL games for the requested date.
     *
     * @return array<int, array<string, int|string>>
     */
    public static function fetchGames(string $targetDate = '',string $kindCode = 'A'): array
    {
        $baseUrl = rtrim((string) config('services.cpbl.base_url', 'http://www.cpbl.com.tw'), '/');
        $targetDate = $targetDate !== '' ? $targetDate : date('Y-m-d');
        $baseUrl = rtrim((string) config('services.cpbl.base_url', 'https://www.cpbl.com.tw'), '/');
        $page = Http::retry((int) config('services.cpbl.retry_times', 3), 200)
            ->timeout((int) config('services.cpbl.timeout', 20))
            ->connectTimeout((int) config('services.cpbl.connect_timeout', 5))
            ->get($baseUrl.self::SCHEDULE_PATH)
            ->throw();
        $token = self::getVerificationToken($page->body());

        $payload = Http::retry((int) config('services.cpbl.retry_times', 3), 200)
            ->timeout((int) config('services.cpbl.timeout', 20))
            ->connectTimeout((int) config('services.cpbl.connect_timeout', 5))
            ->acceptJson()
            ->withHeaders([
                'RequestVerificationToken' => $token,
                'X-Requested-With' => 'XMLHttpRequest',
            ])
            ->asForm()
            ->post($baseUrl.self::GAMES_PATH, [
                'calendar' => substr($targetDate, 0, 4).'/01/01',
                'location' => '',
                'kindCode' => $kindCode,
            ])
            ->throw()
            ->json();

        if (! is_array($payload) || ! ($payload['Success'] ?? false)) {
            throw new \RuntimeException('CPBL API 回傳失敗。');
        }

        $games = $payload['GameDatas'] ?? [];
        $games = is_string($games) ? json_decode($games, true, 512, JSON_THROW_ON_ERROR) : $games;

        if (! is_array($games)) {
            throw new \RuntimeException('CPBL 每日比賽資料格式無效。');
        }

        return array_values(array_map(
            self::simplifyGame(...),
            array_filter(
                $games,
                static fn (mixed $game): bool => is_array($game)
                    && str_starts_with((string) ($game['GameDate'] ?? ''), $targetDate)
            )
        ));
    }

    private static function getVerificationToken(string $html): string
    {
        $endpointStart = strpos($html, self::GAMES_PATH);

        if ($endpointStart === false) {
            throw new \RuntimeException('找不到官方 API 驗證 token，可能是網站格式已變更。');
        }

        $endpointBlock = substr($html, $endpointStart, 5000);

        if (preg_match('/RequestVerificationToken:\s*[\'\"]([^\'\"]+)[\'\"]/', $endpointBlock, $matches) !== 1) {
            throw new \RuntimeException('官方 API 驗證 token 格式無法解析。');
        }

        return $matches[1];
    }

    /**
     * @param  array<string, mixed>  $game
     * @return array<string, int|string>
     */
    private static function simplifyGame(array $game): array
    {
        $gameStatus = (string) ($game['GameResult'] ?? '');
        $status = match ($gameStatus) {
            '1' => '延賽',
            '2' => '保留',
            '4' => '取消',
            '0' => '已結束',
            default => "",
        };

        if ($status == "" && $game["IsPlayBall"] == "N"){
            $status = "未開賽";
        } elseif ($status == "" && $game["IsPlayBall"] == "Y"){
            $status = "進行中";
        }

        return [
            'gameNumber' => (int) ($game['GameSno'] ?? 0),
            'time' => (string) ($game['PreExeDate'] ?? ''),
            'awayTeam' => (string) ($game['VisitingTeamName'] ?? ''),
            'homeTeam' => (string) ($game['HomeTeamName'] ?? ''),
            'awayScore' => (int) ($game['VisitingScore'] ?? 0),
            'homeScore' => (int) ($game['HomeScore'] ?? 0),
            'field' => (string) ($game['FieldAbbe'] ?? ''),
            'status' => $status
        ];
    }
}
