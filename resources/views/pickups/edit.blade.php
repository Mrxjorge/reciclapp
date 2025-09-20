<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reprogramar Recolección') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <h1>Reprogramar Recolección</h1>

            <form action="{{ route('pickups.update', $pickup) }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Tipo de Residuo -->
                <div class="mb-3">
                    <label for="tipo_residuo" class="form-label">Tipo de Residuo</label>
                    <input type="text" class="form-control" id="tipo_residuo" name="tipo_residuo" value="{{ old('tipo_residuo', $pickup->tipo_residuo) }}" required>
                </div>

                <!-- Fecha Programada -->
                <div class="mb-3">
                    <label for="fecha_programada" class="form-label">Fecha Programada</label>
                    <input type="date" class="form-control" id="fecha_programada" name="fecha_programada" value="{{ old('fecha_programada', $pickup->fecha_programada) }}" required>
                </div>

                <!-- Hora Programada -->
                <div class="mb-3">
                    <label for="hora_programada" class="form-label">Hora Programada (opcional)</label>
                    <input type="time" class="form-control" id="hora_programada" name="hora_programada" value="{{ old('hora_programada', $pickup->hora_programada) }}">
                </div>

                <!-- Modalidad (ocultamos este campo, se asigna por defecto en el controlador) -->
                <input type="hidden" name="modalidad" value="programada">

                <!-- Estado (ocultamos este campo, se asigna por defecto en el controlador) -->
                <input type="hidden" name="estado" value="programada">

                <button type="submit" class="btn btn-success">Guardar Cambios</button>
            </form>
        </div>
    </div>
</x-app-layout>
