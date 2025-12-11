<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompressResponse
{
    /**
     * @phpstan-ignore-next-line
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        // 只處理可壓縮的 response
        if ($this->isCompressible($response, $request)) {
            $encoding = $this->getSupportedEncoding($request);

            if ($encoding) {
                $content = $response->getContent();

                if ($encoding === 'gzip') {
                    $compressed = gzencode($content, 9);
                } elseif ($encoding === 'br' && function_exists('brotli_compress')) {
                    $compressed = brotli_compress($content);
                } else {
                    $compressed = $content;
                }

                $response->setContent($compressed);
                $response->headers->set('Content-Encoding', $encoding);
                $response->headers->set('Vary', 'Accept-Encoding');
                $response->headers->set('Content-Length', strlen($compressed));
            }
        }

        return $response;
    }

    protected function isCompressible(Response $response, Request $request)
    {
        // 只壓縮 JSON 或 text 類型
        $contentType = $response->headers->get('Content-Type', '');

        return str_contains($contentType, 'application/json')
            || str_contains($contentType, 'text/');
    }

    protected function getSupportedEncoding(Request $request)
    {
        $acceptEncoding = $request->header('Accept-Encoding', '');

        if (str_contains($acceptEncoding, 'br') && function_exists('brotli_compress')) {
            return 'br';
        }

        if (str_contains($acceptEncoding, 'gzip')) {
            return 'gzip';
        }

        return null;
    }
}
