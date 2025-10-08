<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-[#f4fbf6] to-white">
        <div class="w-full max-w-md bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl p-8">
            
            <!-- Título -->
            <h1 class="text-center text-3xl font-extrabold text-emerald-900 mb-6">
                Crear Cuenta
            </h1>

            <!-- Formulario -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nombre -->
                <div>
                    <x-input-label for="name" :value="__('Nombre')" class="text-emerald-900 font-semibold"/>
                    <x-text-input id="name" class="block mt-1 w-full border-gray-300 rounded-md focus:border-emerald-600 focus:ring-emerald-600"
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Correo -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Correo Electrónico')" class="text-emerald-900 font-semibold"/>
                    <x-text-input id="email" class="block mt-1 w-full border-gray-300 rounded-md focus:border-emerald-600 focus:ring-emerald-600"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Cédula -->
                <div class="mt-4">
                    <x-input-label for="cedula" :value="__('Cédula')" class="text-emerald-900 font-semibold"/>
                    <x-text-input id="cedula" class="block mt-1 w-full border-gray-300 rounded-md focus:border-emerald-600 focus:ring-emerald-600"
                        type="text" name="cedula" :value="old('cedula')" required />
                    <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                </div>

                <!-- Teléfono -->
                <div class="mt-4">
                    <x-input-label for="telefono" :value="__('Teléfono')" class="text-emerald-900 font-semibold"/>
                    <x-text-input id="telefono" class="block mt-1 w-full border-gray-300 rounded-md focus:border-emerald-600 focus:ring-emerald-600"
                        type="text" name="telefono" :value="old('telefono')" required />
                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

                <!-- Contraseña -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" class="text-emerald-900 font-semibold"/>
                    <x-text-input id="password" class="block mt-1 w-full border-gray-300 rounded-md focus:border-emerald-600 focus:ring-emerald-600"
                        type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-emerald-900 font-semibold"/>
                    <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-md focus:border-emerald-600 focus:ring-emerald-600"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-emerald-800 hover:text-emerald-900 underline">
                        ¿Ya tienes una cuenta?
                    </a>

                    <x-primary-button class="bg-emerald-700 hover:bg-emerald-800 text-white font-semibold px-6 py-2 rounded-md">
                        {{ __('Registrarse') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
