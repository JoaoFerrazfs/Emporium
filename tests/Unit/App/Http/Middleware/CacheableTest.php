<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Mockery as m;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CacheableTest extends TestCase
{
    private int $status = 200;

    public function testShouldCreateCache(): void
    {
        // Set
        $request = m::mock(Request::class);
        $closure = $this->buildClosure();
        $this->status = 200;

        $apiLogging = new Cacheable();

        // Expectation
        $request->expects()
            ->fullUrl()
            ->once()
            ->andReturn('url/full');

        Redis::shouldReceive('get')
            ->with('api:3019c81267f0062b3a22e395d13e942c')
            ->once()
            ->andReturnNull();

        Redis::shouldReceive('set')
            ->with('api:3019c81267f0062b3a22e395d13e942c', "{'data':'result'}", 'EX', 3600 )
            ->once()
            ->andReturnNull();

        // Action
        $apiLogging->handle($request, $closure);
    }

    public function testShouldNotCreateCacheWhenIsAInvalidStatus(): void
    {
        // Set
        $request = m::mock(Request::class);
        $closure = $this->buildClosure();
        $this->status = 400;

        $apiLogging = new Cacheable();

        // Expectation
        $request->expects()
            ->fullUrl()
            ->andReturn('url/full');

        Redis::shouldReceive('get')
            ->with('api:3019c81267f0062b3a22e395d13e942c')
            ->once()
            ->andReturnNull();

        Redis::shouldReceive('set')
            ->with('api:3019c81267f0062b3a22e395d13e942c', "{'data':'result'}", 'EX', 3600 )
            ->never()
            ->andReturnNull();

        // Action
        $apiLogging->handle($request, $closure);
    }

    public function testShouldUseCachePreExistent(): void
    {
        // Set
        $request = m::mock(Request::class);
        $closure = $this->buildClosure();
        $cachedData = '{"data":"data cached"}';

        $apiLogging = new Cacheable();

        // Expectation
        $request->expects()
            ->fullUrl()
            ->once()
            ->andReturn('url/full');

        Redis::shouldReceive('get')
            ->with('api:3019c81267f0062b3a22e395d13e942c')
            ->once()
            ->andReturn($cachedData);

        // Action
        $actual = $apiLogging->handle($request, $closure);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $actual);
        $this->assertSame($cachedData, $actual->content());
    }

    private function buildClosure(): Closure
    {
        return function (){
            $response = m::mock(Response::class);

            if($this->status < 300) {
                $response->expects()
                    ->getContent()
                    ->andReturn("{'data':'result'}");
            };

            $response->expects()
                ->getStatusCode()
                ->andReturn($this->status);

            return $response;
        };
    }
}
