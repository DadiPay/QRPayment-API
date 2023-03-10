<?php

namespace App\Http\Requests\mobile;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
            'email' => ['string', 'email'],
            'phone_number' => ['string', 'numeric', 'size:11'],
            'password' => ['required', 'string']
        ];
    }
}
