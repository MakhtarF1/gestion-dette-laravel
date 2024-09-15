<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Les rôles autorisés pour accéder à la route.
     *
     * @var array
     */
    protected $roles;

    /**
     * Crée une nouvelle instance du middleware.
     *
     * @param  array  $roles
     * @return void
     */
    public function __construct(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Vérifie si l'utilisateur a un des rôles autorisés.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && in_array(trim($user->role->libelle), $this->roles)) {
            return $next($request);
        }

        return response()->json(['error' => 'Accès non autorisé.'], Response::HTTP_FORBIDDEN);
    }
}
