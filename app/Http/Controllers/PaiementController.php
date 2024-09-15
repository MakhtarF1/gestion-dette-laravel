<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaiementRequest;
use App\Services\PaiementServiceInterface;
use Illuminate\Http\Response;

class PaiementController extends Controller
{
    protected $paiementService;

    public function __construct(PaiementServiceInterface $paiementService)
    {
        $this->paiementService = $paiementService;
    }

    public function store(StorePaiementRequest $request, $clientId)
    {
        try {
            // Validate the client ID passed in the URL
            $detteId = $request->input('dette_id');
            $montant = $request->input('montant');

            $paiement = $this->paiementService->createPaiement($clientId, $detteId, $montant);

            return response()->json($paiement, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}

