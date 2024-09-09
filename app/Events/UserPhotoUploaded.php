<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPhotoUploaded
{
    use Dispatchable, SerializesModels;

    public $user;
    public $photo;

    /**
     * Create a new event instance.
     *
     * @param $user
     * @param $photo
     */
    public function __construct($user, $photo)
    { 
        $this->user = $user;
        $this->photo = $photo;
    }
}
