<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Log\LogManager;
use Symfony\Component\HttpFoundation\Response;

class ApiLogging
{
    public function __construct(
        private readonly LogManager $log,
    ) {
    }
    public function handle(Request $request, Closure $next): Response
    {
        $logData['request']['headers']['User-agent'] =  $request->header('user-agent');
        $logData['request']['headers']['Origin'] =  $request->header('Origin');
        $logData['request']['user'] =  $request->user()?->id;

        /**
         * @var Response $response
         */
        $response = $next($request);

        $logData['response']['statusCode'] =  $response->getStatusCode();
        $logData['response']['content'] =  json_decode($response->getContent(), true);

        $this->log->channel('daily')->info(
            "{$request->getMethod()} - {$request->getRequestUri()}",
            $logData
        );

        return $response;
    }
}
