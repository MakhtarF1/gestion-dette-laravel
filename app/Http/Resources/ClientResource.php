<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'surname' => $this->surname,
            'adresse' => $this->adresse,
            'telephone' => $this->telephone,
            'user_id' => $this->user_id,
            'categorie_id' => $this->categorie_id,
            'max_montant' => $this->max_montant,
        ];
    }
}
