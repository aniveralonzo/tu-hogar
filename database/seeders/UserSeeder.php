<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1 administrador
        User::create([
            'name'     => 'Administrador Tu Hogar',
            'email'    => 'aniveralonzo@gmail.com',
            'password' => Hash::make('Admin123*'),
            'role'     => 'administrador',
            'puesto'   => 'Gerente General',
        ]);

        // 4 empleados
        $empleados = [
            ['Carlos Pérez',  'carlos@tuhogar.com', 'Cajero',              3200, 150],
            ['María López',   'maria@tuhogar.com',  'Vendedora de piso',   3000, 300],
            ['José Ramírez',  'jose@tuhogar.com',   'Bodeguero',           2900,   0],
            ['Ana Morales',   'ana@tuhogar.com',    'Supervisora de piso', 3800, 200],
        ];

        foreach ($empleados as [$nombre, $correo, $puesto, $sueldo, $comision]) {
            User::create([
                'name'        => $nombre,
                'email'       => $correo,
                'password'    => Hash::make('Empleado123*'),
                'role'        => 'empleado',
                'puesto'      => $puesto,
                'sueldo_base' => $sueldo,
                'comisiones'  => $comision,
            ]);
        }
    }
}
