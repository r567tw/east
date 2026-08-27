<?php

namespace Tests\Unit\Helpers;

use App\Helpers\CPBLHelper;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CPBLHelperTest extends TestCase
{
    public function test_it_fetches_and_simplifies_major_league_games(): void
    {
        Http::preventStrayRequests();
        Http::fake([
            'https://www.cpbl.com.tw/schedule/index' => Http::response(
                '<input name="__RequestVerificationToken" type="hidden" value="test-token" />'
            ),
            'https://www.cpbl.com.tw/home/getdetaillist' => Http::response([
                'Success' => true,
                'GameADetailJson' => json_encode([
                    [
                        'GameSno' => '1',
                        'PreExeDate' => '18:35',
                        'VisitingTeamName' => '客隊',
                        'HomeTeamName' => '主隊',
                        'VisitingTotalScore' => '3',
                        'HomeTotalScore' => '2',
                        'FieldAbbe' => '洲際棒球場',
                        'GameStatus' => 3,
                    ],
                ], JSON_THROW_ON_ERROR),
            ]),
        ]);

        $games = CPBLHelper::fetchGames();

        $this->assertSame([
            [
                'gameNumber' => 1,
                'time' => '18:35',
                'awayTeam' => '客隊',
                'homeTeam' => '主隊',
                'awayScore' => 3,
                'homeScore' => 2,
                'field' => '洲際棒球場',
                'status' => '已結束',
            ],
        ], $games);

        Http::assertSent(function (Request $request): bool {
            return $request->url() === 'https://www.cpbl.com.tw/home/getdetaillist'
                && $request->header('RequestVerificationToken') === ['test-token']
                && $request->header('X-Requested-With') === ['XMLHttpRequest']
                && $request['__RequestVerificationToken'] === 'test-token';
        });
    }
}
