<?php

namespace App\Http\Requests\Donation;

use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class DonationStoreRequest extends FormRequest
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
            'type_id' => 'required|integer|between:1,3',
            'date' => 'required|date',
            'confirming_document' => 'required|string|between:2,100',
            'user_id' => 'required|integer',
        ];
    }
}
