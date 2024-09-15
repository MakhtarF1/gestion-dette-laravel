<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'photo' => $this->photo ? asset('storage/app/public/image/upload/avatar.png' . $this->photo) : null,
            'login' => $this->login,
            'role' => $this->role ? new RoleResource($this->role) : null, // Vérifie si le rôle existe
            'etat' => $this->etat,
            'qr_code'=>$this->qr_code,
        ];
    }
}
