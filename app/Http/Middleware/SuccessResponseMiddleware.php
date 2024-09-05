<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;

class SuccessResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->status() === 200 && $response instanceof \Illuminate\Http\JsonResponse) {
        
            return ApiResponseService::success($response->getData());
        }
        return $response;
    }
}
