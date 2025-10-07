{{-- resources/views/admin/pickups.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-4xl md:text-5xl font-extrabold text-emerald-900">
            {{ __('Administración: Recolecciones') }}
        </h2>
    </x-slot>

    <div x-data="{ collapsed:true }" class="min-h-screen bg-gradient-to-b from-[#f4fbf6] to-white">

        <!-- SIDEBAR -->
        <aside
            class="fixed inset-y-0 left-0 z-40 bg-emerald-900 text-white transition-all duration-200 ease-in-out shadow-lg"
            :class="collapsed ? 'w-16' : 'w-64'">

            <div class="h-16 flex items-center justify-between px-3">
                <span x-show="!collapsed" class="text-lg font-semibold tracking-wide">Reciclapp</span>
                <button @click="collapsed = !collapsed"
                        class="p-2 rounded hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-white/40"
                        aria-label="Contraer/expandir">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            @php
                $link = fn($active)=>"flex items-center gap-3 px-3 py-2 rounded-md transition "
                    . ($active ? 'bg-emerald-800' : 'hover:bg-emerald-800');
            @endphp

            <nav class="mt-2 space-y-1 px-2">
                <a href="{{ route('dashboard') }}"
                   class="{{ $link(request()->routeIs('dashboard')) }}"
                   :class="{'justify-center': collapsed}" title="Dashboard">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4 10v10h6V14h4v6h6V10"/>
                    </svg>
                    <span x-show="!collapsed" class="truncate">Dashboard</span>
                </a>

                <a href="{{ route('pickups.index') }}"
                   class="{{ $link(request()->routeIs('pickups.*')) }}"
                   :class="{'justify-center': collapsed}" title="Mis Recolecciones">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10"/>
                    </svg>
                    <span x-show="!collapsed" class="truncate">Mis Recolecciones</span>
                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="{{ $link(request()->routeIs('admin.users.*')) }}"
                   :class="{'justify-center': collapsed}" title="Usuarios">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17 20h5v-2a4 4 0 00-4-4h-1M7 20H2v-2a4 4 0 014-4h1M16 7a4 4 0 11-8 0 4 4 0 018 0"/>
                    </svg>
                    <span x-show="!collapsed" class="truncate">Usuarios</span>
                </a>

                <a href="{{ route('admin.pickups.index') }}"
                   class="{{ $link(request()->routeIs('admin.pickups.*')) }}"
                   :class="{'justify-center': collapsed}" title="Recolecciones">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 7h11l1 2h6M7 20a2 2 0 01-2-2V7m12 13h2a2 2 0 002-2v-6"/>
                    </svg>
                    <span x-show="!collapsed" class="truncate">Recolecciones</span>
                </a>
            </nav>
        </aside>

        <!-- CONTENIDO -->
        <div class="transition-all duration-200 ease-in-out"
             :class="collapsed ? 'lg:ml-16' : 'lg:ml-64'">

            <div class="h-4 lg:h-6"></div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                {{-- Filtros --}}
                <form method="GET" action="{{ route('admin.pickups.index') }}"
                      class="bg-white dark:bg-gray-800 p-4 rounded shadow grid gap-3 md:grid-cols-6">
                    {{-- Usuario (nombre/email) --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs mb-1">Usuario (nombre o email)</label>
                        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="w-full">
                    </div>

                    {{-- Tipo de residuo --}}
                    <div>
                        <label class="block text-xs mb-1">Tipo</label>
                        <select name="tipo_residuo" class="w-full">
                            <option value="">Todos</option>
                            <option value="organico"   @selected(($filters['tipo_residuo'] ?? '')==='organico')>Orgánico</option>
                            <option value="inorganico" @selected(($filters['tipo_residuo'] ?? '')==='inorganico')>Inorgánico</option>
                            <option value="peligroso"  @selected(($filters['tipo_residuo'] ?? '')==='peligroso')>Peligroso</option>
                        </select>
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label class="block text-xs mb-1">Estado</label>
                        <select name="estado" class="w-full">
                            <option value="">Todos</option>
                            <option value="programada" @selected(($filters['estado'] ?? '')==='programada')>Programada</option>
                            <option value="completada" @selected(($filters['estado'] ?? '')==='completada')>Completada</option>
                            <option value="cancelada"  @selected(($filters['estado'] ?? '')==='cancelada')>Cancelada</option>
                        </select>
                    </div>

                    {{-- Localidad --}}
                    <div>
                        <label class="block text-xs mb-1">Localidad</label>
                        <select name="localidad_id" class="w-full">
                            <option value="">Todas</option>
                            @foreach($localidades as $loc)
                                <option value="{{ $loc->id }}" @selected(($filters['localidad_id'] ?? '')==$loc->id)>{{ $loc->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Modalidad --}}
                    <div>
                        <label class="block text-xs mb-1">Modalidad</label>
                        <select name="modalidad" class="w-full">
                            <option value="">Todas</option>
                            <option value="programada" @selected(($filters['modalidad'] ?? '')==='programada')>Programada</option>
                            <option value="demanda"    @selected(($filters['modalidad'] ?? '')==='demanda')>Por demanda</option>
                        </select>
                    </div>

                    {{-- Rango de fechas --}}
                    <div class="md:col-span-3 grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs mb-1">Desde</label>
                            <input type="date" name="desde" value="{{ $filters['desde'] ?? '' }}" class="w-full">
                        </div>
                        <div>
                            <label class="block text-xs mb-1">Hasta</label>
                            <input type="date" name="hasta" value="{{ $filters['hasta'] ?? '' }}" class="w-full">
                        </div>
                    </div>

                    <div class="md:col-span-3 flex items-end gap-2">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Filtrar</button>
                        <a href="{{ route('admin.pickups.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded">Limpiar</a>

                        {{-- Exportar CSV (conserva filtros) --}}
                        <a href="{{ route('admin.pickups.export', request()->query()) }}"
                           class="px-4 py-2 rounded bg-emerald-600 text-white hover:bg-emerald-700">
                            Descargar CSV
                        </a>
                    </div>
                </form>

                {{-- Tabla --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-3 py-2 text-left">Usuario</th>
                                    <th class="px-3 py-2 text-left">Tipo</th>
                                    <th class="px-3 py-2 text-left">Dirección</th>
                                    <th class="px-3 py-2 text-left">Localidad</th>
                                    <th class="px-3 py-2 text-left">Fecha</th>
                                    <th class="px-3 py-2 text-left">Hora</th>
                                    <th class="px-3 py-2 text-left">Modalidad</th>
                                    <th class="px-3 py-2 text-left">Estado</th>
                                    <th class="px-3 py-2 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($pickups as $pk)
                                    <tr>
                                        <td class="px-3 py-2">
                                            <div class="font-medium">{{ $pk->user?->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $pk->user?->email }}</div>
                                        </td>
                                        <td class="px-3 py-2 capitalize">{{ $pk->tipo_residuo }}</td>
                                        <td class="px-3 py-2">{{ $pk->direccion }}</td>
                                        <td class="px-3 py-2">{{ $pk->localidad?->nombre ?? '—' }}</td>
                                        <td class="px-3 py-2">{{ optional($pk->fecha_programada)->format('Y-m-d') }}</td>
                                        <td class="px-3 py-2">
                                            {{ $pk->hora_programada ? \Illuminate\Support\Carbon::parse($pk->hora_programada)->format('H:i') : '—' }}
                                        </td>
                                        <td class="px-3 py-2 capitalize">{{ $pk->modalidad }}</td>
                                        <td class="px-3 py-2 capitalize">{{ $pk->estado }}</td>
                                        <td class="px-3 py-2 space-x-3">
                                            <a href="{{ route('pickups.edit', $pk) }}" class="text-indigo-600 hover:underline">Editar</a>
                                            <form action="{{ route('pickups.destroy', $pk) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('¿Eliminar esta recolección?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 hover:underline">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-3 py-4" colspan="9">No hay recolecciones con los criterios actuales.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $pickups->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
