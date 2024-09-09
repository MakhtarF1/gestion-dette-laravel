<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'adresse' => $this->adresse,
            'telephone' => $this->telephone,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
