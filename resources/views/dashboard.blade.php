<x-app-layout>
  <x-slot name="header">
    {{-- dejamos el topbar de Breeze, sin título visible --}}
    <span class="sr-only">Dashboard</span>
  </x-slot>

  {{-- CONTENEDOR A ANCHO COMPLETO --}}
  <div class="w-full">
    {{-- Layout con sidebar + contenido --}}
    <div class="flex">
      {{-- Sidebar izquierda --}}
      @include('layouts._sidebar')

      {{-- Contenido principal --}}
      <div class="flex-1">

        {{-- BANNER superior --}}
        <div class="relative overflow-hidden">
          <div class="w-full h-44 md:h-56 bg-gradient-to-r from-brand-100 to-brand-50 flex items-center">
            <div class="w-full h-full bg-[url('/images/hero-eco.jpg')] bg-no-repeat bg-right bg-contain opacity-80"></div>
            <div class="absolute inset-0 flex items-center">
              <h1 class="text-3xl md:text-5xl font-black text-[#0f3b33] pl-6 md:pl-10">
                ¡Bienvenido de vuelta!
              </h1>
            </div>
          </div>
        </div>

        {{-- GRID de tarjetas como el mockup --}}
        <div class="px-4 sm:px-6 lg:px-10 py-6 grid grid-cols-1 lg:grid-cols-12 gap-6">

          {{-- 1) Próxima recolección --}}
          <div class="lg:col-span-4 card">
            <h3 class="text-lg font-semibold mb-3">Próxima recolección</h3>
            <div class="text-brand-700 font-semibold">ORGÁNICO</div>
            <div class="text-gray-800 mt-1">
              1 de octubre, <span class="font-semibold">05:00 PM</span>
            </div>
            <a href="{{ url('/u/historial') }}" class="mt-2 inline-block text-brand-700 font-medium">Lista</a>
          </div>

          {{-- 2) Puntos con botón CANJEAR --}}
          <div class="lg:col-span-4 card flex items-center justify-between">
            <div>
              <h3 class="text-lg font-semibold mb-1">Puntos</h3>
              <div class="text-6xl font-extrabold tracking-tight">1,050</div>
            </div>
            <button class="btn btn--outline shadow-soft text-base px-5 py-2"
                    onclick="window.location='{{ url('/u/puntos') }}'">
              CANJEAR
            </button>
          </div>

          {{-- 3) Tabla “Recolecciones recientes” --}}
          <div class="lg:col-span-4 card">
            <h3 class="text-lg font-semibold mb-3">Recolecciones recientes</h3>
            <div class="overflow-x-auto">
              <table class="w-full text-sm">
                <thead class="text-left text-gray-500 border-b">
                  <tr>
                    <th class="py-2">FECHA</th>
                    <th class="py-2">TIPO</th>
                    <th class="py-2">KG</th>
                    <th class="py-2">PUNTOS</th>
                  </tr>
                </thead>
                <tbody class="divide-y">
                  <tr class="hover:bg-gray-50"><td class="py-2">30/09/2025</td><td>PELIGROSA</td><td>5</td><td>500</td></tr>
                  <tr class="hover:bg-gray-50"><td class="py-2">15/09/2025</td><td>INORGÁNICA</td><td>10</td><td>120</td></tr>
                  <tr class="hover:bg-gray-50"><td class="py-2">14/09/2025</td><td>ORGÁNICA</td><td>5</td><td>50</td></tr>
                  <tr class="hover:bg-gray-50"><td class="py-2">10/09/2025</td><td>ORGÁNICA</td><td>10</td><td>100</td></tr>
                  <tr class="hover:bg-gray-50"><td class="py-2">05/09/2025</td><td>INORGÁNICA</td><td>5</td><td>60</td></tr>
                  <tr class="hover:bg-gray-50"><td class="py-2">01/09/2025</td><td>ORGÁNICA</td><td>1</td><td>10</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          {{-- 4) Calendario de recolecciones (card grande) --}}
          <div class="lg:col-span-4 card">
            <h3 class="text-lg font-semibold mb-4">Calendario de recolecciones</h3>
            <div class="grid grid-cols-7 gap-2 text-center text-xs text-gray-500 mb-2">
              <div>D</div><div>L</div><div>M</div><div>M</div><div>J</div><div>V</div><div>S</div>
            </div>
            <div class="grid grid-cols-7 gap-2 text-center text-sm">
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
                <div class="relative py-2 rounded-lg {{ $i===1 ? 'ring-2 ring-brand-300' : '' }} hover:bg-gray-50">
                  <span>{{ $i }}</span>
                  @if($dot)
                    <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full {{ $color }}"></span>
                  @endif
                </div>
              @endfor
            </div>
            <div class="flex gap-2 mt-4">
              <span class="chip chip--brand">ORGÁNICO</span>
              <span class="chip chip--blue">INORGÁNICO</span>
              <span class="chip chip--red">PELIGROSO</span>
            </div>
          </div>

          {{-- 5) Mi ruta --}}
          <div class="lg:col-span-4 card bg-gradient-to-br from-brand-50 to-white">
            <div class="flex items-center gap-3 mb-3">
              <div class="w-8 h-8 rounded-full bg-brand-100 grid place-content-center">🗺️</div>
              <h3 class="text-lg font-semibold">Mi ruta</h3>
            </div>
            <div class="h-28 relative">
              <div class="absolute left-6 right-6 top-1/2 -translate-y-1/2 h-20">
                <svg viewBox="0 0 300 90" class="w-full h-full">
                  <path d="M5,75 C60,10 140,120 200,30 260,-30 310,70 290,80" fill="none" stroke="#34b66f" stroke-width="3" stroke-dasharray="6 6"/>
                  <circle cx="18" cy="70" r="6" fill="#2a7de1"/>
                  <circle cx="210" cy="35" r="6" fill="#34b66f"/>
                </svg>
              </div>
            </div>
          </div>

          {{-- 6) Recolección programada --}}
          <div class="lg:col-span-4 card flex items-start gap-3">
            <div class="w-8 h-8 rounded-full bg-brand-100 grid place-content-center">✅</div>
            <div>
              <h4 class="font-semibold">Recolección programada</h4>
              <p class="text-sm text-brand-700">Para el 1 de octubre</p>
            </div>
          </div>

          {{-- 7) Aviso: “El recolector llegará pronto” --}}
          <div class="lg:col-span-4 card flex items-start gap-3">
            <div class="w-8 h-8 rounded-full bg-brand-100 grid place-content-center">🔔</div>
            <div>
              <h4 class="font-semibold">El recolector llegará pronto</h4>
              <p class="text-sm text-brand-700">Ten tus residuos listos</p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
