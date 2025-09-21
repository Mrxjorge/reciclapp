{{-- resources/views/pickups/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reprogramar Recolección') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form action="{{ route('pickups.update', $pickup) }}" method="POST"
                  class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                @csrf
                @method('PATCH')

                {{-- Tipo de Residuo --}}
                @php $tipo = old('tipo_residuo', $pickup->tipo_residuo); @endphp
                <div class="mb-4">
                    <label for="tipo_residuo" class="block text-sm font-medium">Tipo de Residuo</label>
                    <select id="tipo_residuo" name="tipo_residuo" class="mt-1 block w-full" required>
                        <option value="organico"   @selected($tipo === 'organico')>Orgánico</option>
                        <option value="inorganico" @selected($tipo === 'inorganico')>Inorgánico</option>
                        <option value="peligroso"  @selected($tipo === 'peligroso')>Peligroso</option>
                    </select>
                    <x-input-error :messages="$errors->get('tipo_residuo')" class="mt-2"/>
                </div>

                {{-- Modalidad (solo inorgánico) --}}
                @php $modalidadOld = old('modalidad', $pickup->modalidad); @endphp
                <div id="wrap-modalidad" class="mb-4 hidden">
                    <label for="modalidad" class="block text-sm font-medium">Modalidad (solo inorgánico)</label>
                    <select id="modalidad" class="mt-1 block w-full">
                        <option value="">-- Seleccione --</option>
                        <option value="programada" @selected($modalidadOld==='programada')>Programada</option>
                        <option value="demanda"    @selected($modalidadOld==='demanda')>Por demanda</option>
                    </select>
                    <x-input-error :messages="$errors->get('modalidad')" class="mt-2" />
                </div>

                {{-- Valor por defecto de modalidad para NO inorgánico --}}
                <input type="hidden" id="modalidad_default" name="modalidad" value="programada">

                {{-- Dirección --}}
                <div class="mb-4">
                    <label for="direccion" class="block text-sm font-medium">Dirección</label>
                    <input id="direccion" name="direccion" type="text" class="mt-1 block w-full"
                           value="{{ old('direccion', $pickup->direccion) }}" required>
                    <x-input-error :messages="$errors->get('direccion')" class="mt-2"/>
                </div>

                {{-- Localidad --}}
                @php $locId = old('localidad_id', $pickup->localidad_id); @endphp
                <div class="mb-2">
                    <label for="localidad_id" class="block text-sm font-medium">Localidad</label>
                    <select id="localidad_id" name="localidad_id" class="mt-1 block w-full" required>
                        <option value="">-- Seleccione --</option>
                        @foreach(\App\Models\Localidad::orderBy('nombre')->get() as $loc)
                            <option value="{{ $loc->id }}" @selected($locId == $loc->id)>{{ $loc->nombre }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('localidad_id')" class="mt-2"/>
                    <p id="hint-organico" class="text-sm text-gray-500 mt-1 hidden">
                        Para <strong>orgánicos</strong>, la fecha se asigna automáticamente según la localidad. La hora no aplica.
                    </p>
                </div>

                {{-- Fecha --}}
                <div class="mb-4">
                    <label for="fecha_programada" class="block text-sm font-medium">Fecha</label>
                    <input id="fecha_programada" name="fecha_programada" type="date" class="mt-1 block w-full"
                           value="{{ old('fecha_programada', optional($pickup->fecha_programada)->format('Y-m-d')) }}">
                    <x-input-error :messages="$errors->get('fecha_programada')" class="mt-2"/>
                </div>

                {{-- Hora --}}
                <div class="mb-6">
                    <label for="hora_programada" class="block text-sm font-medium">Hora</label>
                    <input id="hora_programada" name="hora_programada" type="time" class="mt-1 block w-full"
                           value="{{ old('hora_programada', $pickup->hora_programada) }}">
                    <x-input-error :messages="$errors->get('hora_programada')" class="mt-2"/>
                </div>

                <div class="flex gap-3">
                    <x-primary-button>Guardar cambios</x-primary-button>
                    <a href="{{ route('pickups.index') }}"
                       class="px-4 py-2 rounded bg-gray-200 dark:bg-gray-700">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Misma lógica de UI que en create + manejo de "modalidad" por hidden/select --}}
    <script>
        const tipo    = document.getElementById('tipo_residuo');
        const wrap    = document.getElementById('wrap-modalidad');
        const sel     = document.getElementById('modalidad');
        const hidden  = document.getElementById('modalidad_default');

        const fecha   = document.getElementById('fecha_programada');
        const hora    = document.getElementById('hora_programada');
        const hint    = document.getElementById('hint-organico');

        function refreshUI() {
            if (tipo.value === 'organico') {
                // Orgánico: no modalidad (usa hidden), fecha/hora deshabilitadas
                wrap.classList.add('hidden');
                hidden.name = 'modalidad';
                sel.removeAttribute('name');

                fecha.disabled = true;  fecha.required = false;
                hora.disabled  = true;  hora.required  = false;

                hint.classList.remove('hidden');

            } else if (tipo.value === 'inorganico') {
                // Inorgánico: mostrar modalidad (envía select), fecha obligatoria, hora opcional
                wrap.classList.remove('hidden');
                sel.setAttribute('name', 'modalidad');
                hidden.removeAttribute('name');

                fecha.disabled = false; fecha.required = true;
                hora.disabled  = false; hora.required  = false;

                hint.classList.add('hidden');

            } else if (tipo.value === 'peligroso') {
                // Peligroso: no modalidad (usa hidden), fecha y hora obligatorias
                wrap.classList.add('hidden');
                hidden.name = 'modalidad';
                sel.removeAttribute('name');

                fecha.disabled = false; fecha.required = true;
                hora.disabled  = false; hora.required  = true;

                hint.classList.add('hidden');

            } else {
                // Estado inicial/seguro
                wrap.classList.add('hidden');
                hidden.name = 'modalidad';
                sel.removeAttribute('name');

                fecha.disabled = false; fecha.required = false;
                hora.disabled  = false; hora.required  = false;
                hint.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', refreshUI);
        tipo.addEventListener('change', refreshUI);
    </script>
</x-app-layout>
