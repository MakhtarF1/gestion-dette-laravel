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
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UserCreationException;

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
                $originalName = $file->getClientOriginalName(); // Obtenir le nom d'origine
                $extension = $file->getClientOriginalExtension(); // Obtenir l'extension
                $uniqueName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . uniqid() . '.' . $extension; // Générer un nom unique

                // Stocker le fichier avec le nom unique
                $photoPath = $file->storeAs('public/image/upload', $uniqueName);
            } else {
                $photoPath = 'default-avatar.png';
            }

            $user = User::create([
                'name' => $data['name'],
                'login' => $data['login'],
                'photo' => $photoPath,
                'password' => bcrypt($data['password']),
                'role_id' => $role->id,
            ]);

            $qrCodeUrl = $this->qrService->generateQrCode($user->id);
            $user->update(['qr_code' => $qrCodeUrl]);

            return ApiResponseService::success(new UserResource($user), 201);
        } catch (\Exception $e) {
            throw new UserCreationException($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->userService->deleteUser($id);
            return ApiResponseService::successWithMessage('Utilisateur supprimé avec succès.', null, 204);
        } catch (UserNotFoundException $e) {
            return ApiResponseService::error($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            throw new UserCreationException($e->getMessage());
        }
    }
}
