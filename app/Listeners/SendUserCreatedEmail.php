<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class SendUserCreatedEmail
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        // Vérifier que l'utilisateur a une adresse e-mail définie
        if (empty($event->user->login) || !filter_var($event->user->login, FILTER_VALIDATE_EMAIL)) {
            Log::error('Adresse e-mail invalide pour l\'utilisateur ID ' . $event->user->id);
            return; // Gérer l'erreur ici
        }

        // Générer le PDF de la carte fidélité à partir de la vue Blade
        $pdf = Pdf::loadView('emails.carte_fidelite', ['user' => $event->user]);
        $pdfPath = 'carte_fidelite_'.$event->user->id.'.pdf';

        // Sauvegarder le PDF dans le stockage
        Storage::put($pdfPath, $pdf->output());

        // Envoyer l'email avec le PDF en pièce jointe
        Mail::send('emails.carte_fidelite', ['user' => $event->user], function ($message) use ($event, $pdfPath) {
            $message->to($event->user->login) // Utiliser login pour l'adresse e-mail
                ->subject('Votre Carte de Fidélité')
                ->attach(storage_path('app/' . $pdfPath), [
                    'as' => 'carte_fidelite_'.$event->user->id.'.pdf',
                    'mime' => 'application/pdf',
                ]);
        });

        // Optionnel : Supprimez le fichier temporaire
        Storage::delete($pdfPath);
    }
}
