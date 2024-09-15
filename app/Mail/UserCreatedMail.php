<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $pdfPath;

    public function __construct($user, $pdfPath)
    {
        $this->user = $user;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        // Assure-toi que l'adresse e-mail est définie
        $userEmail = $this->user->login;

        // Vérifie si l'adresse e-mail est valide
        if (is_null($userEmail) || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('L\'adresse e-mail est invalide ou manquante.');
        }

        return $this->view('emails.carte_fidelite')
                    ->attach($this->pdfPath, [
                        'as' => 'carte_fidelite_'.$this->user->id.'.pdf',
                        'mime' => 'application/pdf',
                    ])
                    ->to($userEmail); 
    }
}
