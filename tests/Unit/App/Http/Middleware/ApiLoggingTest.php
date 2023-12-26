<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mockery as m;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Log\LogManager;
use Tests\TestCase;

class ApiLoggingTest extends TestCase
{
    public function testShouldCreateLogs(): void
    {
        // Set
        $request = m::mock(Request::class);
        $logManager = m::mock(LogManager::class);
        $closure = $this->buildClosure();

        $apiLogging = new ApiLogging($logManager);

        // Expectation
        $request->expects()
            ->header('user-agent')
            ->andReturn('user-test');

        $request->expects()
            ->header('Origin')
            ->andReturn('Origin-test');

        $request->expects()
            ->user()
            ->andReturnNull();

        $request->expects()
            ->getMethod()
            ->andReturn('GET');

        $request->expects()
            ->getRequestUri()
            ->andReturn('api/v1/user-context');

        $logManager->expects()
            ->channel('daily')
            ->andReturnSelf();

        $logManager->expects()
            ->info('')
            ->withAnyArgs()
            ->andReturnSelf();

        // Action
        $apiLogging->handle($request, $closure);
    }

    private function buildClosure(): Closure
    {
        return function () {
            $response = m::mock(Response::class);

            $response->expects()
                ->getStatusCode()
                ->andReturn(200);

            $response->expects()
                ->getContent()
                ->andReturn("{'data':'result'}");

            return $response;
        };
    }
}
