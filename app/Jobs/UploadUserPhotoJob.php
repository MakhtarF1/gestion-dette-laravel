<?php

namespace App\Jobs;

use Cloudinary\Cloudinary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UploadUserPhotoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $photoPath; // Chemin temporaire

    public function __construct($user, $photoPath)
    {
        $this->user = $user;
        $this->photoPath = $photoPath; // Chemin temporaire
    }

    public function handle()
    {
        try {
            // Vérifiez si le fichier photo existe
            if (!file_exists(storage_path('photos/' . $this->photoPath))) {
                throw new \Exception('Le fichier photo n\'existe pas : ' . $this->photoPath);
            }

            // Instanciez Cloudinary
            $cloudinary = new Cloudinary();

            // Téléchargez l'image sur Cloudinary
            $response = $cloudinary->uploadApi()->upload(storage_path('photos/' . $this->photoPath), [
                'folder' => 'users_photos/' . $this->user->id // Dossier sur Cloudinary
            ]);

            // Vérifiez si le téléchargement a réussi
            if (isset($response['secure_url'])) {
                // Enregistrez l'URL dans l'utilisateur
                $this->user->photo_path = $response['secure_url']; // Mettez à jour avec l'URL sécurisée
                $this->user->save(); // Sauvegarder les modifications
            } else {
                throw new \Exception('Erreur lors de l\'upload sur Cloudinary : ' . json_encode($response));
            }

            // Optionnel : Supprimez le fichier temporaire
            unlink(storage_path('photos/' . $this->photoPath));
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'upload de la photo pour l\'utilisateur ID ' . $this->user->id . ' : ' . $e->getMessage());
        }
    }
}
