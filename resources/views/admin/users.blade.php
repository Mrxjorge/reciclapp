{{-- resources/views/admin/users.blade.php --}}
<x-app-layout>
    {{-- Header estándar del layout (lo muestro dentro del <main>) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Administración: Usuarios') }}
        </h2>
    </x-slot>

    <div x-data="{ collapsed:true }" class="min-h-screen bg-gradient-to-b from-[#f4fbf6] to-white">

        <!-- SIDEBAR IZQUIERDA -->
        <aside
            class="fixed inset-y-0 left-0 z-40 bg-emerald-900 text-white transition-all duration-200 ease-in-out shadow-lg"
            :class="collapsed ? 'w-16' : 'w-64'">

            <!-- Marca + Hamburguesa -->
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

            <!-- Navegación -->
            <nav class="mt-2 space-y-1 px-2">
                {{-- helper para activo --}}
                @php
                    $link = fn($isActive)=>"flex items-center gap-3 px-3 py-2 rounded-md transition "
                        . ($isActive ? 'bg-emerald-800' : 'hover:bg-emerald-800');
                @endphp

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="{{ $link(request()->routeIs('dashboard')) }}"
                   :class="{'justify-center': collapsed}" title="Dashboard">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4 10v10h6V14h4v6h6V10"/>
                    </svg>
                    <span x-show="!collapsed" class="truncate">Dashboard</span>
                </a>

                <!-- Mis Recolecciones -->
                <a href="{{ route('pickups.index') }}"
                   class="{{ $link(request()->routeIs('pickups.*')) }}"
                   :class="{'justify-center': collapsed}" title="Mis Recolecciones">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10"/>
                    </svg>
                    <span x-show="!collapsed" class="truncate">Mis Recolecciones</span>
                </a>

                <!-- Usuarios (esta vista) -->
                <a href="{{ route('admin.users.index') }}"
                   class="{{ $link(request()->routeIs('admin.users.*')) }}"
                   :class="{'justify-center': collapsed}" title="Usuarios">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17 20h5v-2a4 4 0 00-4-4h-1M7 20H2v-2a4 4 0 014-4h1M16 7a4 4 0 11-8 0 4 4 0 018 0"/>
                    </svg>
                    <span x-show="!collapsed" class="truncate">Usuarios</span>
                </a>

                <!-- Recolecciones (admin) -->
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

        <!-- CONTENIDO DESPLAZADO -->
        <div class="transition-all duration-200 ease-in-out"
             :class="collapsed ? 'lg:ml-16' : 'lg:ml-64'">

            <!-- top spacer para alinear con altura del sidebar header -->
            <div class="h-4 lg:h-6"></div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{-- Mensaje de estado --}}
                @if (session('status'))
                    <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- TARJETA: Tabla de usuarios --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase">ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase">Nombre</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase">Email</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase">Cédula</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase">Teléfono</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase">Rol</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-4 py-3">{{ $user->id }}</td>
                                        <td class="px-4 py-3">{{ $user->name }}</td>
                                        <td class="px-4 py-3">{{ $user->email }}</td>
                                        <td class="px-4 py-3">{{ $user->cedula }}</td>
                                        <td class="px-4 py-3">{{ $user->telefono }}</td>
                                        <td class="px-4 py-3">{{ $user->role }}</td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                               class="text-indigo-600 hover:underline">Editar</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-4 py-3" colspan="7">No hay usuarios.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
