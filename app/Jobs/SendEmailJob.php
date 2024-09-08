<?php

namespace App\Jobs;

use App\Mail\UserCreatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $pdfPath;

    public function __construct($user, $pdfPath)
    {
        $this->user = $user;
        $this->pdfPath = $pdfPath;
    }

    public function handle()
    {
        $userEmail = $this->user->login;

        // Vérifie si l'adresse e-mail est valide
        if (empty($userEmail) || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            Log::error('Erreur lors de l\'envoi de l\'email : adresse e-mail invalide pour l\'utilisateur ID ' . $this->user->id);
            return; // Gérer l'erreur ici
        }

        try {
            Mail::to($userEmail)
                ->send(new UserCreatedMail($this->user, $this->pdfPath));
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'email pour l\'utilisateur ID ' . $this->user->id . ' : ' . $e->getMessage());
        }
    }
}
