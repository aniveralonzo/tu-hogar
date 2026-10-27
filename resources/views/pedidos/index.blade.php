@extends('layouts.tuhogar')
@section('titulo', 'Pedidos Proveedores | Tu Hogar')

@section('contenido')
<h3 class="th-titulo mb-3">Pedidos a Proveedores</h3>

{{-- Alta de pedido --}}
<div class="card shadow-sm mb-4">
    <div class="card-header th-card-header">Nuevo pedido</div>
    <div class="card-body">
        <form method="POST" action="{{ route('pedidos.store') }}" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Proveedor</label>
                <select name="proveedor_id" class="form-select" required>
                    <option value="">Seleccione...</option>
                    @foreach ($proveedores as $pr)
                    <option value="{{ $pr->id }}" @selected(old('proveedor_id')==$pr->id)>{{ $pr->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Producto</label>
                <select name="producto_id" class="form-select" required>
                    <option value="">Seleccione...</option>
                    @foreach ($productos as $p)
                    <option value="{{ $p->id }}" @selected(old('producto_id')==$p->id)>{{ $p->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label">Cantidad</label>
                <input name="cantidad" type="number" min="1" class="form-control" value="{{ old('cantidad', 1) }}" required>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label">Costo unit. (Q)</label>
                <input name="costo_unitario" type="number" step="0.01" min="0" class="form-control" value="{{ old('costo_unitario') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select" required>
                    <option value="pendiente" @selected(old('estado')==='pendiente' )>Pendiente</option>
                    <option value="recibido" @selected(old('estado')==='recibido' )>Recibido</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Fecha</label>
                <input name="fecha" type="date" class="form-control" value="{{ old('fecha', now()->toDateString()) }}" required>
            </div>
            <div class="col-12"><button class="btn btn-th">Registrar pedido</button></div>
        </form>
    </div>
</div>

{{-- Listado --}}
<div class="card shadow-sm">
    <div class="card-header th-card-header">Pedidos registrados</div>
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>Producto</th>
                    <th>Cant.</th>
                    <th>Costo unit.</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $o)
                <tr>
                    <td>{{ $o->fecha->format('d/m/Y') }}</td>
                    <td>{{ $o->proveedor->nombre }}</td>
                    <td>{{ $o->producto->nombre }}</td>
                    <td>{{ $o->cantidad }}</td>
                    <td>Q{{ number_format($o->costo_unitario, 2) }}</td>
                    <td class="fw-semibold">Q{{ number_format($o->total, 2) }}</td>
                    <td>
                        <span class="badge {{ $o->estado === 'recibido' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($o->estado) }}</span>
                    </td>
                    <td class="text-nowrap">
                        <a href="{{ route('pedidos.edit', $o) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                        <form method="POST" action="{{ route('pedidos.destroy', $o) }}" class="d-inline"
                            onsubmit="return confirm('¿Eliminar este pedido?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $pedidos->links('pagination::bootstrap-5') }}</div>
</div>
@endsection