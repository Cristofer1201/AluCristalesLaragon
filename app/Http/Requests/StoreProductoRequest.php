<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:50', 'unique:productos,nombre'],
            'descripcion' => ['nullable', 'string', 'max:200'],
            'tipo' => ['nullable', 'string', 'max:50'],
            'activo' => ['required', 'boolean'],
            'imagen' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.unique'   => 'Este producto ya existe.',
            'activo.required' => 'Debe indicar si el producto está activo.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser PNG, JPG, JPEG o WEBP.',
            'imagen.max' => 'La imagen no debe superar los 2MB.',
        ];
    }
}
