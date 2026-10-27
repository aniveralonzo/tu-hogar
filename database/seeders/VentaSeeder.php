<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Database\Seeder;

class VentaSeeder extends Seeder
{
    public function run(): void
    {
        $clientes  = Cliente::pluck('id');
        $empleados = User::where('role', 'empleado')->pluck('id');

        // 40 ventas de ejemplo (para que Finanzas tenga números)
        for ($i = 0; $i < 40; $i++) {
            $producto = Producto::inRandomOrder()->first();
            $cantidad = fake()->numberBetween(1, 5);

            Venta::create([
                'cliente_id'      => $clientes->random(),
                'producto_id'     => $producto->id,
                'user_id'         => $empleados->random(),
                'cantidad'        => $cantidad,
                'precio_unitario' => $producto->precio,
                'total'           => $producto->precio * $cantidad,
                'fecha'           => now()->subDays(fake()->numberBetween(0, 30)),
            ]);
        }
    }
}
