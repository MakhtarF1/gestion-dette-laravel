<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dette extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'montant_pa', 'montant_rst'];

    protected $hidden = ['created_at', 'updated_at'];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'dette_article') // Spécifier la table pivot
                    ->withPivot('quantitestock', 'prix')
                    ->withTimestamps();
    }
}

