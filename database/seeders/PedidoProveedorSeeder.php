<?php

namespace Database\Seeders;

use App\Models\PedidoProveedor;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Database\Seeder;

class PedidoProveedorSeeder extends Seeder
{
    public function run(): void
    {
        $proveedores = Proveedor::pluck('id');

        // 25 pedidos de reposición a proveedores
        for ($i = 0; $i < 25; $i++) {
            $producto = Producto::inRandomOrder()->first();
            $cantidad = fake()->numberBetween(10, 100);
            $costo    = round($producto->precio * 0.6, 2); // costo = 60 % del precio de venta

            PedidoProveedor::create([
                'proveedor_id'   => $proveedores->random(),
                'producto_id'    => $producto->id,
                'cantidad'       => $cantidad,
                'costo_unitario' => $costo,
                'total'          => $cantidad * $costo,
                'estado'         => fake()->randomElement(['pendiente', 'recibido']),
                'fecha'          => now()->subDays(fake()->numberBetween(0, 60))->toDateString(),
            ]);
        }
    }
}
