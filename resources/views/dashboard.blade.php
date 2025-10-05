<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

      {{-- KPIs --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <x-kpi label="Kg acumulados" value="42.5 kg" hint="Últimos 30 días"/>
        <x-kpi label="Puntos disponibles" value="1,240" hint="Listos para canjear"/>
        <x-kpi label="Recolectas completadas" value="12" hint="Este año"/>
      </div>

      {{-- Próxima recolección + Puntos --}}
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <x-card>
          <div class="flex items-start justify-between">
            <h2 class="text-lg font-semibold">Próxima recolección</h2>
            <x-badge color="brand">Confirmada</x-badge>
          </div>
          <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
            <div><div class="text-gray-500">Tipo</div><div class="font-medium">Inorgánico</div></div>
            <div><div class="text-gray-500">Fecha / Turno</div><div class="font-medium">15 Abr — Mañana</div></div>
            <div><div class="text-gray-500">Estado</div><div class="font-medium text-brand-700">Programada</div></div>
            <div><div class="text-gray-500">Dirección</div><div class="font-medium truncate">Cra 12 # 34–56</div></div>
          </div>
          <x-button class="mt-5" variant="primary" onclick="window.location='/u/programar'">Programar nueva</x-button>
        </x-card>

        <x-card>
          <h2 class="text-lg font-semibold">Puntos</h2>
          <div class="mt-4 flex items-center gap-6">
            <div class="text-4xl font-bold text-brand-700">1,240</div>
            <div class="space-y-2 text-sm">
              <div class="text-gray-500">Reglas para ganar</div>
              <div class="flex gap-2">
                <x-badge>Orgánico</x-badge>
                <x-badge color="inorganico">Inorgánico</x-badge>
                <x-badge color="peligroso">Peligroso</x-badge>
              </div>
            </div>
          </div>
          <x-button class="mt-5" variant="outline" onclick="window.location='/u/puntos'">Ver movimientos / Canjear</x-button>
        </x-card>
      </div>

      {{-- Resumen de últimas recolecciones --}}
      <x-card>
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-lg font-semibold">Últimas recolecciones</h2>
          <a href="/u/historial" class="text-sm text-brand-700 hover:underline">Ver todo</a>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="text-left text-gray-500">
              <tr>
                <th class="py-2">Fecha</th>
                <th class="py-2">Tipo</th>
                <th class="py-2">Kg</th>
                <th class="py-2">Puntos</th>
                <th class="py-2">Estado</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              <tr class="hover:bg-gray-50">
                <td class="py-3">10 Abr 2025</td>
                <td class="py-3"><x-badge color="inorganico">Inorgánico</x-badge></td>
                <td class="py-3">4.2</td>
                <td class="py-3">120</td>
                <td class="py-3"><x-badge>Completada</x-badge></td>
              </tr>
              <tr class="hover:bg-gray-50">
                <td class="py-3">03 Abr 2025</td>
                <td class="py-3"><x-badge>Orgánico</x-badge></td>
                <td class="py-3">7.8</td>
                <td class="py-3">180</td>
                <td class="py-3"><x-badge>Completada</x-badge></td>
              </tr>
            </tbody>
          </table>
        </div>
      </x-card>

    </div>
  </div>
</x-app-layout>
