@extends('layouts.tuhogar')
@section('titulo', 'Editar pedido | Tu Hogar')

@section('contenido')
<h3 class="th-titulo mb-3">Editar pedido #{{ $pedido->id }}</h3>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('pedidos.update', $pedido) }}" class="row g-3">
            @csrf @method('PUT')
            <div class="col-md-4">
                <label class="form-label">Proveedor</label>
                <select name="proveedor_id" class="form-select" required>
                    @foreach ($proveedores as $pr)
                    <option value="{{ $pr->id }}" @selected(old('proveedor_id', $pedido->proveedor_id) == $pr->id)>{{ $pr->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Producto</label>
                <select name="producto_id" class="form-select" required>
                    @foreach ($productos as $p)
                    <option value="{{ $p->id }}" @selected(old('producto_id', $pedido->producto_id) == $p->id)>{{ $p->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label">Cantidad</label>
                <input name="cantidad" type="number" min="1" class="form-control" value="{{ old('cantidad', $pedido->cantidad) }}" required>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label">Costo unit. (Q)</label>
                <input name="costo_unitario" type="number" step="0.01" min="0" class="form-control" value="{{ old('costo_unitario', $pedido->costo_unitario) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select" required>
                    <option value="pendiente" @selected(old('estado', $pedido->estado) === 'pendiente')>Pendiente</option>
                    <option value="recibido" @selected(old('estado', $pedido->estado) === 'recibido')>Recibido</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Fecha</label>
                <input name="fecha" type="date" class="form-control" value="{{ old('fecha', $pedido->fecha->toDateString()) }}" required>
            </div>
            <div class="col-12">
                <button class="btn btn-th">Actualizar</button>
                <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection