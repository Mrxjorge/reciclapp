<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserProfileUpdateRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer esta solicitud.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Permitir siempre que el usuario autenticado pueda actualizar su perfil
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user()->id;  // ID del usuario autenticado

        return [
            // Nombre: requerido, tipo string, máximo 255 caracteres
            'name' => ['required', 'string', 'max:255'],

            // Email: requerido, debe ser único en la tabla users (ignorando al usuario actual)
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 
                        Rule::unique('users', 'email')->ignore($userId)],

            // Cédula: requerido, debe ser única en la tabla users (ignorando al usuario actual)
            'cedula' => ['required', 'string', 'max:30', 
                         Rule::unique('users', 'cedula')->ignore($userId)],

            // Dirección: requerido, tipo string, máximo 255 caracteres
            'direccion' => ['required', 'string', 'max:255'],

            // Teléfono: requerido, tipo string, máximo 30 caracteres
            'telefono' => ['required', 'string', 'max:30'],

            // Localidad: requerido, debe existir un id de localidad en la tabla localidades
            'localidad_id' => ['required', 'exists:localidades,id'],
        ];
    }
}
