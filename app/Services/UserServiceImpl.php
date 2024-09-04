<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserServiceImpl implements UserServiceInterface
{
    protected $userRepository;
    protected $uploadService;

    public function __construct(UserRepositoryInterface $userRepository, UploadServiceInterface $uploadService)
    {
        $this->userRepository = $userRepository;
        $this->uploadService = $uploadService;
    }

    public function getAllUsers($filters)
    {
        return $this->userRepository->all($filters);
    }

    public function getUserById($id)
    {
        return $this->userRepository->findById($id);
    }

    public function createUser($data)
    {
        $authUser = Auth::user();
        
        if ($authUser && trim($authUser->role->libelle) !== 'admin') {
            throw new \Exception('Vous n\'êtes pas autorisé à créer un compte utilisateur.');
        }
        
        // Handle the photo upload or assign a default
        if (isset($data['photo'])) {
            $data['photo'] = $this->uploadService->uploadFile($data['photo'], 'photos');
        } else {
            $data['photo'] = 'default-avatar.png'; // Default photo path
        }
        
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }
    

    public function updateUser($id, $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        // Upload de la photo si fournie
        if (isset($data['photo'])) {
            $data['photo'] = $this->uploadService->uploadFile($data['photo'], 'photos');
        }

        return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }
}
