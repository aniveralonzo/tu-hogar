<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Reglas de validación compartidas por store y update
    private function reglas(): array
    {
        return [
            'nombre'      => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:255',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ];
    }

    // Listado + formulario de alta
    public function index()
    {
        $productos = Producto::orderBy('nombre')->paginate(10);
        return view('productos.index', compact('productos'));
    }

    public function store(Request $request)
    {
        Producto::create($request->validate($this->reglas()));
        return redirect()->route('productos.index')->with('ok', 'Producto registrado.');
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $producto->update($request->validate($this->reglas()));
        return redirect()->route('productos.index')->with('ok', 'Producto actualizado.');
    }

    public function destroy(Producto $producto)
    {
        try {
            $producto->delete();
        } catch (QueryException $e) {
            // Si el producto ya tiene ventas o pedidos, la BD no deja borrarlo
            return back()->with('error', 'No se puede eliminar: el producto tiene ventas o pedidos asociados.');
        }

        return redirect()->route('productos.index')->with('ok', 'Producto eliminado.');
    }
}
