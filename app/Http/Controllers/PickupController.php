<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PickupController extends Controller
{
    // Mostrar todas las recolecciones de un usuario
    public function index()
    {
        $pickups = Pickup::where('user_id', Auth::id())->get();
        return view('pickups.index', compact('pickups'));
    }

    // Mostrar el formulario para crear una nueva recolección
    public function create()
    {
        return view('pickups.create');
    }

    // Almacenar una nueva recolección
    public function store(Request $request)
    {
        // Validación de los campos requeridos
        $request->validate([
            'tipo_residuo' => 'required|string',
            'fecha_programada' => 'required|date',
            'hora_programada' => 'nullable|date_format:H:i',
            'modalidad' => 'required|string',  // Validación de modalidad
            'estado' => 'required|string',     // Validación de estado
        ]);

        // Creación de la recolección
        Pickup::create([
            'user_id' => Auth::id(),  // Guardamos el ID del usuario autenticado
            'tipo_residuo' => $request->tipo_residuo,
            'subtipo' => $request->subtipo, 
            'modalidad' => $request->modalidad,
            'frecuencia_semana' => $request->frecuencia_semana, 
            'fecha_programada' => $request->fecha_programada,
            'hora_programada' => $request->hora_programada,
            'estado' => $request->estado, 
        ]);

        return redirect()->route('pickups.index')->with('status', 'Recolección programada correctamente');
    }

    // Mostrar el formulario para editar una recolección
    public function edit(Pickup $pickup)
    {
        return view('pickups.edit', compact('pickup'));
    }

    // Actualizar una recolección
    public function update(Request $request, Pickup $pickup)
    {
        // Validación de los campos requeridos
        $request->validate([
            'tipo_residuo' => 'required|string',
            'fecha_programada' => 'required|date',
            'hora_programada' => 'nullable|date_format:H:i',
            'modalidad' => 'required|string',
            'estado' => 'required|string',
        ]);

        // Verificar que el usuario autenticado esté autorizado a modificar la recolección
        if ($pickup->user_id !== Auth::id()) {
            return redirect()->route('pickups.index')->with('error', 'No autorizado');
        }

        // Actualización de los datos
        $pickup->update([
            'tipo_residuo' => $request->tipo_residuo,
            'subtipo' => $request->subtipo,
            'modalidad' => $request->modalidad,
            'frecuencia_semana' => $request->frecuencia_semana, 
            'fecha_programada' => $request->fecha_programada,
            'hora_programada' => $request->hora_programada,
            'estado' => $request->estado ?? $pickup->estado, // Si no se pasa un nuevo estado, mantenemos el actual
        ]);

        return redirect()->route('pickups.index')->with('status', 'Recolección actualizada correctamente');
    }

    // Eliminar una recolección
    public function destroy(Pickup $pickup)
    {
        // Verificar que el usuario autenticado esté autorizado a eliminar la recolección
        if ($pickup->user_id !== Auth::id()) {
            return redirect()->route('pickups.index')->with('error', 'No autorizado');
        }

        // Eliminar la recolección
        $pickup->delete();

        return redirect()->route('pickups.index')->with('status', 'Recolección eliminada correctamente');
    }
}
