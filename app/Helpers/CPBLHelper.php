<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class CPBLHelper
{
    private const SCHEDULE_PATH = '/schedule/index';

    private const DETAIL_LIST_PATH = '/home/getdetaillist';

    /**
     * Fetch and simplify CPBL games for the requested date.
     *
     * @return array<int, array<string, int|string>>
     */
    public static function fetchGames(): array
    {
        $client = self::client();
        $page = $client->get(self::SCHEDULE_PATH)->throw();
        $token = self::getVerificationToken($page->body());

        $payload = $client
            ->withHeaders([
                'RequestVerificationToken' => $token,
                'X-Requested-With' => 'XMLHttpRequest',
            ])
            ->asForm()
            ->post(self::DETAIL_LIST_PATH, [
                '__RequestVerificationToken' => $token,
            ])
            ->throw()
            ->json();

        if (! is_array($payload) || ! ($payload['Success'] ?? false)) {
            throw new \RuntimeException('CPBL API 回傳失敗。');
        }

        $games = $payload["GameADetailJson"] ?? [];
        $games = is_string($games) ? json_decode($games, true, 512, JSON_THROW_ON_ERROR) : $games;

        if (! is_array($games)) {
            throw new \RuntimeException('CPBL 每日比賽資料格式無效。');
        }

        return array_values(array_map(
            self::simplifyGame(...),
            array_filter($games, static fn(mixed $game): bool => is_array($game))
        ));
    }

    private static function client(): \Illuminate\Http\Client\PendingRequest
    {
        $baseUrl = rtrim((string) config('services.cpbl.base_url'), '/');

        return Http::baseUrl($baseUrl)
            ->withHeaders([
                'Accept' => 'application/json, text/javascript, */*; q=0.01',
                'Referer' => $baseUrl . self::SCHEDULE_PATH,
            ])
            ->withUserAgent('cpbl-scores/1.0 (+https://www.cpbl.com.tw/)')
            ->timeout((int) config('services.cpbl.timeout', 20))
            ->connectTimeout((int) config('services.cpbl.connect_timeout', 5))
            ->retry((int) config('services.cpbl.retry_times', 3), 200);
    }

    private static function getVerificationToken(string $html): string
    {
        if (preg_match('/name=["\']__RequestVerificationToken["\'][^>]+value=["\']([^"\']+)["\']/', $html, $matches) !== 1) {
            throw new \RuntimeException('官方頁面驗證 token 格式無法解析。');
        }

        return $matches[1];
    }

    /**
     * @param array<string, mixed> $game
     * @return array<string, int|string>
     */
    private static function simplifyGame(array $game): array
    {
        $gameStatus = (string) ($game['GameStatus'] ?? '');
        $status = match ($gameStatus) {
            '1' => '未開賽',
            '2' => '進行中',
            '3' => '已結束',
            '4' => '先發打序',
            '5' => '取消',
            '6' => '延賽',
            '7' => '保留',
            '8' => '比賽暫停',
            default => "未知狀態（{$gameStatus}）",
        };

        return [
            'gameNumber' => (int) ($game['GameSno'] ?? 0),
            'time' => (string) ($game['PreExeDate'] ?? ''),
            'awayTeam' => (string) ($game['VisitingTeamName'] ?? ''),
            'homeTeam' => (string) ($game['HomeTeamName'] ?? ''),
            'awayScore' => (int) ($game['VisitingTotalScore'] ?? 0),
            'homeScore' => (int) ($game['HomeTotalScore'] ?? 0),
            'field' => (string) ($game['FieldAbbe'] ?? ''),
            'status' => $status,
        ];
    }
}
