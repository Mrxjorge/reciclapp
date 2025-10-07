{{-- resources/views/pickups/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-4xl md:text-5xl font-extrabold text-emerald-900">
            {{ __('Mis recolecciones') }}
        </h2>
    </x-slot>

    <div x-data="{ collapsed:true }" class="min-h-screen bg-gradient-to-b from-[#f4fbf6] to-white">
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

                @if(auth()->check() && auth()->user()->role !== 'user')
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
                @endif
            </nav>
        </aside>

        <div class="transition-all duration-200 ease-in-out"
             :class="collapsed ? 'lg:ml-16' : 'lg:ml-64'">

            <div class="h-4 lg:h-6"></div>

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                @if (session('status'))
                    <div class="mb-4 text-green-600">{{ session('status') }}</div>
                @endif

                {{-- Filtros --}}
                <form method="GET" action="{{ route('pickups.index') }}"
                      class="bg-white rounded-xl border border-emerald-200 shadow p-4 md:p-5 grid gap-3 md:grid-cols-12">
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium mb-1">Fecha inicial</label>
                        <input type="date" name="desde" value="{{ request('desde') }}" class="w-full">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium mb-1">Fecha final</label>
                        <input type="date" name="hasta" value="{{ request('hasta') }}" class="w-full">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium mb-1">Tipo de residuo</label>
                        <select name="tipo" class="w-full">
                            <option value="">Todos</option>
                            <option value="organico"   @selected(request('tipo')==='organico')>Orgánica</option>
                            <option value="inorganico" @selected(request('tipo')==='inorganico')>Inorgánica</option>
                            <option value="peligroso"  @selected(request('tipo')==='peligroso')>Peligrosa</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium mb-1">Estado</label>
                        <select name="estado" class="w-full">
                            <option value="">Todos</option>
                            <option value="programada" @selected(request('estado')==='programada')>Programada</option>
                            <option value="completada" @selected(request('estado')==='completada')>Completada</option>
                            <option value="cancelada"  @selected(request('estado')==='cancelada')>Cancelada</option>
                        </select>
                    </div>

                    <div class="md:col-span-1 flex items-end">
                        <button class="w-full px-4 py-2 rounded bg-emerald-600 text-white hover:bg-emerald-700">
                            Filtrar
                        </button>
                    </div>
                </form>

                <div class="mt-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr class="text-left">
                                <th class="px-4 py-3">Tipo</th>
                                <th class="px-4 py-3">Dirección</th>
                                <th class="px-4 py-3">Localidad</th>
                                <th class="px-4 py-3">Fecha</th>
                                <th class="px-4 py-3">Hora</th>
                                <th class="px-4 py-3">Modalidad</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pickups as $p)
                                <tr class="border-t border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-3 capitalize">{{ $p->tipo_residuo }}</td>
                                    <td class="px-4 py-3">{{ $p->direccion }}</td>
                                    <td class="px-4 py-3">{{ optional($p->localidad)->nombre ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ optional($p->fecha_programada)->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3">
                                        {{ $p->hora_programada ? \Illuminate\Support\Carbon::parse($p->hora_programada)->format('H:i') : '—' }}
                                    </td>
                                    <td class="px-4 py-3 capitalize">{{ $p->modalidad }}</td>
                                    <td class="px-4 py-3 capitalize">{{ $p->estado }}</td>
                                    <td class="px-4 py-3 space-x-2">
                                        <a href="{{ route('pickups.edit', $p) }}" class="underline">Reprogramar</a>
                                        <form action="{{ route('pickups.destroy', $p) }}" method="POST" class="inline"
                                              onsubmit="return confirm('¿Eliminar esta programación?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 underline">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-5 text-center" colspan="8">
                                        Sin resultados para los filtros seleccionados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between mt-4">
                    <a href="{{ route('pickups.create') }}"
                       class="inline-flex items-center justify-center px-5 py-2 rounded bg-emerald-700 text-white hover:bg-emerald-800">
                        Programar nueva recolección
                    </a>

                    <a href="{{ route('pickups.export', request()->query()) }}"
                       class="inline-flex items-center justify-center px-5 py-2 rounded bg-emerald-900 text-white hover:bg-emerald-950">
                        Descargar CSV
                    </a>
                </div>

                <div class="mt-4">
                    {{ $pickups->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


