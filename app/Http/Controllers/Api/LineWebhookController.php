<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LineWebhookService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LineWebhookController extends Controller
{
    public function __construct(private readonly LineWebhookService $lineWebhookService) {}

    public function handle(Request $request): Response
    {
        $request->validate([
            'events' => ['present', 'array'],
            'events.*' => ['array'],
            'events.*.type' => ['required', 'string'],
        ]);

        $this->lineWebhookService->handle($request->input('events'));

        return response('OK', 200);
    }
}
