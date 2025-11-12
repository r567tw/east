<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;

class ShortRedirectController extends Controller
{
    //
    public function redirect($code)
    {
        $shortUrl = ShortUrl::where('short', $code)->first();

        if ($shortUrl) {
            if ($shortUrl->expires_at && $shortUrl->expires_at->isPast()) {
                return abort(410, 'Short link has expired');
            }
            // Todo: Increment the visit count
            $shortUrl->increment('visit_count');
            // Redirect to the original URL
            return redirect()->to($shortUrl->url);
        }

        return abort(404, 'Short link not found');
    }
}
