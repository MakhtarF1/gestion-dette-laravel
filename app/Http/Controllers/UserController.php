<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserServiceInterface;
use App\Services\QrServiceInterface;
use App\Services\UploadServiceInterface;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Services\ApiResponseService;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    protected $userService;
    protected $qrService;
    protected $uploadService;

    public function __construct(UserServiceInterface $userService, QrServiceInterface $qrService, UploadServiceInterface $uploadService)
    {
        $this->userService = $userService;
        $this->qrService = $qrService;
        $this->uploadService = $uploadService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['role', 'active']);
        $users = $this->userService->getAllUsers($filters);
        return ApiResponseService::success(UserResource::collection($users));
    }

    public function store(StoreUserRequest $request)
    {
        $authUser = $request->user();
        if ($authUser->role && trim($authUser->role->libelle) !== 'admin') {
            return ApiResponseService::error('Vous n\'êtes pas autorisé à créer un compte utilisateur.', 403);
        }

        $data = $request->validated();
        $role = Role::where('libelle', $data['role'])->first();
        if (!$role) {
            return ApiResponseService::error('Le rôle spécifié n\'existe pas.', 400);
        }

        try {
            $photoPath = null;

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $photoPath = $this->uploadService->uploadFile($file, 'photos');
                // Optionnel : enregistrer une copie locale
                $file->storeAs('public/image/upload', 'avatar.png');
            } else {
                $photoPath = 'default-avatar.png';
            }

            // Créez l'utilisateur
            $user = User::create([
                'name' => $data['name'],
                'login' => $data['login'],
                'photo' => $photoPath, // URL Cloudinary uniquement
                'password' => bcrypt($data['password']),
                'role_id' => $role->id,
            ]);

            // Générez le QR code et stockez son URL
            $qrCodeUrl = $this->qrService->generateQrCode($user->id);
            $user->update(['qr_code' => $qrCodeUrl]); // Stockez l'URL du QR code

            return ApiResponseService::success(new UserResource($user), 201);
        } catch (\Exception $e) {
            return ApiResponseService::error('Erreur lors de l\'upload de la photo ou de la génération du QR code : ' . $e->getMessage(), 500);
        }
    }


    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return ApiResponseService::successWithMessage('Utilisateur supprimé avec succès.', null, 204);
    }
}
