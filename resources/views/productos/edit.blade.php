@extends('layouts.tuhogar')
@section('titulo', 'Editar producto | Tu Hogar')

@section('contenido')
<h3 class="th-titulo mb-3">Editar producto #{{ $producto->id }}</h3>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('productos.update', $producto) }}" class="row g-3">
            @csrf @method('PUT')
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Descripción</label>
                <input name="descripcion" class="form-control" value="{{ old('descripcion', $producto->descripcion) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Precio (Q)</label>
                <input name="precio" type="number" step="0.01" min="0" class="form-control" value="{{ old('precio', $producto->precio) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Stock</label>
                <input name="stock" type="number" min="0" class="form-control" value="{{ old('stock', $producto->stock) }}" required>
            </div>
            <div class="col-12">
                <button class="btn btn-th">Actualizar</button>
                <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection