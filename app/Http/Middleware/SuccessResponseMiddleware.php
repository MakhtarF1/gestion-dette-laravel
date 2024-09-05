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

        // Vérifiez si la réponse est une instance de JsonResponse et si le code de statut est 200
        if ($response->status() === 200 && $response instanceof \Illuminate\Http\JsonResponse) {
            // Formater la réponse de succès en utilisant ApiResponseService
            return ApiResponseService::success($response->getData());
        }

        // Retourne la réponse originale si elle ne correspond pas à la condition
        return $response;
    }
}
