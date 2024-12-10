<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'current_pass' => 'required|string|current_password',
            'new_password' => 'required|string|min:6|different:current_pass',
            'confirm_password' => 'required|string|min:6|same:new_password',
        ];
    }

    public function messages()
    {
        return [
            'current_pass.required' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.different' => 'New password must be different from the current password.',
            'confirm_password.required' => 'Confirm password is required.',
            'confirm_password.same' => 'Confirm password must match the new password.',
        ];
    }
}
