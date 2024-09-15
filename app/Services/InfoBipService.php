<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Dette;
use Illuminate\Support\Facades\Log;

class InfobipService implements SmsServiceInterface
{
    public function envoyerRappelDettes()
    {
        $apiKey = env('INFOBIP_API_KEY');
        $url = 'https://8gjzdr.api.infobip.com';
        $dettes = Dette::with('client')->get();
    
        foreach ($dettes as $dette) {
            $client = $dette->client;
            $totalPaiements = $dette->paiements()->sum('montant');
            $montantRestant = $dette->montant_dette - $totalPaiements;
    
            if ($montantRestant > 0) {
                $formattedPhone = '+221' . ltrim($client->telephone, '0');
    
                if ($formattedPhone) {
                    Log::info("Téléphone : {$formattedPhone}");
                    $message = "Bonjour {$client->nom}, vous avez une dette de {$montantRestant} à régler.";
                    Http::withHeaders([
                        'Authorization' => 'App ' . $apiKey,
                        'Content-Type' => 'application/json'
                    ])->post("{$url}/sms/2/text/advanced", [
                        'from' => 'VotreBoutique',
                        'to' => $formattedPhone,
                        'text' => $message,
                    ]);
    
                    Log::info("Rappel de dette envoyé à {$client->telephone} : {$message}");
                } else {
                    Log::warning("Numéro de téléphone invalide pour le client {$client->nom} : {$client->telephone}");
                }
            }
        }
    }
    

}