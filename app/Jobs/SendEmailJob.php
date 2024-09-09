<?php

namespace App\Jobs;

use App\Mail\UserCreatedMail;
use App\Services\QrServiceInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle(QrServiceInterface $qrService)
    {
        $userEmail = $this->user->login;

        // Vérifie si l'adresse e-mail est valide
        if (empty($userEmail) || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            Log::error('Erreur lors de l\'envoi de l\'email : adresse e-mail invalide pour l\'utilisateur ID ' . $this->user->id);
            return; // Gérer l'erreur ici
        }

        try {
            Log::info('Début de la génération du QR Code pour l\'utilisateur ID: ' . $this->user->id);
            
            // Génération du QR Code
            $qrCodePath = $qrService->generateQrCode($this->user->id);
            if (!$qrCodePath) {
                Log::error('Erreur lors de la génération du QR Code pour l\'utilisateur ID: ' . $this->user->id);
                return; // Gérer l'erreur ici
            }

            $this->user->qr_code = $qrCodePath; 
            $this->user->save();

            // Vérification de l'existence du fichier QR Code
            $qrcodeFilePath = storage_path('app/public/' . $this->user->qr_code);
            if (!file_exists($qrcodeFilePath)) {
                Log::error('Le fichier QR Code n\'existe pas : ' . $qrcodeFilePath);
                return; // Gérer l'erreur ici
            }

            // Charge le QR Code en base64
            $qrcode = base64_encode(file_get_contents($qrcodeFilePath));
            Log::info('QR Code chargé avec succès pour l\'utilisateur ID: ' . $this->user->id);

            // Création du PDF avec la vue
            $pdf = Pdf::loadView('emails.carte_fidelite', ['user' => $this->user, 'qrcode' => $qrcode]);
            $pdfPath = 'carte_fidelite_' . $this->user->id . '.pdf';

            // Stockage du PDF
            Storage::put($pdfPath, $pdf->output());

            // Envoi de l'email avec le PDF en pièce jointe
            Mail::send('emails.texte', ['user' => $this->user], function ($message) use ($userEmail, $pdfPath) {
                $message->to($userEmail)
                    ->subject('Votre Carte de Fidélité')
                    ->attach(storage_path('app/' . $pdfPath), [
                        'as' => 'carte_fidelite_'.$this->user->id.'.pdf',
                        'mime' => 'application/pdf',
                    ]);
            });

            Log::info('Email envoyé avec succès à l\'utilisateur ID: ' . $this->user->id);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'email pour l\'utilisateur ID ' . $this->user->id . ' : ' . $e->getMessage());
        }
    }
}
