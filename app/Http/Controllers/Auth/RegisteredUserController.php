<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // La vista leerá las localidades directamente del modelo (select en Blade),
        // así que no es necesario pasar datos aquí.
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'     => ['required', 'confirmed', Rules\Password::defaults()],

            // NUEVOS CAMPOS
            'cedula'       => ['required', 'string', 'max:30', 'unique:users,cedula'],
            'direccion'    => ['required', 'string', 'max:255'],
            'telefono'     => ['required', 'string', 'max:30'],
            'localidad_id' => ['required', 'exists:localidades,id'],
        ]);

        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),

            // NUEVOS CAMPOS
            'cedula'       => $request->cedula,
            'direccion'    => $request->direccion,
            'telefono'     => $request->telefono,
            'localidad_id' => $request->localidad_id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
