<?php

namespace App\Notifications;

use App\Models\Demande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DemandeSoumiseNotification extends Notification
{
    use Queueable;

    protected $demande;

    public function __construct(Demande $demande)
    {
        $this->demande = $demande;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Une nouvelle demande a été soumise.')
                    ->action('Voir la demande', url('/demandes/' . $this->demande->id))
                    ->line('Merci de gérer cette demande.');
    }

    public function toArray($notifiable)
    {
        return [
            'demande_id' => $this->demande->id,
            'message' => 'Une nouvelle demande a été soumise.'
        ];
    }
}
