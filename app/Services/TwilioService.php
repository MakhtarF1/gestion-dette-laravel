<?php

namespace App\Services;

use Twilio\Rest\Client;
use App\Models\Dette;
use Illuminate\Support\Facades\Log;

class TwilioService implements SmsServiceInterface
{
    public function envoyerRappelDettes()
    {
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        $dettes = Dette::with('client')->get();

        foreach ($dettes as $dette) {
            $client = $dette->client;   
            $totalPaiements = $dette->paiements()->sum('montant');
            $montantRestant = $dette->montant_dette - $totalPaiements;

            if ($montantRestant > 0) {
                $formattedPhone = $this->formatPhoneNumber($client->telephone);

                if ($formattedPhone) {
                    $message = "Bonjour {$client->nom}, vous avez une dette de {$montantRestant} à régler.";
                    $twilio->messages->create(
                        $formattedPhone,
                        [
                            'from' => env('TWILIO_PHONE_NUMBER'),
                            'body' => $message
                        ]
                    );

                    Log::info("Rappel de dette envoyé à {$client->telephone} : {$message}");
                } else {
                    Log::warning("Numéro de téléphone invalide pour le client {$client->nom} : {$client->telephone}");
                }
            }
        }
    }


    private function formatPhoneNumber($phone)
    {
        if (!preg_match("/^\+221/", $phone)) {
            return '+221' . $phone;
        }
        return $phone;
    }
}
