<?php

namespace App\Services;

use App\Enums\Status;
use Illuminate\Http\JsonResponse;

class ApiResponseService
{
 
    public static function success($data, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => Status::SUCCESS->value,
            'data' => $data,
        ], $statusCode);
    }

    public static function error(string $message, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'status' => Status::ECHEC->value,
            'message' => $message,
            'data'=>null,
        ], $statusCode);
    }

  
    public static function successWithMessage(string $message, $data = null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => Status::SUCCESS->value,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
