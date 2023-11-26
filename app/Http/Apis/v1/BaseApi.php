<?php

namespace App\Http\Apis\v1;

use Illuminate\Http\JsonResponse;

class BaseApi
{
    public function response(array $data = [], int $status = 200): JsonResponse
    {
        return response()->json(['data' => $data])->setStatusCode($status);
    }

    public function responseNotFound(array $data = [], int $status = 404): JsonResponse
    {
        return response()->json(['data' => $data])->setStatusCode($status);
    }

    public function errorResponse(array $data = [], int $status = 500): JsonResponse
    {
        return response()->json(['error' => $data])->setStatusCode($status);
    }

}
