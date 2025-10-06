{{-- resources/views/pickups/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis recolecciones') }}
        </h2>
    </x-slot>

    <div x-data="{ collapsed:false }" class="min-h-screen bg-gradient-to-b from-[#f4fbf6] to-white">

        <!-- SIDEBAR -->
        <aside
            class="fixed inset-y-0 left-0 z-40 bg-emerald-900 text-white transition-all duration-200 ease-in-out shadow-lg"
            :class="collapsed ? 'w-16' : 'w-64'">

            <!-- Encabezado + botón hamburguesa -->
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

            <!-- Navegación -->
            <nav class="mt-2 space-y-1 px-2">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="{{ $link(request()->routeIs('dashboard')) }}"
                   :class="{'justify-center': collapsed}" title="Dashboard">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 12l9-9 9 9M4 10v10h6V14h4v6h6V10"/>
                    </svg>
                    <span x-show="!collapsed" class="truncate">Dashboard</span>
                </a>

                <!-- Mis Recolecciones -->
                <a href="{{ route('pickups.index') }}"
                   class="{{ $link(request()->routeIs('pickups.*')) }}"
                   :class="{'justify-center': collapsed}" title="Mis Recolecciones">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10"/>
                    </svg>
                    <span x-show="!collapsed" class="truncate">Mis Recolecciones</span>
                </a>

                {{-- 🔒 Solo mostrar si el rol NO es "user" --}}
                @if(auth()->check() && auth()->user()->role !== 'user')
                    <!-- Usuarios (solo admin) -->
                    <a href="{{ route('admin.users.index') }}"
                       class="{{ $link(request()->routeIs('admin.users.*')) }}"
                       :class="{'justify-center': collapsed}" title="Usuarios">
                        <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 20h5v-2a4 4 0 00-4-4h-1M7 20H2v-2a4 4 0 014-4h1M16 7a4 4 0 11-8 0 4 4 0 018 0"/>
                        </svg>
                        <span x-show="!collapsed" class="truncate">Usuarios</span>
                    </a>

                    <!-- Recolecciones (Admin) -->
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

        <!-- CONTENIDO PRINCIPAL -->
        <div class="transition-all duration-200 ease-in-out"
             :class="collapsed ? 'lg:ml-16' : 'lg:ml-64'">

            <div class="h-4 lg:h-6"></div>

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                @if (session('status'))
                    <div class="mb-4 text-green-600">{{ session('status') }}</div>
                @endif

                <div class="mb-4">
                    <a href="{{ route('pickups.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-emerald-900 text-white rounded">
                        Programar nueva recolección
                    </a>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-x-auto">
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
                                        Aún no tienes recolecciones.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

