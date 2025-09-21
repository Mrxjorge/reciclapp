<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id; // usuario autenticado

        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255',
                           Rule::unique('users', 'email')->ignore($userId)],
            'cedula'   => ['required', 'string', 'max:30',
                           Rule::unique('users', 'cedula')->ignore($userId)],
            'telefono' => ['required', 'string', 'max:30'],
            // Eliminado: 'direccion', 'localidad_id'
        ];
    }
}
