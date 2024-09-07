<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'dette_id',
        'montant',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function dette()
    {
        return $this->belongsTo(Dette::class);
    }

    public function dettes()
    {
        return $this->belongsToMany(Dette::class, 'dette_paiement')
                    ->withTimestamps();
    }
}
