<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $nombres = [
            // Herramientas (10)
            'Martillo de uña 16 oz',
            'Destornillador plano 6"',
            'Destornillador Phillips 6"',
            'Alicate universal 8"',
            'Llave ajustable 10"',
            'Cinta métrica 5 m',
            'Serrucho 20"',
            'Taladro inalámbrico 12V',
            'Nivel de burbuja 24"',
            'Caja de herramientas 17"',
            // Construcción (10)
            'Cemento gris 42.5 kg',
            'Block de concreto 15x20x40',
            'Varilla corrugada 3/8"',
            'Arena de río (saco)',
            'Piedrín (saco)',
            'Cal hidratada 25 kg',
            'Tubo PVC 1/2" 6 m',
            'Pegamento PVC 1/4 galón',
            'Lámina de zinc 10 pies',
            'Alambre de amarre (libra)',
            // Pintura (8)
            'Pintura látex blanca 1 galón',
            'Pintura látex azul 1 galón',
            'Pintura anticorrosiva 1 galón',
            'Brocha 3"',
            'Rodillo 9"',
            'Thinner 1 litro',
            'Sellador acrílico 1 galón',
            'Lija de agua #220',
            // Electricidad (8)
            'Cable THHN #12 (metro)',
            'Interruptor sencillo',
            'Tomacorriente doble',
            'Foco LED 9W',
            'Cinta aislante negra',
            'Breaker 20A',
            'Extensión eléctrica 5 m',
            'Lámpara de pared exterior',
            // Plomería (7)
            'Llave de chorro 1/2"',
            'Grifo para lavamanos',
            'Manguera de jardín 15 m',
            'Sifón plástico',
            'Cinta teflón',
            'Inodoro blanco',
            'Lavatrastos acero inoxidable',
            // Hogar y jardín (7)
            'Candado 40 mm',
            'Cerradura de pomo',
            'Bisagra 3" (par)',
            'Tornillos 1 1/2" (caja)',
            'Clavos 2" (libra)',
            'Escoba plástica',
            'Cubeta plástica 5 galones',
        ];

        foreach ($nombres as $nombre) {
            Producto::create([
                'nombre'      => $nombre,
                'descripcion' => 'Producto de ferretería y construcción',
                'precio'      => fake()->randomFloat(2, 5, 450),
                'stock'       => fake()->numberBetween(20, 200),
            ]);
        }
    }
}
