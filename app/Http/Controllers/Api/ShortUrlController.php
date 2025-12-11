<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShortUrlResource;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    //
    public function index()
    {
        $urls = ShortUrl::where('expires_at', '>', now())->paginate(10);

        return ShortUrlResource::collection($urls);
    }

    public function store(Request $request)
    {
        // Logic to create a new short URL
        // Validate the request and save the short URL
        $request->validate([
            'url' => 'required|url|max:2048',
            'code' => 'nullable|string|unique:short_urls,short',
            'expires_at' => 'date|after:now',
        ]);

        if ($request->has('expires_at')) {
            $expiresAt = $request->input('expires_at');
        } else {
            $expiresAt = now()->addDay(); // Default expiration: 1 day
        }

        if ($request->has('code')) {
            $shortCode = $request->input('code');
        } else {
            $shortCode = Str::random(6); // Generate a random short code
            while (ShortUrl::where('short', $shortCode)->where('expires_at', '>', now())->exists()) {
                $shortCode = Str::random(6); // Regenerate if the code already exists
            }
        }

        $shortUrl = ShortUrl::create([
            'url' => $request->url,
            'short' => $shortCode, // Generate a random short code
            'expires_at' => $expiresAt, // Set expiration date
            'user_id' => $request->user()->id,
        ]);

        return new ShortUrlResource($shortUrl);
    }
}
