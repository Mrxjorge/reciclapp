<x-app-layout>
  <x-slot name="header">
    <span class="sr-only">Dashboard</span>
  </x-slot>

  <div class="w-full">
    <div class="flex">
      @include('layouts._sidebar')

      <div class="flex-1 bg-gray-50 min-h-screen">
        <div class="px-4 sm:px-6 lg:px-10 py-8 space-y-8">

          {{-- HERO + ACCIONES RÁPIDAS --}}
          <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
            <section class="xl:col-span-8 relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-500 via-brand-600 to-brand-700 text-white shadow-soft">
              <div class="absolute inset-0 bg-[url('/images/hero-eco.jpg')] bg-cover bg-right opacity-20 mix-blend-soft-light"></div>
              <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-brand-900/40"></div>
              <div class="relative z-10 p-6 md:p-10 flex flex-col gap-6 lg:flex-row lg:items-center">
                <div class="flex-1 space-y-6">
                  <span class="badge badge--light">Nivel Eco Avanzado</span>
                  <div class="space-y-2">
                    <h1 class="text-3xl md:text-4xl font-black">¡Hola de nuevo, Ana! 🌱</h1>
                    <p class="text-white/80 max-w-xl text-base md:text-lg">
                      Gracias por seguir reciclando con Reciclapp. Estamos acompañándote para que cada semana sea más sostenible.
                    </p>
                  </div>
                  <div class="flex flex-wrap gap-3">
                    <a href="{{ url('/u/programar') }}" class="btn btn--primary bg-white text-brand-700 hover:bg-brand-100">
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
                    <p class="text-3xl font-semibold">168</p>
                    <span class="text-xs text-emerald-100">+18% vs. mes anterior</span>
                  </div>
                  <div class="rounded-2xl bg-white/15 p-4 backdrop-blur">
                    <p class="text-white/70">CO₂ evitado</p>
                    <p class="text-3xl font-semibold">245kg</p>
                    <span class="text-xs text-emerald-100">Equivalente a 12 árboles</span>
                  </div>
                  <div class="rounded-2xl bg-white/15 p-4 backdrop-blur col-span-2">
                    <p class="text-white/70">Racha activa</p>
                    <p class="text-3xl font-semibold flex items-center gap-2">7 días <span class="text-sm font-normal text-white/70">sin omitir recolecciones</span></p>
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
                  <span class="badge badge--brand">Nuevo</span>
                </div>
                <ul class="mt-4 space-y-3">
                  <li>
                    <a href="{{ url('/u/programar') }}" class="flex items-center gap-3 rounded-2xl border border-gray-100 px-4 py-3 hover:border-brand-300 hover:bg-brand-50/60 transition">
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
                    <a href="{{ url('/perfil') }}" class="flex items-center gap-3 rounded-2xl border border-gray-100 px-4 py-3 hover:border-brand-300 hover:bg-brand-50/60 transition">
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
                  Reduce el uso de bolsas desechables guardando tus orgánicos en recipientes reutilizables. Evitarás derrames y sumarás puntos extra por materiales limpios.
                </p>
              </div>
            </div>
          </div>

          {{-- MÉTRICAS PRINCIPALES --}}
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-4 card">
              <div class="flex items-start justify-between">
                <div>
                  <h3 class="text-lg font-semibold">Próxima recolección</h3>
                  <p class="text-sm text-gray-500">Sector Centro · Ruta verde</p>
                </div>
                <span class="chip chip--brand">ORGÁNICO</span>
              </div>
              <div class="mt-4 flex items-center justify-between">
                <div>
                  <p class="text-3xl font-bold text-brand-700">1 Oct</p>
                  <p class="text-sm text-gray-500">05:00 PM</p>
                </div>
                <div class="text-right text-sm text-gray-500">
                  <p class="font-medium text-gray-700">Recolector asignado</p>
                  <p>Marcos Herrera</p>
                </div>
              </div>
              <div class="mt-4 flex items-center gap-3 text-sm text-gray-600">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-brand-50 text-brand-600">🚚</span>
                <span>Recordatorio automático 2h antes.</span>
              </div>
              <div class="mt-5 flex items-center gap-3">
                <a href="{{ url('/u/programar') }}" class="btn btn--outline text-sm">Reprogramar</a>
                <a href="{{ url('/u/historial') }}" class="text-sm font-medium text-brand-700">Ver lista completa</a>
              </div>
            </div>

            <div class="lg:col-span-4 card">
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Tus puntos</h3>
                <span class="chip chip--blue">+120 este mes</span>
              </div>
              <div class="mt-4 rounded-2xl bg-gradient-to-br from-brand-100 via-white to-brand-50 p-5">
                <p class="text-sm text-brand-700">Acumulados</p>
                <p class="mt-1 text-5xl font-black tracking-tight">1,050</p>
                <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                  <span>Meta del mes</span>
                  <span>1,250 pts</span>
                </div>
                <div class="progress mt-2">
                  <div class="progress__bar" style="width: 84%"></div>
                </div>
              </div>
              <button class="btn btn--primary mt-4 w-full" onclick="window.location='{{ url('/u/puntos') }}'">Canjear recompensas</button>
            </div>

            <div class="lg:col-span-4 card">
              <div class="flex items-start justify-between">
                <div>
                  <h3 class="text-lg font-semibold">Impacto de la semana</h3>
                  <p class="text-sm text-gray-500">Actualizado hoy a las 10:24</p>
                </div>
                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">+12%</span>
              </div>
              <div class="mt-5 grid grid-cols-2 gap-4 text-sm">
                <div class="rounded-2xl bg-brand-50 p-4">
                  <p class="text-brand-700 font-semibold">Residuos orgánicos</p>
                  <p class="text-2xl font-bold text-brand-800">26 kg</p>
                  <span class="text-xs text-brand-600">Meta 30 kg</span>
                </div>
                <div class="rounded-2xl bg-blue-50 p-4 text-inorganico">
                  <p class="font-semibold">Inorgánicos</p>
                  <p class="text-2xl font-bold">14 kg</p>
                  <span class="text-xs opacity-70">Meta 20 kg</span>
                </div>
                <div class="col-span-2 rounded-2xl bg-red-50 p-4 text-peligroso">
                  <p class="font-semibold">Residuos peligrosos</p>
                  <p class="text-2xl font-bold">2 kg</p>
                  <span class="text-xs opacity-70">Recoge antes del viernes</span>
                </div>
              </div>
            </div>
          </div>

          {{-- HISTORIAL + CALENDARIO --}}
          <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
            <div class="xl:col-span-7 card">
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Recolecciones recientes</h3>
                <a href="{{ url('/u/historial') }}" class="text-sm font-medium text-brand-700">Ver historial</a>
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
                    <tr class="hover:bg-gray-50">
                      <td class="py-3">30/09/2025</td>
                      <td class="font-medium text-peligroso">Peligrosa</td>
                      <td>5</td>
                      <td>500</td>
                      <td><span class="badge badge--brand">Confirmada</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                      <td class="py-3">15/09/2025</td>
                      <td class="font-medium text-inorganico">Inorgánica</td>
                      <td>10</td>
                      <td>120</td>
                      <td><span class="badge badge--brand">Confirmada</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                      <td class="py-3">14/09/2025</td>
                      <td class="font-medium text-brand-700">Orgánica</td>
                      <td>5</td>
                      <td>50</td>
                      <td><span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">Pendiente encuesta</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                      <td class="py-3">10/09/2025</td>
                      <td class="font-medium text-brand-700">Orgánica</td>
                      <td>10</td>
                      <td>100</td>
                      <td><span class="badge badge--brand">Confirmada</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                      <td class="py-3">05/09/2025</td>
                      <td class="font-medium text-inorganico">Inorgánica</td>
                      <td>5</td>
                      <td>60</td>
                      <td><span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">En tránsito</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                      <td class="py-3">01/09/2025</td>
                      <td class="font-medium text-brand-700">Orgánica</td>
                      <td>1</td>
                      <td>10</td>
                      <td><span class="badge badge--brand">Confirmada</span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="xl:col-span-5 card">
              <div class="flex items-center justify-between">
                <div>
                  <h3 class="text-lg font-semibold">Calendario de recolecciones</h3>
                  <p class="text-sm text-gray-500">Octubre 2025</p>
                </div>
                <div class="flex items-center gap-2">
                  <button class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:border-brand-400 hover:text-brand-600">‹</button>
                  <button class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:border-brand-400 hover:text-brand-600">›</button>
                </div>
              </div>
              <div class="mt-5 grid grid-cols-7 gap-2 text-center text-xs text-gray-400">
                <div>D</div><div>L</div><div>M</div><div>M</div><div>J</div><div>V</div><div>S</div>
              </div>
              <div class="mt-2 grid grid-cols-7 gap-2 text-center text-sm">
                @for($i=1;$i<=30;$i++)
                  @php
                    $dot = in_array($i,[1,5,9,15,20,29,30]);
                    $color = match(true){
                      in_array($i,[5,20]) => 'bg-brand-500',
                      in_array($i,[9,29]) => 'bg-red-500',
                      in_array($i,[1,15,30]) => 'bg-inorganico',
                      default => null
                    };
                  @endphp
                  <div class="relative rounded-xl py-3 font-semibold text-gray-600 {{ $i===1 ? 'bg-brand-50 ring-2 ring-brand-200' : 'hover:bg-gray-50' }}">
                    <span>{{ $i }}</span>
                    @if($dot)
                      <span class="absolute inset-x-6 bottom-1 h-1 rounded-full {{ $color }}"></span>
                    @endif
                  </div>
                @endfor
              </div>
              <div class="mt-5 grid grid-cols-3 gap-3 text-xs">
                <span class="chip chip--brand flex items-center justify-center gap-2"><span class="w-2 h-2 rounded-full bg-brand-500"></span>Orgánico</span>
                <span class="chip chip--blue flex items-center justify-center gap-2"><span class="w-2 h-2 rounded-full bg-inorganico"></span>Inorgánico</span>
                <span class="chip chip--red flex items-center justify-center gap-2"><span class="w-2 h-2 rounded-full bg-peligroso"></span>Peligroso</span>
              </div>
            </div>
          </div>

          {{-- RUTA Y NOTIFICACIONES --}}
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-4">
            <div class="lg:col-span-5 card bg-gradient-to-br from-brand-50 via-white to-brand-100">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-brand-600/10 text-brand-700 grid place-content-center text-xl">🗺️</div>
                <div>
                  <h3 class="text-lg font-semibold">Mi ruta de hoy</h3>
                  <p class="text-sm text-gray-500">Recorrido estimado de los recolectores</p>
                </div>
              </div>
              <div class="mt-5 timeline">
                <div class="timeline__item">
                  <span class="timeline__bullet"></span>
                  <div class="timeline__content">
                    <p class="font-semibold text-gray-800">08:30 · Punto de partida</p>
                    <p>Camión 12 sale del centro logístico</p>
                  </div>
                </div>
                <div class="timeline__item">
                  <span class="timeline__bullet"></span>
                  <div class="timeline__content">
                    <p class="font-semibold text-gray-800">10:10 · Tu visita estimada</p>
                    <p>Se notificará 20 minutos antes de la llegada</p>
                  </div>
                </div>
                <div class="timeline__item">
                  <span class="timeline__bullet"></span>
                  <div class="timeline__content">
                    <p class="font-semibold text-gray-800">12:00 · Cierre de ruta</p>
                    <p>Entrega en planta de compostaje</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="lg:col-span-4 card">
              <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-2xl bg-brand-100 grid place-content-center text-lg">✅</div>
                <div>
                  <h3 class="text-lg font-semibold">Recolección programada</h3>
                  <p class="text-sm text-gray-600">Confirmada para el <span class="font-semibold text-brand-700">1 de octubre</span>.</p>
                  <p class="mt-3 text-xs text-gray-500">Si necesitas cambiar la fecha, hazlo antes de las 18:00 del día anterior.</p>
                </div>
              </div>
              <div class="mt-4 rounded-2xl bg-brand-50/60 p-4 text-sm text-brand-700">
                <p class="font-semibold">Consejo:</p>
                <p>Recuerda separar restos de comida en bolsas compostables para obtener puntos extra.</p>
              </div>
            </div>

            <div class="lg:col-span-3 card">
              <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-2xl bg-brand-100 grid place-content-center text-lg">🔔</div>
                <div>
                  <h3 class="text-lg font-semibold">Recordatorios</h3>
                  <p class="text-sm text-gray-600">Actualiza tus notificaciones para no perder recompensas.</p>
                </div>
              </div>
              <ul class="mt-4 space-y-3 text-sm text-gray-600">
                <li class="flex items-center gap-2"><span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-brand-50 text-brand-600 text-xs">1</span> Recordatorio por SMS activado</li>
                <li class="flex items-center gap-2"><span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-brand-50 text-brand-600 text-xs">2</span> Correo de resumen semanal</li>
                <li class="flex items-center gap-2"><span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-brand-50 text-brand-600 text-xs">3</span> Nueva encuesta disponible</li>
              </ul>
              <a href="{{ url('/perfil') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-brand-700">Gestionar alertas →</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
