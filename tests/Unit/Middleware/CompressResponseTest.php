<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\CompressResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CompressResponseTest extends TestCase
{
    public function test_handle_compresses_json_response_with_gzip()
    {
        $middleware = new CompressResponse;
        $request = Request::create('/', 'GET', [], [], [], [
            'HTTP_ACCEPT_ENCODING' => 'gzip',
        ]);
        $originalContent = json_encode(['foo' => 'bar']);
        $response = new Response($originalContent, 200, ['Content-Type' => 'application/json']);
        $next = fn () => $response;

        $result = $middleware->handle($request, $next);

        $this->assertEquals('gzip', $result->headers->get('Content-Encoding'));
        $this->assertEquals('Accept-Encoding', $result->headers->get('Vary'));
        $this->assertNotEquals($originalContent, $result->getContent());
        $this->assertEquals(strlen($result->getContent()), $result->headers->get('Content-Length'));
        $this->assertEquals($originalContent, gzdecode($result->getContent()));
    }

    public function test_handle_does_not_compress_non_compressible_content_type()
    {
        $middleware = new CompressResponse;
        $request = Request::create('/', 'GET', [], [], [], [
            'HTTP_ACCEPT_ENCODING' => 'gzip',
        ]);
        $response = new Response('<svg></svg>', 200, ['Content-Type' => 'image/svg+xml']);
        $next = fn () => $response;

        $result = $middleware->handle($request, $next);

        $this->assertNull($result->headers->get('Content-Encoding'));
        $this->assertEquals('<svg></svg>', $result->getContent());
    }

    public function test_handle_no_supported_encoding()
    {
        $middleware = new CompressResponse;
        $request = Request::create('/', 'GET');
        $response = new Response('hello', 200, ['Content-Type' => 'text/plain']);
        $next = fn () => $response;

        $result = $middleware->handle($request, $next);

        $this->assertNull($result->headers->get('Content-Encoding'));
        $this->assertEquals('hello', $result->getContent());
    }

    public function test_handle_no_supported_compressed()
    {
        $middleware = new CompressResponse;
        $request = Request::create('/', 'GET', [], [], [], [
            'HTTP_ACCEPT_ENCODING' => 'br',
        ]);
        $response = new Response('hello', 200, ['Content-Type' => 'text/plain']);
        $next = fn () => $response;

        $result = $middleware->handle($request, $next);

        $this->assertNull($result->headers->get('Content-Encoding'));
        $this->assertEquals('hello', $result->getContent());
    }
}
