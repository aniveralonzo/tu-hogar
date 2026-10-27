<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Turno extends Model
{
    protected $fillable = ['user_id', 'inicio', 'fin'];

    protected $casts = [
        'inicio' => 'datetime',
        'fin'    => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Segundos que duró el turno (si sigue abierto, cuenta hasta ahora)
    public function segundos(): int
    {
        $fin = $this->fin ?? now();
        return max(0, $fin->getTimestamp() - $this->inicio->getTimestamp());
    }
}
