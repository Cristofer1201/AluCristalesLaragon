<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

     
    // esta funcion sirve para darle autorizacion a ciertos usuarios para que vean ciertas vistas, es mejor usar spatie permissions ya que es mas potente
    // asi que se cambiara de false a true
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

     //aqui se procedera a colocar las validaciones
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:60',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|max:30',
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
            'email.unique' => 'El email ya existe.',
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
