{{-- resources/views/admin/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PATCH') {{-- IMPORTANTE: coincide con la ruta PATCH --}}

                    <div class="mb-4">
                        <x-input-label for="name" value="Nombre" />
                        <x-text-input id="name" name="name" class="block w-full mt-1"
                                      type="text" required
                                      :value="old('name', $user->name)" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" class="block w-full mt-1"
                                      type="email" required
                                      :value="old('email', $user->email)" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="cedula" value="Cédula" />
                        <x-text-input id="cedula" name="cedula" class="block w-full mt-1"
                                      type="text" required
                                      :value="old('cedula', $user->cedula)" />
                        <x-input-error :messages="$errors->get('cedula')" class="mt-2"/>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="telefono" value="Teléfono" />
                        <x-text-input id="telefono" name="telefono" class="block w-full mt-1"
                                      type="text" required
                                      :value="old('telefono', $user->telefono)" />
                        <x-input-error :messages="$errors->get('telefono')" class="mt-2"/>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="role" value="Rol" />
                        <select id="role" name="role" class="block w-full mt-1" required>
                            <option value="user"  @selected(old('role', $user->role) === 'user')>Usuario</option>
                            <option value="admin" @selected(old('role', $user->role) === 'admin')>Administrador</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2"/>
                    </div>

                    <div class="flex gap-3">
                        <x-primary-button>Guardar</x-primary-button>
                        <a href="{{ route('admin.users.index') }}"
                           class="inline-flex items-center px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-700">
                           Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
