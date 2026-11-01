<?php

namespace App\Listeners\Line;

use App\Clients\AirQualityClient;
use App\Clients\AstroClient;
use App\Clients\GeminiAiClient;
use App\Clients\LineClient;
use App\Clients\WeatherClient;
use App\Events\Line\CommandEvent;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ReplyToLineCommand
{
    public function __construct(private readonly LineClient $lineClient) {}

    public function handle(CommandEvent $event): void
    {
        $command = trim(str_replace('／', '/', mb_strtolower($event->command)));
        $user = $event->userId === null
            ? null
            : User::where('line_user_id', $event->userId)->first();

        $result = $this->processCommand(trim(mb_substr($command, 1)), $user);
        $this->lineClient->sendMessage($event->replyToken, $result);
    }

    private function processCommand(string $command, ?User $user): string
    {
        return match (true) {
            in_array($command, ['天氣', '空氣', '空汙', '空氣品質', 'air', '位置'], true) => $this->processLocationCommand($command, $user),
            str_starts_with($command, '運勢') => $this->processAstroCommand($command),
            str_starts_with($command, '精簡') => GeminiAiClient::summarizeText(str_replace('精簡', '', $command)) ?: '無法精簡該段文字。',
            str_starts_with($command, '翻譯') => GeminiAiClient::translate(str_replace('翻譯', '', $command)) ?: '無法翻譯該段文字。',
            default => match ($command) {
                'version' => 'Laravel Version: '.app()->version()."\nPHP Version: ".PHP_VERSION."\nReference: https://php.watch/versions",
                'help' => "可用指令：\n/天氣 - 查詢天氣\n/空氣 - 查詢空汙\n/位置 - 查詢已連結帳號的經緯度和城市",
                default => "未知指令：{$command}，請使用 /help 查看可用指令。",
            },
        };
    }

    private function processLocationCommand(string $command, ?User $user): string
    {
        if ($user === null) {
            return '請先綁定 LINE 帳號。';
        }

        if (empty($user->location)) {
            return '請先設定你的位置。';
        }

        return match ($command) {
            '天氣' => (new WeatherClient)->getWeather($user->location),
            '空氣', '空汙', '空氣品質', 'air' => AirQualityClient::getAirQuality($user->lat, $user->lng),
            '位置' => "你的經緯度: {$user->lat},{$user->lng}\n城市：{$user->location}",
        };
    }

    private function processAstroCommand(string $command): string
    {
        $astroName = trim(str_replace(['運勢:', '運勢'], '', $command)) ?: '射手座';
        $astroIndex = config('astro.chinese')[$astroName] ?? null;
        if ($astroIndex === null) {
            return "未知的星座名稱：{$astroName}。目前尚未支援";
        }

        return Cache::has("astro_{$astroIndex}")
            ? Cache::get("astro_{$astroIndex}")
            : (new AstroClient)->get($astroIndex);
    }
}
