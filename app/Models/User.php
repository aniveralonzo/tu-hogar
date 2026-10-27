<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Bono de ley fijo (Decreto 37-2001)
    public const BONO_37_2001 = 250;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'puesto',
        'sueldo_base',
        'comisiones',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'sueldo_base'       => 'decimal:2',
            'comisiones'        => 'decimal:2',
        ];
    }

    // Un usuario tiene muchos turnos
    public function turnos(): HasMany
    {
        return $this->hasMany(Turno::class);
    }

    // Devuelve el turno abierto (sin fin) o null
    public function turnoActivo(): ?Turno
    {
        return $this->turnos()->whereNull('fin')->latest('inicio')->first();
    }

    // Total devengado = sueldo base + bono 37-2001 + comisiones
    public function getTotalDevengadoAttribute(): float
    {
        return (float) $this->sueldo_base + self::BONO_37_2001 + (float) $this->comisiones;
    }
}
