<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updatePasswordRequest extends FormRequest
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
            'current_password' => 'required',
            'new_password' => 'required|min:8|max:30|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'Por favor ingrese su contraseña actual.',
            'new_password.required' => 'Por favor ingrese su nueva contraseña.',
            'new_password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'new_password.max' => 'La contraseña no debe tener mas de 30 caracteres.',
            'new_password.confirmed' => 'La contraseña no coincide.',
        ];

    }
}
