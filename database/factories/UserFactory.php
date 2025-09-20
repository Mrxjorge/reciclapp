<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Localidad; // <-- IMPORTANTE

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Toma una localidad existente (tras correr LocalidadSeeder)
        // Si aún no hay, deja null (y el DatabaseSeeder fijará una por si acaso)
        $localidadId = Localidad::inRandomOrder()->value('id');

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),

            // ---- CAMPOS NUEVOS ----
            'cedula'       => fake()->unique()->numerify('##########'),   // 10 dígitos dummy
            'direccion'    => fake()->streetAddress(),
            'telefono'     => fake()->numerify('3#########'),             // formato celular CO
            'localidad_id' => $localidadId,                                // puede ser null si no hay localidades aún
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
