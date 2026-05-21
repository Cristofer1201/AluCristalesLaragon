<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'name.max' => 'El nombre no puede tener más de 60 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.max' => 'El email no puede tener más de 100 caracteres.',
        ];
    }
}
