<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Programar Recolección') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc ms-6">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('pickups.store') }}" class="space-y-4">
            @csrf

            <!-- Tipo de residuo -->
            <div>
                <label class="block text-sm font-medium mb-1">Tipo de Residuo</label>
                <select name="tipo_residuo" class="w-full" required>
                    <option value="organico" @selected(old('tipo_residuo') === 'organico')>Orgánico</option>
                    <option value="inorganico" @selected(old('tipo_residuo') === 'inorganico')>Inorgánico</option>
                    <option value="peligroso" @selected(old('tipo_residuo') === 'peligroso')>Peligroso</option>
                </select>
            </div>

            <!-- Fecha programada -->
            <div>
                <label class="block text-sm font-medium mb-1">Fecha Programada</label>
                <input type="date" name="fecha_programada" class="w-full" value="{{ old('fecha_programada') }}" required>
            </div>

            <!-- Hora programada -->
            <div>
                <label class="block text-sm font-medium mb-1">Hora Programada (opcional)</label>
                <input type="time" name="hora_programada" class="w-full" value="{{ old('hora_programada') }}">
            </div>

            <!-- Estado (no se incluye ya que siempre será 'programada') -->
            <input type="hidden" name="estado" value="programada">
            
            <!-- Modalidad ya no está incluido -->
            <input type="hidden" name="modalidad" value="programada">  <!-- También puede ser eliminado, ya no es necesario -->

            <x-primary-button>Programar</x-primary-button>
            <a href="{{ route('pickups.index') }}" class="ms-2 underline">Cancelar</a>
        </form>
    </div>
</x-app-layout>
