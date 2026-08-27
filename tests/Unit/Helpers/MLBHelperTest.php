<?php

namespace Tests\Unit\Helpers;

use App\Helpers\MLBHelper;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MLBHelperTest extends TestCase
{
    public function test_it_fetches_and_simplifies_major_league_games(): void
    {
        Http::preventStrayRequests();
        Http::fake([
            'https://statsapi.mlb.com/api/v1/schedule*' => Http::response([
                'dates' => [[
                    'games' => [[
                        'gamePk' => 123,
                        'gameDate' => '2026-08-27T10:05:00Z',
                        'teams' => [
                            'away' => ['team' => ['name' => 'Away Team'], 'score' => 4],
                            'home' => ['team' => ['name' => 'Home Team'], 'score' => 2],
                        ],
                        'venue' => ['name' => 'MLB Stadium'],
                        'linescore' => ['currentInningOrdinal' => '9th', 'isTopInning' => false],
                        'status' => ['abstractGameState' => 'Final', 'detailedState' => 'Final'],
                    ]],
                ]],
            ]),
        ]);

        $games = MLBHelper::fetchGames('2026-08-27');

        $this->assertSame([
            [
                'gameNumber' => 123,
                'time' => '2026-08-27 18:05:00 Taipei',
                'awayTeam' => 'Away Team',
                'homeTeam' => 'Home Team',
                'awayScore' => 4,
                'homeScore' => 2,
                'field' => 'MLB Stadium',
                'inning' => 'Final',
                'status' => 'Final',
            ],
        ], $games);

        Http::assertSent(function (Request $request): bool {
            return $request->url() === 'https://statsapi.mlb.com/api/v1/schedule?sportId=1&date=2026-08-27&hydrate=venue%2Cteam%2Clinescore';
        });
    }
}
