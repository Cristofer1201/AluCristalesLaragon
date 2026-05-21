<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('usuario');

        if (is_null($userId)) {
            throw new \Exception('User ID not found in the route.');
        }

        return [
            'name' => 'required|string|max:60',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users')->ignore($userId),
            ], 
            //'required|email|max:100|unique:users,email' . $this->user,
             // email único, excepto para el usuario actual
            'role' => 'required|exists:roles,id',
            'tienda' => 'required|in:ARAOZ 2403,GUEMES 4888,PALERMO CABA',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 60 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no es válido.',
            'email.max' => 'El email no puede tener más de 100 caracteres.',
            'email.unique' => 'El email ya está en uso.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no puede tener más de 30 caracteres.',
            'role.required' => 'El rol es obligatorio.',
            'role.exists' => 'El rol no existe.',
            'tienda.required' => 'La sede es obligatoria.',
            'tienda.in' => 'La sede seleccionada no es válida.',
        ];
    }
}
