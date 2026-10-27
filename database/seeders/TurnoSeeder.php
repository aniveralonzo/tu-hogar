<?php

namespace Database\Seeders;

use App\Models\Turno;
use App\Models\User;
use Illuminate\Database\Seeder;

class TurnoSeeder extends Seeder
{
    public function run(): void
    {
        // Turnos cerrados de los últimos 6 días para cada empleado
        foreach (User::where('role', 'empleado')->get() as $empleado) {
            for ($d = 1; $d <= 6; $d++) {
                $inicio = now()->subDays($d)->setTime(8, rand(0, 30));
                $fin    = $inicio->copy()->addHours(8)->addMinutes(rand(0, 45));

                Turno::create([
                    'user_id' => $empleado->id,
                    'inicio'  => $inicio,
                    'fin'     => $fin,
                ]);
            }
        }
    }
}
