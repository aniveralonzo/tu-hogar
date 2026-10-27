<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminTurnoController extends Controller
{
    // Tabla de turnos de la semana actual (lunes a domingo)
    public function index()
    {
        $empleados = User::where('role', 'empleado')->orderBy('name')->get();

        // Turnos de esta semana, agrupados por empleado
        $turnosSemana = Turno::whereBetween('inicio', [now()->startOfWeek(), now()->endOfWeek()])
            ->get()
            ->groupBy('user_id');

        // Turnos abiertos ahora mismo (empleados conectados)
        $activos = Turno::whereNull('fin')->get()->keyBy('user_id');

        $dias = [1 => 'Lun', 2 => 'Mar', 3 => 'Mié', 4 => 'Jue', 5 => 'Vie', 6 => 'Sáb', 7 => 'Dom'];

        $filas = $empleados->map(function (User $empleado) use ($turnosSemana, $activos) {
            $turnos = $turnosSemana->get($empleado->id, collect());

            // Segundos acumulados por día de la semana (1 = lunes ... 7 = domingo)
            $porDia = array_fill(1, 7, 0);
            foreach ($turnos as $turno) {
                $porDia[$turno->inicio->dayOfWeekIso] += $turno->segundos();
            }

            return [
                'empleado' => $empleado,
                'activo'   => $activos->get($empleado->id),
                'ultimo'   => $turnos->sortByDesc('inicio')->first(),
                'porDia'   => $porDia,
                'total'    => array_sum($porDia),
            ];
        });

        return view('admin.turnos', compact('filas', 'dias'));
    }

    // "Desloguear": cierra el turno y elimina sus sesiones activas
    public function cerrar(Turno $turno)
    {
        if (is_null($turno->fin)) {
            $turno->update(['fin' => now()]);
        }

        // Con SESSION_DRIVER=database esto cierra la sesión del empleado de verdad
        DB::table('sessions')->where('user_id', $turno->user_id)->delete();

        return back()->with('ok', 'Turno cerrado y sesión del empleado finalizada.');
    }
}
