@extends('layouts.tuhogar')
@section('titulo', 'Productos | Tu Hogar')

@section('contenido')
<h3 class="th-titulo mb-3">Registrar producto BD</h3>

{{-- Alta de producto --}}
<div class="card shadow-sm mb-4">
    <div class="card-header th-card-header">Nuevo producto</div>
    <div class="card-body">
        <form method="POST" action="{{ route('productos.store') }}" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Nombre</label>
                <input name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Descripción</label>
                <input name="descripcion" class="form-control" value="{{ old('descripcion') }}">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label">Precio (Q)</label>
                <input name="precio" type="number" step="0.01" min="0" class="form-control" value="{{ old('precio') }}" required>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label">Stock</label>
                <input name="stock" type="number" min="0" class="form-control" value="{{ old('stock', 0) }}" required>
            </div>
            <div class="col-12"><button class="btn btn-th">Guardar producto</button></div>
        </form>
    </div>
</div>

{{-- Listado --}}
<div class="card shadow-sm">
    <div class="card-header th-card-header">Productos registrados</div>
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->nombre }}</td>
                    <td>{{ $p->descripcion }}</td>
                    <td>Q{{ number_format($p->precio, 2) }}</td>
                    <td>{{ $p->stock }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('productos.edit', $p) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                        <form method="POST" action="{{ route('productos.destroy', $p) }}" class="d-inline"
                            onsubmit="return confirm('¿Eliminar este producto?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $productos->links('pagination::bootstrap-5') }}</div>
</div>
@endsection