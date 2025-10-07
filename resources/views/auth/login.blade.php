<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-[#f4fbf6] to-white">
        <div class="w-full max-w-md bg-white/95 rounded-xl shadow-lg p-8">

            <h1 class="text-center text-3xl font-extrabold text-emerald-900 mb-6">
                Iniciar Sesión
            </h1>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Correo electrónico')" class="font-semibold text-emerald-900"/>
                    <x-text-input id="email"
                                  type="email"
                                  name="email"
                                  :value="old('email')"
                                  required autofocus autocomplete="username"
                                  class="block mt-1 w-full rounded-md border-gray-300 focus:border-emerald-600 focus:ring-emerald-600"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" class="font-semibold text-emerald-900"/>
                    <x-text-input id="password"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password"
                                  class="block mt-1 w-full rounded-md border-gray-300 focus:border-emerald-600 focus:ring-emerald-600"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                               class="rounded border-gray-300 text-emerald-700 focus:ring-emerald-600"
                               name="remember">
                        <span class="ms-2 text-sm text-gray-700">Recordarme</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-emerald-800 hover:text-emerald-600 font-medium"
                           href="{{ route('password.request') }}">
                            ¿Olvidaste la contraseña?
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full mt-6 px-6 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold rounded-md transition">
                    Iniciar sesión
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
