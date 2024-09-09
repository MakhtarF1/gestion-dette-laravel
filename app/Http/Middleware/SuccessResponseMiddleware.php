<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
   
        if ($response instanceof JsonResponse && $response->status() === Response::HTTP_OK) {
            $originalData = $response->getData(true);

            $formattedData = [
                'message' => 'Succès',
                'data' => isset($originalData['data']) ? $originalData['data'] : $originalData,
                'status' => $response->status()
            ];

            return response()->json($formattedData, Response::HTTP_OK);
        }

        return $response;
    }
}
