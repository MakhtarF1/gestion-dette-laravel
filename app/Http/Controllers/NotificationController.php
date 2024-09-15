<?php

namespace App\Http\Controllers;

use App\Services\NotificationService; // Assurez-vous que le service est correctement importé
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(): JsonResponse
    {
        $user = Auth::user(); // Assurez-vous que Auth::user() retourne bien un objet User
        
        // Récupérez le rôle de l'utilisateur
        $role = $user->role; // Assurez-vous que cette relation est correctement définie dans le modèle User
        
        // Vérifiez si le rôle de l'utilisateur est "boutiquier"
        $isBoutiquier = $role && $role->libelle === 'boutiquier'; // Remplacez 'libelle' par le champ correct pour identifier le rôle

        if ($isBoutiquier) {
            $notifications = $this->notificationService->getAllNotifications();
        } else {
            $clientId = $user->client ? $user->client->id : null; // Assurez-vous que client est défini
            $notifications = $clientId 
                ? $this->notificationService->getNotificationsForClient($clientId) 
                : []; // Gérer le cas où client est null
        }

        return response()->json($notifications);
    }
}
