<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Service\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }
    public function index(): JsonResponse
    {
        //
        return response()->json(
            $this->userService->getAllUsers()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $genderItems = $this->userService->getGenders();
        $departmentItems = $this->userService->getDepartments();

        return response()->json([
            'genderItems' => $genderItems,
            'departmentItems' => $departmentItems,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            return $this->userService->createUser($request->validated());
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error creating user',
                'error' => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return response()->json(
            $this->userService->getUserById($id)
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = $this->userService->getUserById($id);
        $genderItems = $this->userService->getGenders();
        $departmentItems = $this->userService->getDepartments();

        return response()->json([
            'user' => $user,
            'genderItems' => $genderItems,
            'departmentItems' => $departmentItems,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        //
        try {
            $updatedUser = $this->userService->updateUser($id, $request->validated());
            return response()->json($updatedUser);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error updating user',
                'error' => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $user = $this->userService->deleteUser($id);
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error deleting user',
                'error' => $th->getMessage(),
            ], 400);
        }
    }

    public function resetPassword(Request $request, string $id): JsonResponse
    {
        try {
            $request->validate(['password' => 'required|string|min:8']);
            $this->userService->resetUserPassword($id, $request->input('password'));
            return response()->json(['message' => 'Password reset successfully']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error resetting password',
                'error' => $th->getMessage(),
            ], 400);
        }
    }

    public function loginHistory(string $id): JsonResponse
    {
        try {
            $history = $this->userService->loginHistory($id);
            return response()->json($history);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error fetching login history',
                'error' => $th->getMessage(),
            ], 400);
        }
    }

    public function activate(string $id): JsonResponse
    {
        try {
            $user = $this->userService->activateOrDeActivateUser($id);

            if($user->is_active) {
                return response()->json([
                    'message' => 'User activated successfully',
                    'user' => $user
                ]);
            } else {
                return response()->json([
                    'message' => 'User deactivated successfully',
                    'user' => $user
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error activating user',
                'error' => $th->getMessage(),
            ], 400);
        }
    }
}
