<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venta extends Model
{
    protected $fillable = [
        'cliente_id',
        'producto_id',
        'user_id',
        'cantidad',
        'precio_unitario',
        'total',
        'fecha',
    ];

    protected $casts = ['fecha' => 'datetime'];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
