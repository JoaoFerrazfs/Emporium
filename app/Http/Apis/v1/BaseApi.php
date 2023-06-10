<?php

namespace App\Http\Apis\v1;

use Illuminate\Http\JsonResponse;

class BaseApi
{
    public function response(array $data, int $status = 200): JsonResponse
    {
        return response()->json(['data' => $data])->setStatusCode($status);
    }

}
