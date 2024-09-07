<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    protected $userService;
    /**
     * Constracor to inject User Service
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     * * @return \Illuminate\HTTP\JsonResponse
     */
    public function index()
    {
        try {
            $users = User::all();
            return response()->json($users, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve users', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * Display a user in storage.
     * @param User $user
     * @return \Illuminate\HTTP\JsonResponse
     */
    public function show(User $user)
    {
        try {
            $user = User::findOrFail($user->id);

            return response()->json(['user' => $user], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve user details', 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * Update the specified resource (user) in storage.
     * @param Request $request , User $user
     * @return \Illuminate\HTTP\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        try {
            // return response()->json($request->all(), 200);
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',  // Validate name if provided
                'email' => 'sometimes|email|max:255|unique:users,email',  // Validate email if provided and ensure it's unique
                'password' => 'sometimes|string|min:6',  // Validate password if provided
            ]);


            $user = $this->userService->updateUser($user, $validatedData);

            return response()->json($user, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update rating', 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * delete user data in database
     * @param Movie $movie
     * @return \Illuminate\HTTP\JsonResponse
     */
    public function destroy(User $user)
    {
        try {
            $this->userService->deleteUser($user);
            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete user', 'message' => $e->getMessage()], 500);
        }
    }
}
