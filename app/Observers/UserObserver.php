<?php

namespace App\Observers;

use App\Models\User;
use App\Events\UserCreated;
use App\Jobs\UploadUserPhotoJob;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        // Vérifier si l'utilisateur a une adresse e-mail valide
        if (empty($user->login) || !filter_var($user->login, FILTER_VALIDATE_EMAIL)) {
            Log::error('Adresse e-mail invalide pour l\'utilisateur ID ' . $user->id);
            return; // Gérer l'erreur ici
        }

        // Déclencher l'événement UserCreated
        event(new UserCreated($user));

        // Si une photo est associée à l'utilisateur, dispatcher le job pour upload
        if ($user->photo) {
            UploadUserPhotoJob::dispatch($user, $user->photo);
        }

        // Générer le PDF de la carte fidélité
        $pdf = Pdf::loadView('emails.carte_fidelite', ['user' => $user]);
        $pdfPath = 'carte_fidelite_'.$user->id.'.pdf';

        // Sauvegarder le PDF dans le stockage
        Storage::put($pdfPath, $pdf->output());
    }
}
