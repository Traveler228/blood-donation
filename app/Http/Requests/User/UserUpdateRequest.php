<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'surname' => 'string|between:2,100',
            'name' => 'string|between:2,100',
            'patronymic' => 'string|between:2,100',
            'city' => 'string|between:2,25',
            'login' => 'string|min:6|max:100|unique:users',
            'email' => 'string|email|max:100|unique:users',
            'password' => 'string|confirmed|min:6',
        ];
    }
}
