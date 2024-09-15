<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dette extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'montant_dette'];

    protected $hidden = ['created_at', 'updated_at'];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'dette_article')
                    ->withPivot('quantite', 'prix')
                    ->withTimestamps();
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function isCompletelyPaid()
    {
        $totalPaiements = $this->paiements()->sum('montant');
        return $totalPaiements >= $this->montant_dette;
    }
    
}
