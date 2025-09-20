<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileUpdateRequest;  // Importamos la clase para la validación del formulario
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Mostrar el formulario de edición de perfil.
     */
    public function edit()
    {
        // Verificar si el usuario es administrador
        if (Auth::user()->isAdmin()) {
            // Aquí puedes redirigir a los administradores a otra página si es necesario
            // return redirect()->route('admin.dashboard'); // Ejemplo de redirección a un dashboard de admin
        }

        // Si no es admin, simplemente devuelve la vista para editar el perfil del usuario
        return view('profile.edit', [
            'user' => Auth::user(),  // Obtiene el usuario autenticado
        ]);
    }

    /**
     * Actualizar la información del perfil.
     */
    public function update(UserProfileUpdateRequest $request): RedirectResponse
    {
        // Rellenamos los campos del usuario con los datos validados
        $request->user()->fill($request->validated());

        // Si el email ha cambiado, lo marcamos como no verificado
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Guardamos los cambios en el perfil del usuario
        $request->user()->save();

        // Redirigimos de vuelta con un mensaje de éxito
        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }
}
