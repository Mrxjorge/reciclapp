<x-app-layout full-width>
  <x-slot name="header">
    <span class="sr-only">Dashboard</span>
  </x-slot>

  @php
    $typeMeta = [
      'organico' => [
        'label' => 'Orgánica',
        'chip' => 'chip chip--brand',
        'text' => 'text-brand-700',
        'dot' => 'bg-brand-500',
      ],
      'inorganico' => [
        'label' => 'Inorgánica',
        'chip' => 'chip chip--blue',
        'text' => 'text-inorganico',
        'dot' => 'bg-inorganico',
      ],
      'peligroso' => [
        'label' => 'Peligrosa',
        'chip' => 'chip chip--red',
        'text' => 'text-peligroso',
        'dot' => 'bg-peligroso',
      ],
    ];

    $statusMeta = [
      'programada' => 'badge badge--brand',
      'completada' => 'inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700',
      'cancelada' => 'inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-600',
    ];

    $pointsForPickup = function ($pickup) {
      $base = match ($pickup->tipo_residuo) {
        'organico' => 60,
        'inorganico' => 80,
        'peligroso' => 120,
        default => 50,
      };

      $weightBonus = ($pickup->kilos ?? 0) * 12;

      return (int) round($base + $weightBonus);
    };
  @endphp

  <div class="w-full">
    <div class="flex min-h-screen">
      @include('layouts._sidebar')

      <div class="flex-1 bg-gray-50 min-h-screen">
        <div class="px-4 sm:px-6 lg:px-10 py-8 space-y-8">

          <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
            <section class="xl:col-span-8 relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-500 via-brand-600 to-brand-700 text-white shadow-soft">
              <div class="absolute inset-0 bg-[url('/images/hero-eco.jpg')] bg-cover bg-right opacity-20 mix-blend-soft-light"></div>
              <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-brand-900/40"></div>
              <div class="relative z-10 p-6 md:p-10 flex flex-col gap-6 lg:flex-row lg:items-center">
                <div class="flex-1 space-y-6">
                  <span class="badge badge--light">{{ $level['badge'] }}</span>
                  <div class="space-y-2">
                    <h1 class="text-3xl md:text-4xl font-black">¡Hola de nuevo, {{ $firstName ?? $user->name }}! 🌱</h1>
                    <p class="text-white/80 max-w-xl text-base md:text-lg">
                      {{ $level['message'] }}
                    </p>
                  </div>
                  <div class="flex flex-wrap gap-3">
                    <a href="{{ route('pickups.create') }}" class="btn btn--primary bg-white text-brand-700 hover:bg-brand-100">
                      Programar recolección
                    </a>
                    <a href="{{ url('/u/puntos') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-white/40 text-white hover:bg-white/10">
                      Ver recompensas
                    </a>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm lg:w-72">
                  <div class="rounded-2xl bg-white/15 p-4 backdrop-blur">
                    <p class="text-white/70">Kg reciclados</p>
                    <p class="text-3xl font-semibold">{{ number_format($totalKilos, 1) }}</p>
                    <span class="text-xs text-emerald-100">Acumulado en Reciclapp</span>
                  </div>
                  <div class="rounded-2xl bg-white/15 p-4 backdrop-blur">
                    <p class="text-white/70">CO₂ evitado</p>
                    <p class="text-3xl font-semibold">{{ number_format($co2Avoided, 1) }} kg</p>
                    <span class="text-xs text-emerald-100">Estimación basada en tus entregas</span>
                  </div>
                  <div class="rounded-2xl bg-white/15 p-4 backdrop-blur col-span-2">
                    <p class="text-white/70">Racha activa</p>
                    @if($streakDays > 0)
                      <p class="text-3xl font-semibold flex items-center gap-2">
                        {{ $streakDays }} {{ $streakDays === 1 ? 'día' : 'días' }}
                        <span class="text-sm font-normal text-white/70">con recolecciones completadas consecutivas</span>
                      </p>
                    @else
                      <p class="text-3xl font-semibold flex items-center gap-2">—
                        <span class="text-sm font-normal text-white/70">Agenda recolecciones para iniciar una racha</span>
                      </p>
                    @endif
                  </div>
                </div>
              </div>
            </section>

            <div class="xl:col-span-4 space-y-6">
              <div class="card h-full">
                <div class="flex items-start justify-between">
                  <div>
                    <h2 class="text-lg font-semibold">Acciones rápidas</h2>
                    <p class="text-sm text-gray-500">Gestiona tus tareas frecuentes en segundos.</p>
                  </div>
                  <span class="badge badge--brand">Actualizado</span>
                </div>
                <ul class="mt-4 space-y-3">
                  <li>
                    <a href="{{ route('pickups.create') }}" class="flex items-center gap-3 rounded-2xl border border-gray-100 px-4 py-3 hover:border-brand-300 hover:bg-brand-50/60 transition">
                      <span class="text-xl">📍</span>
                      <div>
                        <p class="font-medium">Programar recolección puntual</p>
                        <p class="text-xs text-gray-500">Selecciona día y tipo de residuo</p>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('/u/historial') }}" class="flex items-center gap-3 rounded-2xl border border-gray-100 px-4 py-3 hover:border-brand-300 hover:bg-brand-50/60 transition">
                      <span class="text-xl">🗂️</span>
                      <div>
                        <p class="font-medium">Revisar historial completo</p>
                        <p class="text-xs text-gray-500">Descarga tus comprobantes</p>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="{{ url('/profile') }}" class="flex items-center gap-3 rounded-2xl border border-gray-100 px-4 py-3 hover:border-brand-300 hover:bg-brand-50/60 transition">
                      <span class="text-xl">⚙️</span>
                      <div>
                        <p class="font-medium">Actualizar preferencias</p>
                        <p class="text-xs text-gray-500">Configura horarios y recordatorios</p>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="card">
                <h3 class="text-lg font-semibold">Eco-tip del día</h3>
                <p class="mt-2 text-sm text-gray-600">
                  Mantén tus residuos secos y limpios para obtener más puntos y facilitar el reciclaje. Las bolsas compostables ayudan a reducir olores.
                </p>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-4 card">
              <div class="flex items-start justify-between">
                <div>
                  <h3 class="text-lg font-semibold">Próxima recolección</h3>
                  @if($upcomingPickup)
                    <p class="text-sm text-gray-500">
                      {{ optional($upcomingPickup->localidad)->nombre ?? 'Dirección registrada' }} · {{ ucfirst($upcomingPickup->modalidad ?? 'programada') }}
                    </p>
                  @else
                    <p class="text-sm text-gray-500">Aún no tienes una recolección programada.</p>
                  @endif
                </div>
                @if($upcomingPickup)
                  @php $type = $upcomingPickup->tipo_residuo; @endphp
                  <span class="{{ $typeMeta[$type]['chip'] ?? 'chip' }}">{{ $typeMeta[$type]['label'] ?? ucfirst($type) }}</span>
                @endif
              </div>

              @if($upcomingPickup)
                <div class="mt-4 flex items-center justify-between">
                  <div>
                    <p class="text-3xl font-bold text-brand-700">
                      {{ optional($upcomingPickup->fecha_programada)->translatedFormat('d M') }}
                    </p>
                    <p class="text-sm text-gray-500">
                      {{ $upcomingPickup->hora_programada ? \Illuminate\Support\Carbon::parse($upcomingPickup->hora_programada)->format('H:i') : 'Horario por confirmar' }}
                    </p>
                  </div>
                  <div class="text-right text-sm text-gray-500">
                    <p class="font-medium text-gray-700">Estado</p>
                    <p class="capitalize">{{ $upcomingPickup->estado }}</p>
                  </div>
                </div>
                <div class="mt-4 flex items-center gap-3 text-sm text-gray-600">
                  <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-brand-50 text-brand-600">🚚</span>
                  <span>
                    {{ $upcomingPickup->estado === 'programada' ? 'Te notificaremos cuando la ruta esté confirmada.' : 'Ruta confirmada, te avisaremos antes de la llegada.' }}
                  </span>
                </div>
                <div class="mt-5 flex items-center gap-3">
                  <a href="{{ route('pickups.edit', $upcomingPickup) }}" class="btn btn--outline text-sm">Reprogramar</a>
                  <a href="{{ route('pickups.index') }}" class="text-sm font-medium text-brand-700">Ver lista completa</a>
                </div>
              @else
                <div class="mt-5">
                  <a href="{{ route('pickups.create') }}" class="btn btn--primary w-full">Programar primera recolección</a>
                </div>
              @endif
            </div>

            <div class="lg:col-span-4 card">
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Tus puntos</h3>
                <span class="chip chip--blue">+{{ number_format($pointsThisMonth) }} este mes</span>
              </div>
              <div class="mt-4 rounded-2xl bg-gradient-to-br from-brand-100 via-white to-brand-50 p-5">
                <p class="text-sm text-brand-700">Acumulados</p>
                <p class="mt-1 text-5xl font-black tracking-tight">{{ number_format($pointsTotal) }}</p>
                <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                  <span>Meta del mes</span>
                  <span>{{ number_format($pointsGoal) }} pts</span>
                </div>
                <div class="progress mt-2">
                  <div class="progress__bar" style="width: {{ $pointsProgress }}%"></div>
                </div>
              </div>
              <button class="btn btn--primary mt-4 w-full" onclick="window.location='{{ url('/u/puntos') }}'">Canjear recompensas</button>
            </div>

            <div class="lg:col-span-4 card">
              <div class="flex items-start justify-between">
                <div>
                  <h3 class="text-lg font-semibold">Impacto de la semana</h3>
                  <p class="text-sm text-gray-500">Actualizado {{ \Illuminate\Support\Carbon::now()->translatedFormat('d \d\e F \a\ \l\a\s H:i') }}</p>
                </div>
                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Seguimiento</span>
              </div>
              <div class="mt-5 grid grid-cols-2 gap-4 text-sm">
                @foreach($impactWeek as $type => $impact)
                  @php
                    $cardStyles = match($type) {
                      'organico' => 'rounded-2xl bg-brand-50 p-4 text-brand-700',
                      'inorganico' => 'rounded-2xl bg-blue-50 p-4 text-inorganico',
                      'peligroso' => 'rounded-2xl bg-red-50 p-4 text-peligroso',
                      default => 'rounded-2xl bg-gray-50 p-4 text-gray-700',
                    };
                  @endphp
                  <div class="{{ $loop->last ? 'col-span-2 ' : '' }}{{ $cardStyles }}">
                    <p class="font-semibold">{{ $impact['label'] }}</p>
                    <p class="text-2xl font-bold">{{ $impact['kg'] > 0 ? $impact['kg'] : '0' }} kg</p>
                    <span class="text-xs opacity-70">Meta {{ $impact['goal'] }} kg</span>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
            <div class="xl:col-span-7 card">
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Recolecciones recientes</h3>
                <a href="{{ route('pickups.index') }}" class="text-sm font-medium text-brand-700">Ver historial</a>
              </div>
              <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                  <thead>
                    <tr class="text-left text-gray-500 border-b">
                      <th class="py-2 font-medium">Fecha</th>
                      <th class="py-2 font-medium">Tipo</th>
                      <th class="py-2 font-medium">Kg</th>
                      <th class="py-2 font-medium">Puntos</th>
                      <th class="py-2 font-medium">Estado</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-100">
                    @forelse($recentPickups as $pickup)
                      @php
                        $type = $pickup->tipo_residuo;
                        $typeLabel = $typeMeta[$type]['label'] ?? ucfirst($type);
                        $typeClass = $typeMeta[$type]['text'] ?? 'text-gray-700';
                        $statusClass = $statusMeta[$pickup->estado] ?? 'badge badge--brand';
                        $points = $pointsForPickup($pickup);
                      @endphp
                      <tr class="hover:bg-gray-50">
                        <td class="py-3">{{ optional($pickup->fecha_programada)->translatedFormat('d/m/Y') ?? '—' }}</td>
                        <td class="py-3 font-medium {{ $typeClass }}">{{ $typeLabel }}</td>
                        <td>{{ $pickup->kilos !== null ? number_format($pickup->kilos, 1) : '—' }}</td>
                        <td>{{ number_format($points) }}</td>
                        <td>
                          <span class="{{ $statusClass }} capitalize">{{ $pickup->estado }}</span>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td class="py-6 text-center text-gray-500" colspan="5">
                          Aún no registras recolecciones. Programa la primera para ver tu historial aquí.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>

            <div class="xl:col-span-5 card">
              <div class="flex items-center justify-between">
                <div>
                  <h3 class="text-lg font-semibold">Calendario de recolecciones</h3>
                  <p class="text-sm text-gray-500">{{ $calendarMonthLabel }}</p>
                </div>
                <div class="flex items-center gap-2">
                  <button class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-gray-200 text-gray-500" disabled>‹</button>
                  <button class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-gray-200 text-gray-500" disabled>›</button>
                </div>
              </div>
              <div class="mt-5 grid grid-cols-7 gap-2 text-center text-xs text-gray-400">
                <div>D</div><div>L</div><div>M</div><div>M</div><div>J</div><div>V</div><div>S</div>
              </div>
              <div class="mt-2 space-y-2 text-center text-sm">
                @foreach($calendarWeeks as $week)
                  <div class="grid grid-cols-7 gap-2">
                    @foreach($week as $day)
                      @if($day)
                        @php
                          $hasPickups = $day['pickups']->isNotEmpty();
                          $dayClasses = 'relative rounded-xl py-3 font-semibold transition '; 
                          $dayClasses .= $hasPickups ? 'bg-white border border-brand-100 shadow-sm text-gray-700 ' : 'text-gray-600 ';
                          $dayClasses .= $day['isToday'] ? 'bg-brand-50 ring-2 ring-brand-200 ' : ($day['isPast'] && !$hasPickups ? 'text-gray-300 ' : 'hover:bg-gray-50 ');
                        @endphp
                        <div class="{{ trim($dayClasses) }}">
                          <span>{{ $day['day'] }}</span>
                          @if($hasPickups)
                            <div class="absolute inset-x-4 bottom-1 flex items-center justify-center gap-1">
                              @foreach($day['pickups']->take(3) as $pickup)
                                @php $dotType = $pickup->tipo_residuo; @endphp
                                <span class="h-1.5 w-1.5 rounded-full {{ $typeMeta[$dotType]['dot'] ?? 'bg-gray-400' }}"></span>
                              @endforeach
                            </div>
                            @if($day['pickups']->count() > 3)
                              <span class="absolute right-2 top-2 text-[10px] text-gray-400">+{{ $day['pickups']->count() - 3 }}</span>
                            @endif
                          @else
                            <span class="absolute inset-x-3 bottom-1 text-[10px] font-medium text-emerald-500">Libre</span>
                          @endif
                        </div>
                      @else
                        <div class="h-12 rounded-xl"></div>
                      @endif
                    @endforeach
                  </div>
                @endforeach
              </div>
              <div class="mt-5 grid grid-cols-3 gap-3 text-xs">
                <span class="chip chip--brand flex items-center justify-center gap-2"><span class="w-2 h-2 rounded-full bg-brand-500"></span>Orgánico</span>
                <span class="chip chip--blue flex items-center justify-center gap-2"><span class="w-2 h-2 rounded-full bg-inorganico"></span>Inorgánico</span>
                <span class="chip chip--red flex items-center justify-center gap-2"><span class="w-2 h-2 rounded-full bg-peligroso"></span>Peligroso</span>
              </div>
              <div class="mt-4 space-y-2 text-sm text-gray-600">
                <div class="flex items-center justify-between">
                  <span>Días disponibles este mes</span>
                  <span class="font-semibold text-brand-700">{{ $availableSlotsCount }}</span>
                </div>
                <div class="text-xs text-gray-500">
                  @if($nextAvailableDates->isNotEmpty())
                    Próximas fechas libres: <span class="font-medium text-brand-700">{{ $nextAvailableDates->join(', ') }}</span>
                  @else
                    No quedan fechas libres en lo que resta del mes. Puedes reprogramar alguna recolección si necesitas liberar espacio.
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-4">
            <div class="lg:col-span-5 card bg-gradient-to-br from-brand-50 via-white to-brand-100">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-brand-600/10 text-brand-700 grid place-content-center text-xl">🗺️</div>
                <div>
                  <h3 class="text-lg font-semibold">Mi ruta de hoy</h3>
                  <p class="text-sm text-gray-500">Seguimiento estimado de los recolectores</p>
                </div>
              </div>
              <div class="mt-5 timeline">
                <div class="timeline__item">
                  <span class="timeline__bullet"></span>
                  <div class="timeline__content">
                    <p class="font-semibold text-gray-800">08:30 · Punto de partida</p>
                    <p>El camión inicia la ruta en el centro logístico.</p>
                  </div>
                </div>
                <div class="timeline__item">
                  <span class="timeline__bullet"></span>
                  <div class="timeline__content">
                    <p class="font-semibold text-gray-800">
                      {{ $upcomingPickup ? optional($upcomingPickup->fecha_programada)->translatedFormat('H:i') ?? '10:10' : '10:10' }} · Tu visita estimada
                    </p>
                    <p>{{ $upcomingPickup ? 'Te avisaremos 20 minutos antes de la llegada.' : 'Programa una recolección para recibir una estimación de visita.' }}</p>
                  </div>
                </div>
                <div class="timeline__item">
                  <span class="timeline__bullet"></span>
                  <div class="timeline__content">
                    <p class="font-semibold text-gray-800">12:00 · Cierre de ruta</p>
                    <p>Entrega consolidada en la planta de tratamiento.</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="lg:col-span-4 card">
              <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-2xl bg-brand-100 grid place-content-center text-lg">✅</div>
                <div>
                  <h3 class="text-lg font-semibold">Recolección programada</h3>
                  @if($upcomingPickup)
                    <p class="text-sm text-gray-600">Confirmada para el <span class="font-semibold text-brand-700">{{ optional($upcomingPickup->fecha_programada)->translatedFormat('d \d\e F') }}</span>.</p>
                  @else
                    <p class="text-sm text-gray-600">Programa tu próxima recolección para recibir recordatorios personalizados.</p>
                  @endif
                  <p class="mt-3 text-xs text-gray-500">Puedes reprogramar hasta las 18:00 del día anterior.</p>
                </div>
              </div>
              <div class="mt-4 rounded-2xl bg-brand-50/60 p-4 text-sm text-brand-700">
                <p class="font-semibold">Consejo:</p>
                <p>Separa restos de comida en bolsas compostables y enjuaga envases antes de entregarlos.</p>
              </div>
            </div>

            <div class="lg:col-span-3 card">
              <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-2xl bg-brand-100 grid place-content-center text-lg">🔔</div>
                <div>
                  <h3 class="text-lg font-semibold">Recordatorios</h3>
                  <p class="text-sm text-gray-600">Configura tus alertas para no perder recompensas.</p>
                </div>
              </div>
              <ul class="mt-4 space-y-3 text-sm text-gray-600">
                <li class="flex items-center gap-2"><span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-brand-50 text-brand-600 text-xs">1</span> Recordatorio por SMS {{ $upcomingPickup ? 'activado' : 'disponible' }}</li>
                <li class="flex items-center gap-2"><span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-brand-50 text-brand-600 text-xs">2</span> Correo de resumen semanal</li>
                <li class="flex items-center gap-2"><span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-brand-50 text-brand-600 text-xs">3</span> Encuesta de satisfacción tras cada recolección</li>
              </ul>
              <a href="{{ url('/profile') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-brand-700">Gestionar alertas →</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
