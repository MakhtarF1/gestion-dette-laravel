<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['surnom', 'prenom', 'adresse', 'telephone', 'user_id'];


    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relation with User model.
     * A client may have a user account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
