<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedidoProveedor extends Model
{
    protected $table = 'pedidos_proveedores';

    protected $fillable = [
        'proveedor_id',
        'producto_id',
        'cantidad',
        'costo_unitario',
        'total',
        'estado',
        'fecha',
    ];

    protected $casts = ['fecha' => 'date'];

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}
