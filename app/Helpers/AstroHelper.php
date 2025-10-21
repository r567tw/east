<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class AstroHelper
{
    public function get(int $astroIndex = 8)
    {
        $url = "https://astro.click108.com.tw/daily_{$astroIndex}.php?iAstro={$astroIndex}";

        $response = Http::retry(3, 5000)->get($url);

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        // Convert response to UTF-8 encoding
        $html = mb_convert_encoding($response->body(), 'HTML-ENTITIES', 'UTF-8');
        $dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query('//div[contains(@class, "TODAY_CONTENT")]');
        if ($nodes->length > 0) {
            $result = trim($nodes->item(0)->textContent);
        }
        // 去除中間空白（不包含 \r\n）
        $result = preg_replace('/[ \t]+/', '', $result);
        libxml_clear_errors();

        return $result;
    }
}
