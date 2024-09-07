<?php

namespace App\Jobs;

use App\Services\QrServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class GenerateUserQrCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function handle(QrServiceInterface $qrService)
    {
        // Générer le QR code et obtenir le chemin du fichier
        $qrCodePath = $qrService->generateQrCode($this->userId);

        // Mettre à jour l'utilisateur avec le chemin du QR code
        $user = User::find($this->userId);
        if ($user) {
            $user->qr_code = $qrCodePath;
            $user->save();
        }
    }
}
