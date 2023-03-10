<?php

namespace App\Http\Requests\mobile;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'fullname' => 'required|string',
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'size:11','unique:users'],
            'password' => 'required|string|confirmed',
        ];
    }
}
