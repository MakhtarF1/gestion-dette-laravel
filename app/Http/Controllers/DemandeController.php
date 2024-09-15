<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDemandeRequest;
use App\Jobs\NotifyBoutiquierJob;
use App\Services\DemandeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Exception;

class DemandeController extends Controller
{
    protected $demandeService;

    public function __construct(DemandeService $demandeService)
    {
        $this->demandeService = $demandeService;
    }

    public function store(StoreDemandeRequest $request): JsonResponse
    {
        try {
            $data = $request->all();
            $demande = $this->demandeService->createDemande($data);

            if (!$demande) {
                return response()->json(['message' => 'Échec de la création de la demande'], 400);
            }

            // Dispatch a job to notify boutiquiers
            NotifyBoutiquierJob::dispatch($demande);

            return response()->json(['message' => 'Demande créée avec succès', 'demande' => $demande], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création de la demande.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index(): JsonResponse
    {
        $user = Auth::user();
        $role = $user->role; // Obtient le rôle de l'utilisateur

        // Vérifie si le rôle est "boutiquier"
        $isBoutiquier = $role && $role->libelle === 'boutiquier';

        if ($isBoutiquier) {
            $demandes = $this->demandeService->getAllDemandes();
        } else {
            $clientId = $user->client->id ?? null; // Assurez-vous que client est défini
            $demandes = $clientId
                ? $this->demandeService->getDemandesForClient($clientId)
                : []; // Gérer le cas où client est null
        }

        return response()->json($demandes);
    }

    public function show($id): JsonResponse
    {
        $demande = $this->demandeService->findDemande($id);
        if (!$demande) {
            return response()->json(['message' => 'Demande non trouvée'], 404);
        }
        return response()->json($demande);
    }

    public function reject($id): JsonResponse
    {
        $user = Auth::user();
        $role = $user->role; // Obtient le rôle de l'utilisateur

        // Vérifie si le rôle est "boutiquier"
        $isBoutiquier = $role && $role->libelle === 'boutiquier';

        if (!$isBoutiquier) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        try {
            $demande = $this->demandeService->updateStatus($id, 'refusé');
            if (!$demande) {
                return response()->json(['message' => 'Demande non trouvée'], 404);
            }

            return response()->json(['message' => 'Demande refusée avec succès', 'demande' => $demande]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erreur lors du refus de la demande.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
