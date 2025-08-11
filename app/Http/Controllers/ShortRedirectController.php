<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;

class ShortRedirectController extends Controller
{
    //
    public function redirect($code)
    {
        $shortUrl = ShortUrl::where('short', $code)->where('expires_at', '>', now())->first();

        if ($shortUrl) {
            // Todo: Increment the visit count
            // Redirect to the original URL
            return redirect()->to($shortUrl->url);
        }

        return abort(404, 'Short link not found');
    }
}
