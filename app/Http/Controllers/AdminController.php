<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pickup;
use App\Models\Localidad;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /** /admin/users */
    public function index()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /** /admin/users/{user}/edit */
    public function edit(User $user)
    {
        return view('admin.edit', compact('user'));
    }

    /** PATCH /admin/users/{user} */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'cedula'   => ['required','string','max:30',  Rule::unique('users','cedula')->ignore($user->id)],
            'telefono' => ['required','string','max:30'],
            'role'     => ['required','in:admin,user'],
        ]);

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('status', 'Usuario actualizado correctamente');
    }

    /**
     * /admin/pickups  -> resources/views/admin/pickups.blade.php
     * Lista todas las recolecciones con filtros y paginación.
     */
    public function managePickups(Request $request)
    {
        $filters = $request->only([
            'q', 'tipo_residuo', 'estado', 'localidad_id', 'desde', 'hasta', 'modalidad', // ← agregado
        ]);

        $pickups = Pickup::with([
                'user:id,name,email,telefono',
                'localidad:id,nombre',
            ])
            ->when($filters['q'] ?? null, function ($q, $term) {
                $q->whereHas('user', function ($uq) use ($term) {
                    $uq->where('name', 'like', "%{$term}%")
                       ->orWhere('email', 'like', "%{$term}%");
                });
            })
            ->when($filters['tipo_residuo'] ?? null, fn ($q, $v) => $q->where('tipo_residuo', $v))
            ->when($filters['estado'] ?? null,       fn ($q, $v) => $q->where('estado', $v))
            ->when($filters['localidad_id'] ?? null, fn ($q, $v) => $q->where('localidad_id', $v))
            ->when($filters['modalidad'] ?? null,    fn ($q, $v) => $q->where('modalidad', $v)) // ← agregado
            ->when($filters['desde'] ?? null,        fn ($q, $v) => $q->whereDate('fecha_programada', '>=', $v))
            ->when($filters['hasta'] ?? null,        fn ($q, $v) => $q->whereDate('fecha_programada', '<=', $v))
            ->orderByDesc('fecha_programada')
            ->orderBy('hora_programada')
            ->paginate(15)
            ->withQueryString();

        $localidades = Localidad::orderBy('nombre')->get(['id','nombre']);

        return view('admin.pickups', compact('pickups', 'filters', 'localidades'));
    }

    /**
     * GET /admin/pickups/export  (route: admin.pickups.export)
     * Exporta a CSV respetando los mismos filtros (incluye modalidad).
     */
    public function exportPickupsCsv(Request $request)
    {
        $filters = $request->only([
            'q', 'tipo_residuo', 'estado', 'localidad_id', 'desde', 'hasta', 'modalidad', // ← agregado
        ]);

        $query = Pickup::with(['user:id,name,email,telefono', 'localidad:id,nombre'])
            ->when($filters['q'] ?? null, function ($q, $term) {
                $q->whereHas('user', function ($uq) use ($term) {
                    $uq->where('name', 'like', "%{$term}%")
                       ->orWhere('email', 'like', "%{$term}%");
                });
            })
            ->when($filters['tipo_residuo'] ?? null, fn ($q, $v) => $q->where('tipo_residuo', $v))
            ->when($filters['estado'] ?? null,       fn ($q, $v) => $q->where('estado', $v))
            ->when($filters['localidad_id'] ?? null, fn ($q, $v) => $q->where('localidad_id', $v))
            ->when($filters['modalidad'] ?? null,    fn ($q, $v) => $q->where('modalidad', $v)) // ← agregado
            ->when($filters['desde'] ?? null,        fn ($q, $v) => $q->whereDate('fecha_programada', '>=', $v))
            ->when($filters['hasta'] ?? null,        fn ($q, $v) => $q->whereDate('fecha_programada', '<=', $v))
            ->orderByDesc('fecha_programada')
            ->orderBy('hora_programada');

        $filename = 'pickups_' . now()->format('Ymd_His') . '.csv';

        return response()->stream(function () use ($query) {
            // echo "\xEF\xBB\xBF"; // opcional BOM UTF-8
            $out = fopen('php://output', 'w');

            fputcsv($out, [
                'ID','Usuario','Email','Telefono','Tipo','Direccion','Localidad','Fecha','Hora','Modalidad','Estado','Creado',
            ]);

            $query->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $pk) {
                    fputcsv($out, [
                        $pk->id,
                        optional($pk->user)->name,
                        optional($pk->user)->email,
                        optional($pk->user)->telefono,
                        $pk->tipo_residuo,
                        $pk->direccion,
                        optional($pk->localidad)->nombre,
                        optional($pk->fecha_programada)?->format('Y-m-d'),
                        $pk->hora_programada,
                        $pk->modalidad, // ← agregado
                        $pk->estado,
                        optional($pk->created_at)?->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($out);
        }, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
