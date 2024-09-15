<?php
namespace App\Notifications;

use App\Models\Demande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RelanceDemandeNotification extends Notification
{
    use Queueable;

    protected $demande;

    public function __construct(Demande $demande)
    {
        $this->demande = $demande;
    }

    public function via($notifiable)
    {
        return ['mail'];  // Notification via email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Relance de Demande Annulée')
            ->line('Votre demande #' . $this->demande->id . ' a été annulée.')
            ->line('Nous vous rappelons de prendre les mesures nécessaires.')
            ->action('Voir la Demande', url('/demandes/' . $this->demande->id))
            ->line('Merci d\'utiliser notre application!');
    }
}
