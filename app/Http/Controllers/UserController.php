<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Task;
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
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->role === 'employee') {
                $tasks = Task::where('assigned_to', $user->id)->get();
                return response()->json(['user' => $user, 'tasks' => $tasks], 200);
            }
            return response()->json(['user' => $user], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve user details not found', 'message' => $e->getMessage()], 404);
        }
    }
    /**
     * Update the specified resource (user) in storage.
     * @param Request $request , User $user
     * @return \Illuminate\HTTP\JsonResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        try {
            // return response()->json($request->all(), 200);
            $validatedData = $request->all();
            $user = $this->userService->updateUser($user, $validatedData);


            return response()->json($user, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update user', 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * delete user data in database
     * @param Movie $movie
     * @return \Illuminate\HTTP\JsonResponse
     */
    // Soft Delete user
    public function softDelete($id)
    {
        $user = User::findOrFail($id);
        // Check if the user exists
        $this->userService->softDelete($id); // Soft delete the user
        return response()->json(['message' => 'user soft deleted successfully'], 200);
    }

    // Restore Soft Deleted user
    public function restore($id)
    {
        $this->userService->restore($id);
        return response()->json(['message' => 'user restored successfully'], 200);
    }
    public function forceDelete($id)
    {
        $this->userService->forceDelete($id);  // Permanently delete the user

        return response()->json(['message' => 'user permanently deleted successfully'], 200);
    }
}
