<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreatedMail
{
    use Dispatchable, SerializesModels;

    public $user;
    public $pdfPath;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $pdfPath)
    {
        $this->user = $user;
        $this->pdfPath = $pdfPath;
    }
}
