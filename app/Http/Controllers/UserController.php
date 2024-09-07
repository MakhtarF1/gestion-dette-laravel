<?php

namespace App\Http\Controllers;

use App\Services\UserServiceInterface;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StoreClientUserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->all();
        $users = $this->userService->getAllUsers($filters);
        return response()->json($users);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        
        return response()->json($user);
    }

    public function store(StoreClientUserRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        
        try {
            $result = $this->userService->createUserAndClient($validatedData);
            return response()->json($result, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(StoreUserRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $updatedUser = $this->userService->updateUser($id, $data);

        if (!$updatedUser) {
            return response()->json(['error' => 'Utilisateur non trouvé ou mise à jour échouée.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($updatedUser);
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->userService->deleteUser($id);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
