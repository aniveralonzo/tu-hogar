<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // El orden importa por las llaves foráneas
        $this->call([
            UserSeeder::class,            // 1 admin + 4 empleados
            ProveedorSeeder::class,       // 5 proveedores
            ClienteSeeder::class,         // 20 clientes
            ProductoSeeder::class,        // 50 productos
            PedidoProveedorSeeder::class, // 25 pedidos a proveedores
            VentaSeeder::class,           // 40 ventas de ejemplo
            TurnoSeeder::class,           // turnos de la semana para el panel admin
        ]);
    }
}
