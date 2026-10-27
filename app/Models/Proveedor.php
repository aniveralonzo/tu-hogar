<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    // Nombre explícito porque Laravel pluraliza en inglés ("proveedors")
    protected $table = 'proveedores';

    protected $fillable = ['nombre', 'contacto', 'telefono', 'email'];
}
