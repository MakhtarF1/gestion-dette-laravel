<?php

namespace App\Observers;

use App\Models\User;
use App\Events\UserCreated;
use App\Jobs\UploadUserPhotoJob;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Mpdf\Tag\B;

class UserObserver
{
 
    public function created(User $user)
    {
      
        event(new UserCreated($user));
        if (empty($user->login) || !filter_var($user->login, FILTER_VALIDATE_EMAIL)) {
            Log::error('Adresse e-mail invalide pour l\'utilisateur ID ' . $user->id);
            return; 
        }

        if ($user->photo) {
            UploadUserPhotoJob::dispatch($user, $user->photo);
        }
        // $qrcode = base64_encode(file_get_contents(storage_path('app/public/' . $user->qr_code)));

        // $pdf = Pdf::loadView('emails.carte_fidelite', ['user' => $user, 'qrcode' => $qrcode]);
        // $pdfPath = 'carte_fidelite_'.$user->id.'.pdf';

        // Storage::put($pdfPath, $pdf->output());
    }
}
