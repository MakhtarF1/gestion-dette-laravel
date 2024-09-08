<?php

namespace App\Jobs;

use App\Services\QrServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class GenerateUserQrCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }
    
    public function handle(QrServiceInterface $qrService)
    {
        try {
            Log::info("Handling QR code generation for user ID: " . $this->userId);
            $qrCodePath = $qrService->generateQrCode($this->userId);
            
            // Mettre à jour l'utilisateur avec le chemin du QR code
            $user = User::find($this->userId);
            if ($user) {
                $user->qr_code = $qrCodePath; // Mise à jour pour la colonne qr_code
                $user->save();
                Log::info('QR code de l\'utilisateur ID ' . $this->userId . ' généré et stocké avec succès : ' . $qrCodePath);
            } else {
                Log::error("Utilisateur non trouvé pour l'ID : " . $this->userId);
            }
        } catch (\Exception $e) {
            Log::error("Erreur lors de la génération du QR code pour l'utilisateur ID : " . $this->userId . " - " . $e->getMessage());
        }
    }
}
