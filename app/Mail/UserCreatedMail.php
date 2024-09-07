<?php

namespace App\Mail;

use App\Models\User;
use App\Services\PdfService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    protected $pdfService;

    public function __construct(User $user,  $pdfService)
    {
        $this->user = $user;
        $this->pdfService = $pdfService;
    }

    public function build()
    {
        // Générer le PDF
        $pdfContent = $this->pdfService->generatePdf($this->user);

        return $this->subject('Bienvenue!')
                    ->attachData($pdfContent, 'profile.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
