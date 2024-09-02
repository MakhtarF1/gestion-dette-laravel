<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'login' => $this->login,
            'role' => $this->role ? new RoleResource($this->role) : null, // Vérifie si le rôle existe
            'etat' => $this->etat,
        ];
    }
}
