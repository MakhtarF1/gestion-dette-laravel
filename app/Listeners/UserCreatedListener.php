<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Jobs\GenerateUserQrCode;
use App\Jobs\UploadUserPhotoJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

class UserCreatedListener
{
    public function handle(UserCreated $event)
    {
        try {
            // Dispatcher le job pour générer le QR code
            GenerateUserQrCode::dispatch($event->user->id);
            Log::info("QR code job dispatched for user ID: " . $event->user->id);

            // Vérifier si l'utilisateur a une photo
            if ($event->user->photo) {
                // Convertir la photo en UploadedFile et la stocker
                $photoPath = $this->storePhotoLocally($event->user->photo);
                
                // Dispatcher le job pour uploader la photo
                UploadUserPhotoJob::dispatch($event->user, $photoPath);
                Log::info("Photo upload job dispatched for user ID: " . $event->user->id);
            }
        } catch (\Exception $e) {
            Log::error('Error dispatching jobs for user ID ' . $event->user->id . ': ' . $e->getMessage());
        }
    }

    private function storePhotoLocally($photo)
    {
        // Vérifier si la photo est une instance d'UploadedFile
        if ($photo instanceof UploadedFile) {
            // Stocker la photo dans storage/app/public/images
            return $photo->store('images', 'public'); // 'public' fait référence à storage/app/public
        }

        // Si la photo est une chaîne (chemin), créer un UploadedFile
        if (is_string($photo)) {
            return (new UploadedFile($photo, basename($photo)))->store('images', 'public');
        }

        throw new \Exception('Photo format not supported.');
    }
}
