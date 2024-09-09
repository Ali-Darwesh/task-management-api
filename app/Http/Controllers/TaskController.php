<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignTaskkRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Employee;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $priority = $request->only(['priority']);
        $status = $request->only(['status']);
        $tasks = Task::priority($priority)
            ->status($status)
            ->get();

        return response()->json($tasks, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {

        $validatedData = $request->all();
        $employee = Employee::where('employee_id', $request->assigned_to)->first();
        if ($employee) {
            $task = $this->taskService->createTask($validatedData);
            return response()->json($task, 201);
        } elseif (!User::find($request->assigned_to))
            return response()->json(['message' => 'user not found'], 404);
        else
            return response()->json(['message' => 'you must assign the task to an employee'], 400);
    }
    //method to assign_task_to_user
    public function assign_task_to_user(AssignTaskkRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $validatedData = $request->only(['assigned_to']);
        $this->taskService->updateTask($task, $validatedData);
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        try {
            $task = Task::findOrFail($id);

            return response()->json(['task' => $task], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve task details', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $validatedData = $request->all();
        $this->taskService->updateTask($task, $validatedData);
        return response()->json($task, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    // Soft Delete Task
    public function softDelete($id)
    {
        $this->taskService->softDelete($id);  // Soft delete the task

        return response()->json(['message' => 'Task soft deleted successfully'], 200);
    }

    // Restore a soft deleted task
    public function restore($id)
    {
        $this->taskService->restore($id);  // Restore the task

        return response()->json(['message' => 'Task restored successfully'], 200);
    }

    // Permanently delete a task (force delete)
    public function forceDelete($id)
    {
        $this->taskService->forceDelete($id);  // Permanently delete the task

        return response()->json(['message' => 'Task permanently deleted successfully'], 200);
    }
}
