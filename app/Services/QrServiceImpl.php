<?php

namespace App\Services;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

class QrServiceImpl implements QrServiceInterface
{
    public function generateQr(string $data): string
    {
        // Validez les données pour s'assurer qu'elles ne sont pas vides
        if (empty($data)) {
            throw new \InvalidArgumentException('Les données du code QR doivent être une chaîne non vide.');
        }

        $qrCode = new QrCode($data);
        $writer = new PngWriter();

        // Générez le code QR sous forme de données binaires
        $result = $writer->write($qrCode);
        $fileName = uniqid() . '.png';
        $filePath = 'public/qrcodes/' . $fileName;

        // Enregistrez les données binaires dans un fichier
        Storage::put($filePath, $result->getString());

        // Retournez l'URL pour accéder à l'image du code QR
        return Storage::url($filePath);
    }
}
