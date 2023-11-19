<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class Cacheble
{
    public function handle(Request $request, Closure $next): Response
    {
        $cacheKey = 'api:' . md5($request->fullUrl());
        if ($cachedData = Redis::get($cacheKey)) {
            return response()->json(json_decode($cachedData, 1));
        }

        $response = $next($request);

        Redis::set($cacheKey, $response->content(), 'EX', 3600);


        return $response;
    }
}
