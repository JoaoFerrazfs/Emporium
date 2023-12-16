<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class Cacheable
{
    public function handle(Request $request, Closure $next): Response
    {
        $cacheKey = 'api:' . md5($request->fullUrl());
        if ($cachedData = Redis::get($cacheKey)) {
            return response()->json(json_decode($cachedData, 1));
        }

        /**
         * @var $response Response
         */
        $response = $next($request);

        if($response->getStatusCode() >= 300 ){
            return $response;
        }

        Redis::set($cacheKey, $response->content(), 'EX', 3600);

        return $response;
    }
}
