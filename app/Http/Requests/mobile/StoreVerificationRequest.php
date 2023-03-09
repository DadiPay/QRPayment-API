<?php

namespace App\Http\Requests\mobile;

use Illuminate\Foundation\Http\FormRequest;

class StoreVerificationRequest extends FormRequest
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
            'banking_status' => ['required', 'string'],
            'vendor_category' => 'required|string',
            'business_address' => 'required|string',
            'home_address' => 'required|string',
            'NIN' => 'string',
            'BVN' => 'string',
            'NOK' => 'string',
            'NOK_number' => 'integer',
            'NOK_address' => 'string',
        ];
    }
}
