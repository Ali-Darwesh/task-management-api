<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $taskId = $this->route('id');

        // Find the task with the given ID
        $task = Task::findOrFail($taskId);
        // Ensure that there is an authenticated user
        echo $this->route;
        if (!$user || $user->role !== "admin" && $user->role !== "manager" && $user->id !== $task->assigned_to) {
            abort(response()->json([
                'error' => 'Just the user who assigned to do this task allowed to update it ',
            ], 403));
        }

        echo $user;

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = Auth::user();
        if ($user && $user->role === 'employee') {
            return [
                'description' => 'sometimes|string|max:255',
                'priority' => 'sometimes|in:low,medium,high,urgent',
                'status' => 'sometimes|in:pending,in_progress,completed',
            ];
        }
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
            'due_date' => 'sometimes|date|after_or_equal:today ',
            'assigned_to' => 'sometimes|integer|exists:employees,employee_id',
            'priority' => 'sometimes|in:low,medium,high,urgent',
            'status' => 'sometimes|in:pending,in_progress,completed',
        ];
    }
    /**
     * The failedValidation method is used to customize the response that is returned when form validation fails 
     * @param Validator $validator
     * it throws an HttpResponseException
     * @return \Illuminate\HTTP\JsonResponse
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'please input data with correct form',
            'errors' => $validator->errors(),
        ]));
    }
}
