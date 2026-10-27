<?php

namespace App\Http\Controllers;

use App\Models\PedidoProveedor;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Http\Request;

class PlanillaController extends Controller
{
    public function index()
    {
        $empleados = User::where('role', 'empleado')->orderBy('name')->get();

        // Resumen financiero
        $totalSueldos  = $empleados->sum(fn(User $e) => $e->total_devengado);
        $ingresos      = (float) Venta::sum('total');
        $costosPedidos = (float) PedidoProveedor::sum('total');
        $ganancia      = $ingresos - $costosPedidos - $totalSueldos;

        return view('planilla.index', compact('empleados', 'totalSueldos', 'ingresos', 'costosPedidos', 'ganancia'));
    }

    // Guarda sueldo base y comisiones (el bono 37-2001 es fijo)
    public function update(Request $request, User $user)
    {
        abort_unless($user->role === 'empleado', 404);

        $datos = $request->validate([
            'sueldo_base' => 'required|numeric|min:0',
            'comisiones'  => 'required|numeric|min:0',
        ]);

        $user->update($datos);

        return back()->with('ok', "Planilla de {$user->name} actualizada.");
    }
}
