<?php

namespace App\Http\Controllers;

use App\Models\Turno;

class EmpleadoController extends Controller
{
    // Pantalla principal del empleado: reloj de turno + accesos
    public function inicio()
    {
        $usuario     = auth()->user();
        $turnoActivo = $usuario->turnoActivo();

        // Turnos de hoy y total de segundos conectados hoy
        $turnosHoy = Turno::where('user_id', $usuario->id)
            ->whereDate('inicio', today())
            ->orderBy('inicio')
            ->get();

        $segundosHoy   = $turnosHoy->sum(fn(Turno $t) => $t->segundos());
        $segundosTurno = $turnoActivo ? $turnoActivo->segundos() : 0;

        return view('empleado.inicio', compact('turnoActivo', 'turnosHoy', 'segundosHoy', 'segundosTurno'));
    }

    // Botón "Iniciar turno"
    public function iniciarTurno()
    {
        $usuario = auth()->user();

        // Evita abrir dos turnos a la vez
        if (! $usuario->turnoActivo()) {
            Turno::create(['user_id' => $usuario->id, 'inicio' => now()]);
        }

        return back()->with('ok', 'Turno iniciado.');
    }

    // Botón "Finalizar turno"
    public function finalizarTurno()
    {
        $turno = auth()->user()->turnoActivo();

        if ($turno) {
            $turno->update(['fin' => now()]);
        }

        return back()->with('ok', 'Turno finalizado.');
    }
}
