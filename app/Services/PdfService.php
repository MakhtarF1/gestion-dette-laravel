<?php

namespace App\Services;

use Mpdf\Mpdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class PdfService
{
    public function generatePdf($user)
    {
        $mpdf = new Mpdf();

        // Génération du QR code
        $qrCode = new QrCode('User info: ' . $user->name);
        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode);
        $qrCodeDataUri = 'data:image/png;base64,' . base64_encode($qrCodeImage->getString());

        // Création du contenu HTML du PDF
        $html = view('emails.user_created', compact('user', 'qrCodeDataUri'))->render();

        // Écriture du contenu HTML dans le PDF
        $mpdf->WriteHTML($html);

        // Retourne le PDF en tant que chaîne
        return $mpdf->Output('', 'S');
    }
}
