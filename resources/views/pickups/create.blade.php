{{-- resources/views/pickups/create.blade.php --}}
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

            {{-- Tipo de residuo --}}
            <div>
                <label for="tipo_residuo" class="block text-sm font-medium mb-1">Tipo de Residuo</label>
                <select id="tipo_residuo" name="tipo_residuo" class="w-full" required>
                    <option value="">-- Seleccione --</option>
                    <option value="organico"   @selected(old('tipo_residuo') === 'organico')>Orgánico</option>
                    <option value="inorganico" @selected(old('tipo_residuo') === 'inorganico')>Inorgánico</option>
                    <option value="peligroso"  @selected(old('tipo_residuo') === 'peligroso')>Peligroso</option>
                </select>
                <x-input-error :messages="$errors->get('tipo_residuo')" class="mt-2" />
            </div>

            {{-- Modalidad (solo inorgánico) --}}
            <div id="wrap-modalidad" class="hidden">
                <label for="modalidad" class="block text-sm font-medium mb-1">Modalidad (solo inorgánico)</label>
                <select id="modalidad" class="w-full">
                    <option value="">-- Seleccione --</option>
                    <option value="programada" @selected(old('modalidad')==='programada')>Programada</option>
                    <option value="demanda"    @selected(old('modalidad')==='demanda')>Por demanda</option>
                </select>
                <x-input-error :messages="$errors->get('modalidad')" class="mt-2" />
            </div>

            {{-- Valor por defecto de modalidad para NO inorgánico --}}
            <input type="hidden" id="modalidad_default" name="modalidad" value="programada">

            {{-- Dirección --}}
            <div>
                <label for="direccion" class="block text-sm font-medium mb-1">Dirección</label>
                <input id="direccion" name="direccion" type="text" class="w-full"
                       value="{{ old('direccion') }}" required>
                <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
            </div>

            {{-- Localidad --}}
            <div>
                <label for="localidad_id" class="block text-sm font-medium mb-1">Localidad</label>
                <select id="localidad_id" name="localidad_id" class="w-full" required>
                    <option value="">-- Seleccione --</option>
                    @foreach(\App\Models\Localidad::orderBy('nombre')->get() as $loc)
                        <option value="{{ $loc->id }}" @selected(old('localidad_id') == $loc->id)>{{ $loc->nombre }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('localidad_id')" class="mt-2" />
                <p id="hint-organico" class="text-sm text-gray-500 mt-1 hidden">
                    Para <strong>orgánicos</strong>, la fecha se asignará automáticamente según la localidad. La hora no aplica.
                </p>
            </div>

            {{-- Fecha programada --}}
            <div>
                <label for="fecha_programada" class="block text-sm font-medium mb-1">Fecha Programada</label>
                <input id="fecha_programada" name="fecha_programada" type="date" class="w-full"
                       value="{{ old('fecha_programada') }}">
                <x-input-error :messages="$errors->get('fecha_programada')" class="mt-2" />
            </div>

            {{-- Hora programada --}}
            <div>
                <label for="hora_programada" class="block text-sm font-medium mb-1">Hora Programada</label>
                <input id="hora_programada" name="hora_programada" type="time" class="w-full"
                       value="{{ old('hora_programada') }}">
                <x-input-error :messages="$errors->get('hora_programada')" class="mt-2" />
            </div>

            <div class="flex gap-3">
                <x-primary-button>Programar</x-primary-button>
                <a href="{{ route('pickups.index') }}" class="ms-2 underline">Cancelar</a>
            </div>
        </form>
    </div>

    {{-- JS para reglas de UI por tipo y manejo de "modalidad" --}}
    <script>
        const tipo   = document.getElementById('tipo_residuo');
        const wrap   = document.getElementById('wrap-modalidad');
        const sel    = document.getElementById('modalidad');
        const hidden = document.getElementById('modalidad_default');

        const fecha  = document.getElementById('fecha_programada');
        const hora   = document.getElementById('hora_programada');
        const hint   = document.getElementById('hint-organico');

        function toggleUI() {
            if (tipo.value === 'organico') {
                // sin modalidad visible — usar hidden(programada)
                wrap.classList.add('hidden');
                hidden.name = 'modalidad';      // el hidden envía "programada"
                sel.removeAttribute('name');     // el select no envía

                // fecha/hora deshabilitadas (back calcula)
                fecha.disabled = true;  fecha.required = false; fecha.value = '';
                hora.disabled  = true;  hora.required  = false; hora.value  = '';
                hint.classList.remove('hidden');

            } else if (tipo.value === 'inorganico') {
                // mostrar modalidad — que el SELECT sea el que envía
                wrap.classList.remove('hidden');
                sel.setAttribute('name', 'modalidad');
                hidden.removeAttribute('name');

                // fecha obligatoria, hora opcional
                fecha.disabled = false; fecha.required = true;
                hora.disabled  = false; hora.required  = false;
                hint.classList.add('hidden');

            } else if (tipo.value === 'peligroso') {
                // sin modalidad visible — usar hidden(programada)
                wrap.classList.add('hidden');
                hidden.name = 'modalidad';
                sel.removeAttribute('name');

                // fecha y hora obligatorias
                fecha.disabled = false; fecha.required = true;
                hora.disabled  = false; hora.required  = true;
                hint.classList.add('hidden');

            } else {
                // estado inicial
                wrap.classList.add('hidden');
                hidden.name = 'modalidad';
                sel.removeAttribute('name');

                fecha.disabled = false; fecha.required = false;
                hora.disabled  = false; hora.required  = false;
                hint.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', toggleUI);
        tipo.addEventListener('change', toggleUI);
    </script>
</x-app-layout>
