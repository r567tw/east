<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LineWebhookMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 驗證簽名（選擇性，但建議做）
        $channelSecret = config('line.line_channel_secret');
        $signature = $request->header('X-Line-Signature');

        $body = $request->getContent();
        $hash = base64_encode(hash_hmac('sha256', $body, $channelSecret, true));

        if ($signature !== $hash) {
            abort(400, 'Invalid signature');
        }

        return $next($request);
    }
}
