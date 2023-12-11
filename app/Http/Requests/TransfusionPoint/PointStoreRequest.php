<?php

namespace App\Http\Requests\TransfusionPoint;

use Illuminate\Foundation\Http\FormRequest;

class PointStoreRequest extends FormRequest
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
            'city' => 'required|string|between:2,25',
            'full_address' => 'required|string',
            'geolocation' => 'required|json',
        ];
    }
}
