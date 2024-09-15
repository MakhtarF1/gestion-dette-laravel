<?php

namespace App\Mail;

use App\Models\Demande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemandeNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $demande;

    public function __construct(Demande $demande)
    {
        $this->demande = $demande;
    }

    public function build()
    {
        return $this->view('emails.demande_notification')
                    ->subject('Nouvelle Demande Reçue')
                    ->with(['demande' => $this->demande]);
    }
}
