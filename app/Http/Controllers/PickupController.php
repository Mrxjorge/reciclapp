<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use App\Models\Localidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PickupController extends Controller
{
    // Mapa orgánicos: localidad -> día de semana (Carbon: SUNDAY=0 ... SATURDAY=6)
    private const MAPA_ORGANICOS = [
        'Usaquén' => Carbon::MONDAY, 'Chapinero' => Carbon::MONDAY, 'Teusaquillo' => Carbon::MONDAY,
        'Suba' => Carbon::TUESDAY, 'Engativá' => Carbon::TUESDAY, 'Barrios Unidos' => Carbon::TUESDAY,
        'Fontibón' => Carbon::WEDNESDAY, 'Puente Aranda' => Carbon::WEDNESDAY, 'Antonio Nariño' => Carbon::WEDNESDAY,
        'Santa Fe' => Carbon::THURSDAY, 'Los Mártires' => Carbon::THURSDAY, 'La Candelaria' => Carbon::THURSDAY,
        'San Cristóbal' => Carbon::FRIDAY, 'Rafael Uribe Uribe' => Carbon::FRIDAY, 'Tunjuelito' => Carbon::FRIDAY,
        'Usme' => Carbon::SATURDAY, 'Ciudad Bolívar' => Carbon::SATURDAY, 'Sumapaz' => Carbon::SATURDAY,
        'Bosa' => Carbon::SUNDAY, 'Kennedy' => Carbon::SUNDAY,
    ];

    public function index()
    {
        $pickups = Pickup::with('localidad')
            ->where('user_id', Auth::id())
            ->orderByDesc('fecha_programada')
            ->orderBy('hora_programada')
            ->get();

        return view('pickups.index', compact('pickups'));
    }

    public function create()
    {
        return view('pickups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_residuo'     => ['required', 'in:organico,inorganico,peligroso'],
            'direccion'        => ['required', 'string', 'max:255'],
            'localidad_id'     => ['required', 'exists:localidades,id'],
            'modalidad'        => ['nullable', 'in:programada,demanda'],
            'fecha_programada' => ['nullable', 'date'],
            'hora_programada'  => ['nullable', 'date_format:H:i'],
        ]);

        $tipo      = $request->tipo_residuo;
        $modalidad = $request->modalidad;
        $loc       = Localidad::find($request->localidad_id);

        $fecha = $request->filled('fecha_programada') ? Carbon::parse($request->fecha_programada) : null;
        $hora  = $request->hora_programada;

        if ($tipo === 'organico') {
            $weekday = self::MAPA_ORGANICOS[$loc->nombre] ?? null;
            if ($weekday === null) {
                return back()->withErrors(['localidad_id' => 'La localidad no tiene día asignado para orgánicos.'])->withInput();
            }
            $hoy = Carbon::today();
            $proxima = method_exists($hoy, 'nextOrCurrent') ? $hoy->copy()->nextOrCurrent($weekday)
                                                            : (function ($d, $w) { while ($d->dayOfWeek !== $w) $d->addDay(); return $d; })($hoy->copy(), $weekday);
            $fecha     = $proxima;
            $hora      = null;
            $modalidad = 'programada';
        } elseif ($tipo === 'inorganico') {
            if (!$modalidad) {
                return back()->withErrors(['modalidad' => 'Selecciona la modalidad (programada o demanda).'])->withInput();
            }
            if (!$fecha) {
                return back()->withErrors(['fecha_programada' => 'La fecha es obligatoria para inorgánicos.'])->withInput();
            }
            $inicioSemana = $fecha->copy()->startOfWeek(Carbon::MONDAY);
            $finSemana    = $fecha->copy()->endOfWeek(Carbon::SUNDAY);
            $yaTiene = Pickup::where('user_id', Auth::id())
                ->where('tipo_residuo', 'inorganico')
                ->whereBetween('fecha_programada', [$inicioSemana, $finSemana])
                ->count();
            if ($yaTiene >= 2) {
                return back()->withErrors(['fecha_programada' => 'Límite alcanzado: máximo 2 recolecciones de inorgánicos por semana.'])->withInput();
            }
        } elseif ($tipo === 'peligroso') {
            if (!$fecha) {
                return back()->withErrors(['fecha_programada' => 'La fecha es obligatoria para peligrosos.'])->withInput();
            }
            if (!$hora) {
                return back()->withErrors(['hora_programada' => 'La hora es obligatoria para peligrosos.'])->withInput();
            }
            $inicioMes = $fecha->copy()->startOfMonth();
            $finMes    = $fecha->copy()->endOfMonth();
            $existeMes = Pickup::where('user_id', Auth::id())
                ->where('tipo_residuo', 'peligroso')
                ->whereBetween('fecha_programada', [$inicioMes, $finMes])
                ->exists();
            if ($existeMes) {
                return back()->withErrors(['fecha_programada' => 'Sólo se permite una recolección de peligrosos por mes.'])->withInput();
            }
            $modalidad = 'programada';
        }

        // 👇 fuerza el valor final de modalidad (evita que quede 'programada' por default si llega null)
        $modalidadFinal = match ($tipo) {
            'organico', 'peligroso' => 'programada',
            'inorganico'            => ($modalidad === 'demanda' ? 'demanda' : 'programada'),
            default                 => 'programada',
        };

        Pickup::create([
            'user_id'          => Auth::id(),
            'tipo_residuo'     => $tipo,
            'modalidad'        => $modalidadFinal,
            'direccion'        => $request->direccion,
            'localidad_id'     => $request->localidad_id,
            'fecha_programada' => $fecha?->toDateString(),
            'hora_programada'  => $hora,
            'estado'           => 'programada',
        ]);

        return redirect()->route('pickups.index')->with('status', 'Recolección programada correctamente');
    }

    public function edit(Pickup $pickup)
    {
        abort_if($pickup->user_id !== Auth::id(), 403);
        return view('pickups.edit', compact('pickup'));
    }

    public function update(Request $request, Pickup $pickup)
    {
        abort_if($pickup->user_id !== Auth::id(), 403);

        $request->validate([
            'tipo_residuo'     => ['required', 'in:organico,inorganico,peligroso'],
            'direccion'        => ['required', 'string', 'max:255'],
            'localidad_id'     => ['required', 'exists:localidades,id'],
            'modalidad'        => ['nullable', 'in:programada,demanda'],
            'fecha_programada' => ['nullable', 'date'],
            'hora_programada'  => ['nullable', 'date_format:H:i'],
        ]);

        $tipo      = $request->tipo_residuo;
        $modalidad = $request->modalidad;
        $loc       = Localidad::find($request->localidad_id);

        $fecha = $request->filled('fecha_programada') ? Carbon::parse($request->fecha_programada) : null;
        $hora  = $request->hora_programada;

        if ($tipo === 'organico') {
            $weekday = self::MAPA_ORGANICOS[$loc->nombre] ?? null;
            if ($weekday === null) {
                return back()->withErrors(['localidad_id' => 'La localidad no tiene día asignado para orgánicos.'])->withInput();
            }
            $hoy = Carbon::today();
            $proxima = method_exists($hoy, 'nextOrCurrent') ? $hoy->copy()->nextOrCurrent($weekday)
                                                            : (function ($d, $w) { while ($d->dayOfWeek !== $w) $d->addDay(); return $d; })($hoy->copy(), $weekday);
            $fecha     = $proxima;
            $hora      = null;
            $modalidad = 'programada';
        } elseif ($tipo === 'inorganico') {
            if (!$modalidad) {
                return back()->withErrors(['modalidad' => 'Selecciona la modalidad.'])->withInput();
            }
            if (!$fecha) {
                return back()->withErrors(['fecha_programada' => 'La fecha es obligatoria para inorgánicos.'])->withInput();
            }
            $inicioSemana = $fecha->copy()->startOfWeek(Carbon::MONDAY);
            $finSemana    = $fecha->copy()->endOfWeek(Carbon::SUNDAY);
            $yaTiene = Pickup::where('user_id', Auth::id())
                ->where('tipo_residuo', 'inorganico')
                ->whereBetween('fecha_programada', [$inicioSemana, $finSemana])
                ->where('id', '!=', $pickup->id)
                ->count();
            if ($yaTiene >= 2) {
                return back()->withErrors(['fecha_programada' => 'Límite de 2 inorgánicos por semana alcanzado.'])->withInput();
            }
        } elseif ($tipo === 'peligroso') {
            if (!$fecha) {
                return back()->withErrors(['fecha_programada' => 'La fecha es obligatoria.'])->withInput();
            }
            if (!$hora) {
                return back()->withErrors(['hora_programada' => 'La hora es obligatoria.'])->withInput();
            }
            $inicioMes = $fecha->copy()->startOfMonth();
            $finMes    = $fecha->copy()->endOfMonth();
            $existeMes = Pickup::where('user_id', Auth::id())
                ->where('tipo_residuo', 'peligroso')
                ->whereBetween('fecha_programada', [$inicioMes, $finMes])
                ->where('id', '!=', $pickup->id)
                ->exists();
            if ($existeMes) {
                return back()->withErrors(['fecha_programada' => 'Sólo se permite una recolección de peligrosos por mes.'])->withInput();
            }
            $modalidad = 'programada';
        }

        // 👇 fuerza la modalidad final también en update
        $modalidadFinal = match ($tipo) {
            'organico', 'peligroso' => 'programada',
            'inorganico'            => ($modalidad === 'demanda' ? 'demanda' : 'programada'),
            default                 => 'programada',
        };

        $pickup->update([
            'tipo_residuo'     => $tipo,
            'modalidad'        => $modalidadFinal,
            'direccion'        => $request->direccion,
            'localidad_id'     => $request->localidad_id,
            'fecha_programada' => $fecha?->toDateString(),
            'hora_programada'  => $hora,
        ]);

        return redirect()->route('pickups.index')->with('status', 'Recolección reprogramada correctamente');
    }

    public function destroy(Pickup $pickup)
    {
        abort_if($pickup->user_id !== Auth::id(), 403);
        $pickup->delete();

        return redirect()->route('pickups.index')->with('status', 'Recolección eliminada correctamente');
    }
}
