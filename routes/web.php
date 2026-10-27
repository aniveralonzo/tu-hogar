<?php

use App\Http\Controllers\AdminTurnoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PedidoProveedorController;
use App\Http\Controllers\PlanillaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

// La raíz manda al login
Route::get('/', fn() => redirect()->route('login'));

// Todo lo de abajo exige estar autenticado
Route::middleware('auth')->group(function () {

    // Después del login, cada rol va a su pantalla principal
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'administrador'
            ? redirect()->route('admin.turnos')
            : redirect()->route('empleado.inicio');
    })->name('dashboard');

    // ----- SOLO EMPLEADO -----
    Route::middleware('role:empleado')->group(function () {
        Route::get('/empleado', [EmpleadoController::class, 'inicio'])->name('empleado.inicio');
        Route::post('/empleado/turno/iniciar', [EmpleadoController::class, 'iniciarTurno'])->name('empleado.turno.iniciar');
        Route::post('/empleado/turno/finalizar', [EmpleadoController::class, 'finalizarTurno'])->name('empleado.turno.finalizar');
    });

    // ----- EMPLEADO Y ADMINISTRADOR (CRUD compartidos) -----
    Route::middleware('role:empleado,administrador')->group(function () {
        Route::resource('productos', ProductoController::class)->except(['show', 'create']);
        Route::resource('ventas', VentaController::class)->except(['show', 'create']);
    });

    // ----- SOLO ADMINISTRADOR -----
    Route::middleware('role:administrador')->group(function () {
        // Opción 1: Registro de empleados | Tools
        Route::get('/admin/turnos', [AdminTurnoController::class, 'index'])->name('admin.turnos');
        Route::post('/admin/turnos/{turno}/cerrar', [AdminTurnoController::class, 'cerrar'])->name('admin.turnos.cerrar');

        // Opción 2: Pedidos a proveedores
        Route::resource('pedidos', PedidoProveedorController::class)->except(['show', 'create']);

        // Opción 3: Planilla | Finanzas
        Route::get('/admin/planilla', [PlanillaController::class, 'index'])->name('planilla.index');
        Route::put('/admin/planilla/{user}', [PlanillaController::class, 'update'])->name('planilla.update');
    });
});

require __DIR__ . '/auth.php';
