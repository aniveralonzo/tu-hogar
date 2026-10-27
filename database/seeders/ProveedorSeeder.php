<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        $proveedores = [
            ['Ferretería Industrial S.A.',  'Luis Herrera',   '2255-1001', 'ventas@ferreind.com'],
            ['Cementos del Norte',          'Marta Castillo', '2255-1002', 'pedidos@cementosnorte.com'],
            ['Pinturas Colorín',            'Pedro Gómez',    '2255-1003', 'info@colorin.com'],
            ['Maderas y Tableros',          'Sofía Ruiz',     '2255-1004', 'contacto@maderastab.com'],
            ['Eléctricos Centroamérica',    'Daniel Soto',    '2255-1005', 'ventas@electroca.com'],
        ];

        foreach ($proveedores as [$nombre, $contacto, $telefono, $email]) {
            Proveedor::create(compact('nombre', 'contacto', 'telefono', 'email'));
        }
    }
}
