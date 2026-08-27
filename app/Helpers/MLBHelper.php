<?php

namespace App\Helpers;

use Carbon\CarbonImmutable;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class MLBHelper
{
    private const SCHEDULE_PATH = '/api/v1/schedule';

    /**
     * Fetch and simplify MLB games for the requested date.
     *
     * @return array<int, array<string, int|string>>
     */
    public static function fetchGames(string $targetDate): array
    {
        $payload = self::client()
            ->get(self::SCHEDULE_PATH, [
                'sportId' => 1,
                'date' => $targetDate,
                'hydrate' => 'venue,team,linescore',
            ])
            ->throw()
            ->json();

        if (! is_array($payload)) {
            throw new \RuntimeException('MLB API 回傳資料格式無效。');
        }

        $games = [];
        foreach ($payload['dates'] ?? [] as $scheduleDate) {
            if (is_array($scheduleDate) && is_array($scheduleDate['games'] ?? null)) {
                $games = [...$games, ...$scheduleDate['games']];
            }
        }

        return array_values(array_map(
            self::simplifyGame(...),
            array_filter($games, static fn (mixed $game): bool => is_array($game))
        ));
    }

    private static function client(): PendingRequest
    {
        $baseUrl = rtrim((string) config('services.mlb.base_url'), '/');

        return Http::baseUrl($baseUrl)
            ->acceptJson()
            ->withUserAgent('mlb-scores/1.0')
            ->timeout((int) config('services.mlb.timeout', 20))
            ->connectTimeout((int) config('services.mlb.connect_timeout', 5))
            ->retry((int) config('services.mlb.retry_times', 3), 200);
    }

    /**
     * @param array<string, mixed> $game
     * @return array<string, int|string>
     */
    private static function simplifyGame(array $game): array
    {
        $status = is_array($game['status'] ?? null) ? $game['status'] : [];
        $abstractStatus = (string) ($status['abstractGameState'] ?? '');

        return [
            'gameNumber' => (int) ($game['gamePk'] ?? 0),
            'time' => self::gameTime($game),
            'awayTeam' => self::teamName($game, 'away'),
            'homeTeam' => self::teamName($game, 'home'),
            'awayScore' => self::teamScore($game, 'away'),
            'homeScore' => self::teamScore($game, 'home'),
            'field' => (string) ((is_array($game['venue'] ?? null) ? $game['venue']['name'] ?? '' : '')),
            'inning' => self::inningStatus($game, $abstractStatus),
            'status' => (string) ($status['detailedState'] ?? $abstractStatus ?: '未知'),
        ];
    }

    /** @param array<string, mixed> $game */
    private static function teamName(array $game, string $side): string
    {
        $teams = is_array($game['teams'] ?? null) ? $game['teams'] : [];
        $teamData = is_array($teams[$side] ?? null) ? $teams[$side] : [];
        $team = is_array($teamData['team'] ?? null) ? $teamData['team'] : [];

        return (string) ($team['name'] ?? '');
    }

    /** @param array<string, mixed> $game */
    private static function teamScore(array $game, string $side): int|string
    {
        $teams = is_array($game['teams'] ?? null) ? $game['teams'] : [];
        $teamData = is_array($teams[$side] ?? null) ? $teams[$side] : [];
        $score = $teamData['score'] ?? null;

        return $score === null ? '-' : (int) $score;
    }

    /** @param array<string, mixed> $game */
    private static function gameTime(array $game): string
    {
        $rawTime = (string) ($game['gameDate'] ?? '');

        if ($rawTime === '') {
            return '';
        }

        return CarbonImmutable::parse($rawTime)
            ->setTimezone('Asia/Taipei')
            ->format('Y-m-d H:i:s').' Taipei';
    }

    /** @param array<string, mixed> $game */
    private static function inningStatus(array $game, string $abstractStatus): string
    {
        if ($abstractStatus === 'Preview') {
            return 'Not started';
        }

        if ($abstractStatus === 'Final') {
            return 'Final';
        }

        $linescore = is_array($game['linescore'] ?? null) ? $game['linescore'] : [];
        $ordinal = $linescore['currentInningOrdinal'] ?? null;

        if (! $ordinal) {
            return 'Unknown';
        }

        return (string) $ordinal.' '.(! empty($linescore['isTopInning']) ? 'Top' : 'Bottom');
    }
}
