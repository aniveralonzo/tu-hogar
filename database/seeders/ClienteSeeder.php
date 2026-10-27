<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        // 20 clientes con nombres en español generados con Faker
        for ($i = 0; $i < 20; $i++) {
            Cliente::create([
                'nombre'   => fake('es_ES')->name(),
                'telefono' => fake()->numerify('####-####'),
                'email'    => fake()->unique()->safeEmail(),
            ]);
        }
    }
}
