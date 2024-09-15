<?php

namespace App\Http\Controllers;

use App\Services\UserServiceInterface;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StoreClientUserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\UserCreationException;
use App\Exceptions\UserNotFoundException;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $filters = $request->all();
            $users = $this->userService->getAllUsers($filters);
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->userService->getUserById($id);
            if (!$user) {
                throw new UserNotFoundException();
            }
            return response()->json($user);
        } catch (UserNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreClientUserRequest $request): JsonResponse
    {
        try {
            $validatedData = $request;

            // Gestion de la photo
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos');
                $validatedData['photo_path'] = $photoPath;
            }

            $result = $this->userService->createUserAndClient($validatedData);
            return response()->json($result, Response::HTTP_CREATED);
        } catch (UserCreationException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(StoreUserRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $updatedUser = $this->userService->updateUser($id, $data);

            if (!$updatedUser) {
                throw new UserNotFoundException();
            }

            return response()->json($updatedUser);
        } catch (UserNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->userService->deleteUser($id);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (UserNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
