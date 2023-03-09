<?php

namespace App\Http\Requests\mobile\mobile;

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
            'firstname' => 'required|string',
            'middlename' => 'required|string',
            'lastname' => 'required|string',
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:255', 'unique:users'],
            // 'banking_status' => ['required', 'string'],
            // 'vendor_category' => 'required|string',
            'password' => 'required|string|confirmed',
            // 'business_address' => 'required|string',
            // 'home_address' => 'required|string',
            // 'NIN' => 'string',
            // 'BVN' => 'string',
            // 'NOK' => 'string',
            // 'NOK_number' => 'integer',
            // 'NOK_address' => 'string',
        ];
    }
}
