<?php

namespace App\Http\Controllers;

use App\Models\PedidoProveedor;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class PedidoProveedorController extends Controller
{
    private function reglas(): array
    {
        return [
            'proveedor_id'   => 'required|exists:proveedores,id',
            'producto_id'    => 'required|exists:productos,id',
            'cantidad'       => 'required|integer|min:1',
            'costo_unitario' => 'required|numeric|min:0',
            'estado'         => 'required|in:pendiente,recibido',
            'fecha'          => 'required|date',
        ];
    }

    public function index()
    {
        $pedidos     = PedidoProveedor::with(['proveedor', 'producto'])->latest('fecha')->latest('id')->paginate(10);
        $proveedores = Proveedor::orderBy('nombre')->get();
        $productos   = Producto::orderBy('nombre')->get();

        return view('pedidos.index', compact('pedidos', 'proveedores', 'productos'));
    }

    public function store(Request $request)
    {
        $datos          = $request->validate($this->reglas());
        $datos['total'] = $datos['cantidad'] * $datos['costo_unitario'];

        PedidoProveedor::create($datos);

        return redirect()->route('pedidos.index')->with('ok', 'Pedido registrado.');
    }

    public function edit(PedidoProveedor $pedido)
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $productos   = Producto::orderBy('nombre')->get();

        return view('pedidos.edit', compact('pedido', 'proveedores', 'productos'));
    }

    public function update(Request $request, PedidoProveedor $pedido)
    {
        $datos          = $request->validate($this->reglas());
        $datos['total'] = $datos['cantidad'] * $datos['costo_unitario'];

        $pedido->update($datos);

        return redirect()->route('pedidos.index')->with('ok', 'Pedido actualizado.');
    }

    public function destroy(PedidoProveedor $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('ok', 'Pedido eliminado.');
    }
}
