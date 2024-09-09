<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Task;
use App\Models\User;

class UserService
{

    /**
     * Create user
     * @param array $data
     */
    public function createUser(array $data)
    {
        return User::create($data);
    }
    /** Update user
     * @param User $user, array $data
     */
    public function updateUser(User $user, array $data)
    {
        if ($user->role == 'admin') {
            return false;
        }
        $user->update($data);
        if ($data['role'] == 'manager' && $user->role !== 'manager') {
            $employee = Employee::where('employee_id', $user->id)->first();
            //get all tasks for the user to assighn them to nother employee
            $tasks = Task::where('assigned_to', $employee->employee_id)
                ->where('status', '!=', 'completed')
                ->get();
            if ($tasks->isNotEmpty()) {
                // Assign tasks to another employee (for example, $newManagerId)
                foreach ($tasks as $task) {
                    $task->update(['assigned_to' => $data['assign_tasks_to_newEmployee']]);
                }
            }

            // Now that tasks are reassigned, delete the employee
            $employee->delete();
            $user->role = $data['role'];
            $user->save();
            //check if the department that i want to make that user manager on it alredy have a manager
            $department_manager = Manager::where('department_id', $data['department_id'])->first();
            if (!$department_manager) {
                Manager::create([
                    'manager_id' => $user->id,
                    'department_id' => $data['department_id'], // Keep the same department
                ]);
            } else {
                $oldManager = User::findOrFail($department_manager->manager_id);
                $oldManager->role = 'employee';
                $oldManager->save();
                Employee::create([
                    'employee_id' => $oldManager->id,
                ]);
                $department_manager->update(['manager_id' => $user->id]);
            }
            return $user;
        } elseif ($data['role'] == 'employee') {
            $manager = Manager::where('manager_id', $user->id)->first();
            $manager->delete();
            Employee::create([
                'employee_id' => $user->id,
            ]);
            $user->role = $data['role'];
            $user->save();
            return $user;
        }

        return false;
    }

    /** delete user
     * @param User $user
     */
    public function softDelete($id)
    {
        $user = User::findOrFail($id);
        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Prevent soft-deleting an admin user
        if ($user->role == 'admin') {
            return response()->json(['message' => 'You cannot delete this user'], 403);
        }

        // Soft delete the user

        $user->delete();
    }


    // Soft delete the user

    public function restore($id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }

        $user->restore();
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }
        if ($user->role == 'admin') {
            return response()->json(['message' => 'You cannot delete this user'], 403);
        }

        $user->forceDelete();
    }
}
