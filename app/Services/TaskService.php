<?php

namespace App\Services;


use App\Models\Task;

class TaskService
{

    /**
     * Create task
     * @param array $data
     */
    public function createTask(array $data)
    {
        return Task::create($data);
    }
    /** Update task
     * @param task $task, array $data
     */
    public function updateTask(Task $task, array $data)
    {
        return $task->update($data);
    }

    /** delete task
     * @param task $task
     */
    public function softDelete($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }


        $task->delete();
    }

    public function restore($id)
    {
        $task = Task::withTrashed()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->restore();
    }

    public function forceDelete($id)
    {
        $task = Task::withTrashed()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->forceDelete();
    }
}
