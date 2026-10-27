<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    private function reglas(): array
    {
        return [
            'cliente_id'  => 'required|exists:clientes,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad'    => 'required|integer|min:1',
        ];
    }

    public function index()
    {
        $ventas    = Venta::with(['cliente', 'producto', 'user'])->latest('fecha')->paginate(10);
        $clientes  = Cliente::orderBy('nombre')->get();
        $productos = Producto::orderBy('nombre')->get();

        return view('ventas.index', compact('ventas', 'clientes', 'productos'));
    }

    // Registrar venta: usa el precio actual del producto y descuenta stock
    public function store(Request $request)
    {
        $datos    = $request->validate($this->reglas());
        $producto = Producto::findOrFail($datos['producto_id']);

        if ($datos['cantidad'] > $producto->stock) {
            return back()->withInput()->withErrors([
                'cantidad' => "Stock insuficiente (disponible: {$producto->stock}).",
            ]);
        }

        DB::transaction(function () use ($datos, $producto) {
            Venta::create([
                'cliente_id'      => $datos['cliente_id'],
                'producto_id'     => $producto->id,
                'user_id'         => auth()->id(),
                'cantidad'        => $datos['cantidad'],
                'precio_unitario' => $producto->precio,
                'total'           => $producto->precio * $datos['cantidad'],
                'fecha'           => now(),
            ]);
            $producto->decrement('stock', $datos['cantidad']);
        });

        return redirect()->route('ventas.index')->with('ok', 'Venta registrada.');
    }

    public function edit(Venta $venta)
    {
        $clientes  = Cliente::orderBy('nombre')->get();
        $productos = Producto::orderBy('nombre')->get();

        return view('ventas.edit', compact('venta', 'clientes', 'productos'));
    }

    // Actualizar venta: devuelve el stock anterior y descuenta el nuevo
    public function update(Request $request, Venta $venta)
    {
        $datos = $request->validate($this->reglas());
        $nuevo = Producto::findOrFail($datos['producto_id']);

        // Stock disponible = stock actual + lo que esta venta ya había descontado (si es el mismo producto)
        $disponible = $nuevo->stock + ((int) $venta->producto_id === (int) $nuevo->id ? $venta->cantidad : 0);

        if ($datos['cantidad'] > $disponible) {
            return back()->withInput()->withErrors([
                'cantidad' => "Stock insuficiente (disponible: {$disponible}).",
            ]);
        }

        DB::transaction(function () use ($datos, $venta, $nuevo) {
            Producto::whereKey($venta->producto_id)->increment('stock', $venta->cantidad); // devolver
            Producto::whereKey($nuevo->id)->decrement('stock', $datos['cantidad']);        // descontar

            $venta->update([
                'cliente_id'      => $datos['cliente_id'],
                'producto_id'     => $nuevo->id,
                'cantidad'        => $datos['cantidad'],
                'precio_unitario' => $nuevo->precio,
                'total'           => $nuevo->precio * $datos['cantidad'],
            ]);
        });

        return redirect()->route('ventas.index')->with('ok', 'Venta actualizada.');
    }

    // Eliminar venta: devuelve el stock
    public function destroy(Venta $venta)
    {
        DB::transaction(function () use ($venta) {
            Producto::whereKey($venta->producto_id)->increment('stock', $venta->cantidad);
            $venta->delete();
        });

        return redirect()->route('ventas.index')->with('ok', 'Venta eliminada.');
    }
}
