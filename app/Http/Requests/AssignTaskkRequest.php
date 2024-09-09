<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class AssignTaskkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $user = Auth::user();
        // // Ensure that there is an authenticated user
        // if (!$user || $user->role !== "admin" && !$user->role !== "manager") {
        //     abort(response()->json([
        //         'error' => 'You are not authorized to perform this action.',
        //     ], 403));
        // }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'assigned_to' => 'required|integer|exists:employees,employee_id',
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
