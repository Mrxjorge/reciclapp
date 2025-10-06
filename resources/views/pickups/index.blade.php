<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis recolecciones') }}
        </h2>
    </x-slot>

<div class="py-6 bg-[#f4fbf6] min-h-screen">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-4 text-green-600">{{ session('status') }}</div>
        @endif

        <div class="mb-4">
            <a href="{{ route('pickups.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded">
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
                        <th class="px-4 py-3">Modalidad</th> {{-- NUEVA --}}
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
                            <td class="px-4 py-3 capitalize">{{ $p->modalidad }}</td> {{-- NUEVA --}}
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
                            <td class="px-4 py-5 text-center" colspan="8">Aún no tienes recolecciones.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>
