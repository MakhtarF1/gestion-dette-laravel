<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Jobs\GenerateUserQrCode;
use App\Jobs\SendEmailJob;
use App\Jobs\UploadUserPhotoJob;
use App\Services\QrServiceImpl;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserCreatedListener
{
    public function handle(UserCreated $event)
    {
        try {
            // Dispatcher le job pour générer le QR code
            // GenerateUserQrCode::dispatch($event->user->id);
            $user = $event->user;
            $userEmail =  $user->login;
            $qrService = app(QrServiceImpl::class);
            $qrCodePath = $qrService->generateQrCode( $user->id);
             $user->qr_code = $qrCodePath; 
             $user->save();

            // Charge le QR Code en base64
            $qrcode = base64_encode(file_get_contents(storage_path('app/public/' .  $user->qr_code)));
            // $photos = base64_encode(file_get_contents(storage_path('app/photos/' .  $user->photo)));

            Log::info($qrcode);

            // Création du PDF avec la vue
            $pdf = Pdf::loadView('emails.carte_fidelite', ['user' =>  $user, 'qrcode' => $qrcode]);
            $pdfPath = 'carte_fidelite_' .  $user->id . '.pdf';

            // Stockage du PDF
            Storage::put($pdfPath, $pdf->output());

            // Envoi de l'email avec le PDF en pièce jointe
            Mail::send('emails.texte', ['user' =>  $user], function ($message) use ($userEmail, $pdfPath,$user) {
                $message->to($userEmail) // Utiliser login pour l'adresse e-mail
                    ->subject('Votre Carte de Fidélité')
                    ->attach(storage_path('app/' . $pdfPath), [
                        'as' => 'carte_fidelite_'. $user->id.'.pdf',
                        'mime' => 'application/pdf',
                    ]);
            });
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