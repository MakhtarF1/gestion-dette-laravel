<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['libelle', 'prix', 'quantitestock'];

    protected $hidden = ['created_at', 'updated_at'];

    public function dettes()
    {
        return $this->belongsToMany(Dette::class, 'dette_article') // Spécifier la table pivot
                    ->withPivot('quantitestock', 'prix')
                    ->withTimestamps();
    }
}

