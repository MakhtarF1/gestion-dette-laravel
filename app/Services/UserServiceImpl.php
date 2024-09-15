<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\ClientRepositoryInterface;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class UserServiceImpl implements UserServiceInterface
{
    protected $userRepository;
    protected $clientRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ClientRepositoryInterface $clientRepository
    ) {
        $this->userRepository = $userRepository;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Créer un utilisateur.
     */
    public function create(array $data): User
    {
        // Vérification de l'existence du rôle
        $role = Role::where('libelle', $data['role'])->firstOrFail();

        // Création de l'utilisateur
        return User::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'login' => $data['login'],
            'password' => Hash::make($data['password']),
            'etat' => 'actif',
            'role_id' => $role->id,
            'photo' => $data['photo_path'] ?? 'default_photo.jpg',
        ]);
    }

    /**
     * Créer un utilisateur et un client.
     */
    public function createUserAndClient($data)
    {

        $this->authorizeBoutiquier();
     

        // Hashage du mot de passe
        $data['password'] = Hash::make($data['password']);
        return DB::transaction(function () use ($data) {
           

            // Si un client_id est fourni
            if (isset($data['client_id'])) {

                $client = $this->clientRepository->find($data['client_id']);

                if (!$client) {
                    throw new Exception('Client non trouvé.');
                }

                if ($client->user_id === null) {
                  
                    // Création d'un nouvel utilisateur
                    $user = $this->userRepository->create([
                        'nom' => $data['nom'],
                        'prenom' => $data['prenom'],
                        'login' => $data['login'],
                        'password' => $data['password'],
                        'role' => $data['role'],
                        'photo' => $data['photo_path'] ?? 'default_photo.jpg',
                    ]);

                    // Association du nouvel utilisateur avec le client
                    $client->user_id = $user->id;
                    $client->save();

                    return [
                        'user' => $user,
                        'client' => $client,
                    ];
                } else {
                    throw new Exception('Ce client a déjà un compte utilisateur.');
                }
            } else {
                // Cas où aucun client_id n'est fourni, création d'un utilisateur et d'un client
                if ($this->clientRepository->findByTelephone($data['telephone'])) {
                    throw new Exception('Le numéro de téléphone est déjà utilisé.');
                }

                $user = $this->userRepository->create([
                    'nom' => $data['nom'],
                    'prenom' => $data['prenom'],
                    'login' => $data['login'],
                    'password' => $data['password'],
                    'role' => $data['role'],
                    'photo' => $data['photo_path'] ?? 'default_photo.jpg',
                ]);

                $clientData = [
                    'user_id' => $user->id,
                    'surname' => $data['surname'],
                    'adresse' => $data['adresse'] ?? 'Adresse non spécifiée',
                    'telephone' => $data['telephone'],
                ];

                $client = $this->clientRepository->create($clientData);

                return [
                    'user' => $user,
                    'client' => $client,
                ];
            }
        });
    }

    /**
     * Récupérer tous les utilisateurs avec des filtres.
     */
    public function getAllUsers(array $filters)
    {
        return $this->userRepository->all($filters);
    }

    /**
     * Récupérer un utilisateur par son ID.
     */
    public function getUserById(int $id)
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new Exception('Utilisateur non trouvé.', 404);
        }
        return $user;
    }

    /**
     * Mettre à jour un utilisateur.
     */
    public function updateUser(int $id, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->update($id, $data);
    }

    /**
     * Supprimer un utilisateur.
     */
    public function deleteUser(int $id)
    {
        return $this->userRepository->delete($id);
    }

    /**
     * Autoriser uniquement les administrateurs.
     */
    protected function authorizeBoutiquier()
    {
        $authUser = Auth::user();
        if ($authUser && trim($authUser->role->libelle) !== 'boutiquier') {
            throw new Exception('Vous n\'êtes pas autorisé à effectuer cette action.', 403);
        }
    }
    
}
