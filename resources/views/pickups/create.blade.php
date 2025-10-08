<x-app-layout>
    <x-slot name="header">
        <span class="sr-only">Programar Recolección</span>
    </x-slot>

    <div
        x-data="{
            collapsed:true,
            tipo: '{{ old('tipo_residuo') }}',
            direccion: '{{ old('direccion') }}',
            localidadId: '{{ old('localidad_id') }}',
            localidadNombre: '',
            fecha: '{{ old('fecha_programada') }}',
            hora: '{{ old('hora_programada') }}'
        }"
        class="min-h-screen bg-gradient-to-b from-[#f4fbf6] to-white"
    >

        <aside class="fixed inset-y-0 left-0 z-50 bg-emerald-900 text-white shadow-lg"
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

            <nav class="mt-2 space-y-1 px-2">
                @php
                    $link = fn($active)=>"flex items-center gap-3 px-3 py-2 rounded-md transition "
                        . ($active ? 'bg-emerald-800' : 'hover:bg-emerald-800');
                @endphp

                <a href="{{ route('pickups.index') }}"
                   class="{{ $link(request()->routeIs('pickups.*')) }}"
                   :class="{'justify-center': collapsed}" title="Mis Recolecciones">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10"/>
                    </svg>
                    <span x-show="!collapsed" class="truncate">Mis Recolecciones</span>
                </a>
            </nav>
        </aside>

        <div class="transition-all" :class="collapsed ? 'lg:ml-16 ml-16' : 'lg:ml-64 ml-16'">

            <div class="pt-6 px-4 sm:px-6 lg:px-10">
                <h1 class="text-center text-4xl md:text-5xl font-extrabold text-emerald-900">
                    Programar recolección
                </h1>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 mt-4">
                @if ($errors->any())
                    <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                        <ul class="list-disc ms-6">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <form method="POST" action="{{ route('pickups.store') }}" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-2 gap-6">

                    {{-- PASO 1 --}}
                    <section id="paso-1"
                             class="bg-white shadow sm:rounded-lg border border-emerald-200 p-4
                                    order-1 lg:order-none lg:col-start-1 lg:row-start-1">
                        <h3 class="text-lg font-semibold mb-3">Paso 1: Tipo de residuo</h3>

                        <div class="grid grid-cols-3 gap-3">
                            <label :class="tipo==='inorganico' ? 'ring-2 ring-blue-500' : 'ring-1 ring-blue-300'"
                                   class="cursor-pointer rounded-lg p-3 flex flex-col items-center gap-2 border-2 border-blue-500/60 hover:shadow">
                                <input type="radio" name="tipo_residuo" value="inorganico" class="hidden"
                                       @change="tipo='inorganico'" {{ old('tipo_residuo')==='inorganico' ? 'checked' : '' }}>
                                <svg viewBox="0 0 64 64" class="w-10 h-10"><rect x="14" y="14" width="36" height="36" transform="rotate(45 32 32)" fill="#1d4ed8"/></svg>
                                <span class="text-xs font-medium">Inorgánico</span>
                            </label>

                            <label :class="tipo==='peligroso' ? 'ring-2 ring-red-500' : 'ring-1 ring-red-300'"
                                   class="cursor-pointer rounded-lg p-3 flex flex-col items-center gap-2 border-2 border-red-500/60 hover:shadow">
                                <input type="radio" name="tipo_residuo" value="peligroso" class="hidden"
                                       @change="tipo='peligroso'" {{ old('tipo_residuo')==='peligroso' ? 'checked' : '' }}>
                                <svg viewBox="0 0 64 64" class="w-10 h-10"><polygon points="32,8 58,56 6,56" fill="#e11d48"/></svg>
                                <span class="text-xs font-medium">Peligroso</span>
                            </label>

                            <label :class="tipo==='organico' ? 'ring-2 ring-emerald-500' : 'ring-1 ring-emerald-300'"
                                   class="cursor-pointer rounded-lg p-3 flex flex-col items-center gap-2 border-2 border-emerald-500/60 hover:shadow">
                                <input type="radio" name="tipo_residuo" value="organico" class="hidden"
                                       @change="tipo='organico'" {{ old('tipo_residuo')==='organico' ? 'checked' : '' }}>
                                <svg viewBox="0 0 64 64" class="w-10 h-10"><circle cx="32" cy="32" r="18" fill="#059669"/></svg>
                                <span class="text-xs font-medium">Orgánico</span>
                            </label>
                        </div>
                    </section>

                    {{-- PASO 3 --}}
                    <section id="paso-3"
                             class="bg-white shadow sm:rounded-lg border border-emerald-200 p-4
                                    order-2 lg:order-none lg:col-start-2 lg:row-start-1">
                        <h3 class="text-lg font-semibold mb-3">Paso 3: Fecha y turno</h3>
                        <div class="grid gap-3">
                            <div>
                                <label for="fecha_programada" class="block text-sm font-medium mb-1">Fecha Programada</label>
                                <input id="fecha_programada" name="fecha_programada" type="date" class="w-full"
                                       x-model="fecha"
                                       value="{{ old('fecha_programada') }}">
                                <x-input-error :messages="$errors->get('fecha_programada')" class="mt-2" />
                            </div>
                            <div>
                                <label for="hora_programada" class="block text-sm font-medium mb-1">Hora Programada</label>
                                <input id="hora_programada" name="hora_programada" type="time" class="w-full"
                                       x-model="hora"
                                       value="{{ old('hora_programada') }}">
                                <x-input-error :messages="$errors->get('hora_programada')" class="mt-2" />
                            </div>
                        </div>
                    </section>

                    {{-- PASO 2 --}}
                    <section id="paso-2"
                             class="bg-white shadow sm:rounded-lg border border-emerald-200 p-4
                                    order-3 lg:order-none lg:col-start-1 lg:row-start-2">
                        <h3 class="text-lg font-semibold mb-3">Paso 2: Ubicación</h3>
                        <div class="grid gap-3">
                            <div>
                                <label for="direccion" class="block text-sm font-medium mb-1">Dirección</label>
                                <input id="direccion" name="direccion" type="text" class="w-full"
                                       x-model="direccion"
                                       value="{{ old('direccion') }}" required>
                                <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                            </div>

                            <div>
                                <label for="localidad_id" class="block text-sm font-medium mb-1">Localidad</label>
                                <select id="localidad_id" name="localidad_id" class="w-full"
                                        x-model="localidadId"
                                        @change="localidadNombre = $event.target.selectedOptions[0]?.text || ''"
                                        required>
                                    <option value="">-- Seleccione --</option>
                                    @foreach(\App\Models\Localidad::orderBy('nombre')->get() as $loc)
                                        <option value="{{ $loc->id }}" @selected(old('localidad_id') == $loc->id)>{{ $loc->nombre }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('localidad_id')" class="mt-2" />
                            </div>

                            <p id="hint-organico" class="text-sm text-gray-500 mt-1 hidden">
                                Para <strong>orgánicos</strong>, la fecha se asignará automáticamente según la localidad. La hora no aplica.
                            </p>
                        </div>
                    </section>

                    {{-- PASO 4 --}}
                    <section id="paso-4"
                             class="bg-white shadow sm:rounded-lg border border-emerald-200 p-4
                                    order-4 lg:order-none lg:col-start-2 lg:row-start-2">
                        <h3 class="text-lg font-semibold mb-3">Paso 4: Confirmación</h3>

                        {{-- RESUMEN EN VIVO --}}
                        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-6">
                                <div class="flex justify-between sm:block">
                                    <dt class="font-medium text-emerald-900">Tipo</dt>
                                    <dd class="text-gray-800"
                                        x-text="tipo==='organico' ? 'Orgánico'
                                            : (tipo==='inorganico' ? 'Inorgánico'
                                            : (tipo==='peligroso' ? 'Peligroso' : '—'))"></dd>
                                </div>

                                <div class="flex justify-between sm:block">
                                    <dt class="font-medium text-emerald-900">Dirección</dt>
                                    <dd class="text-gray-800" x-text="direccion || '—'"></dd>
                                </div>

                                <div class="flex justify-between sm:block">
                                    <dt class="font-medium text-emerald-900">Localidad</dt>
                                    <dd class="text-gray-800" x-text="localidadNombre || '—'"></dd>
                                </div>

                                <div class="flex justify-between sm:block">
                                    <dt class="font-medium text-emerald-900">Fecha</dt>
                                    <dd class="text-gray-800" x-text="fecha || '—'"></dd>
                                </div>

                                <div class="flex justify-between sm:block">
                                    <dt class="font-medium text-emerald-900">Hora</dt>
                                    <dd class="text-gray-800" x-text="hora || '—'"></dd>
                                </div>
                            </dl>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="px-5 py-2 rounded-md bg-emerald-900 text-white font-semibold">
                                PROGRAMAR
                            </button>
                            <a href="{{ route('pickups.index') }}" class="text-emerald-900 underline">Cancelar</a>
                        </div>
                    </section>
                </div>

                <input type="hidden" id="modalidad_default" name="modalidad" value="programada">
            </form>
        </div>
    </div>

    <script>
        const tipoSelectLike = document.querySelectorAll('input[name="tipo_residuo"]');
        const fechaEl  = document.getElementById('fecha_programada');
        const horaEl   = document.getElementById('hora_programada');
        const hint     = document.getElementById('hint-organico');

        function currentTipo() {
            const el = document.querySelector('input[name="tipo_residuo"]:checked');
            return el ? el.value : '';
        }

        function toggleUI() {
            const tipo = currentTipo();

            if (tipo === 'organico') {
                fechaEl.disabled = true;  fechaEl.required = false; fechaEl.value = '';
                horaEl.disabled  = true;  horaEl.required  = false; horaEl.value  = '';
                hint.classList.remove('hidden');
            } else if (tipo === 'inorganico') {
                fechaEl.disabled = false; fechaEl.required = true;
                horaEl.disabled  = false; horaEl.required  = false;
                hint.classList.add('hidden');
            } else if (tipo === 'peligroso') {
                fechaEl.disabled = false; fechaEl.required = true;
                horaEl.disabled  = false; horaEl.required  = true;
                hint.classList.add('hidden');
            } else {
                fechaEl.disabled = false; fechaEl.required = false;
                horaEl.disabled  = false; horaEl.required  = false;
                hint.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            tipoSelectLike.forEach(r => r.addEventListener('change', toggleUI));
            toggleUI();
        });
    </script>
</x-app-layout>
