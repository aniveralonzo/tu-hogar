@extends('layouts.tuhogar')
@section('titulo', 'Ventas | Tu Hogar')

@section('contenido')
<h3 class="th-titulo mb-3">Ingreso de Ventas</h3>

{{-- Alta de venta --}}
<div class="card shadow-sm mb-4">
    <div class="card-header th-card-header">Nueva venta</div>
    <div class="card-body">
        <form method="POST" action="{{ route('ventas.store') }}" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Cliente</label>
                <select name="cliente_id" class="form-select" required>
                    <option value="">Seleccione...</option>
                    @foreach ($clientes as $c)
                    <option value="{{ $c->id }}" @selected(old('cliente_id')==$c->id)>{{ $c->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Producto</label>
                <select name="producto_id" class="form-select" required>
                    <option value="">Seleccione...</option>
                    @foreach ($productos as $p)
                    <option value="{{ $p->id }}" @selected(old('producto_id')==$p->id)>
                        {{ $p->nombre }} — Q{{ number_format($p->precio, 2) }} (stock {{ $p->stock }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Cantidad</label>
                <input name="cantidad" type="number" min="1" class="form-control" value="{{ old('cantidad', 1) }}" required>
            </div>
            <div class="col-12"><button class="btn btn-th">Registrar venta</button></div>
        </form>
    </div>
</div>

{{-- Listado --}}
<div class="card shadow-sm">
    <div class="card-header th-card-header">Ventas registradas</div>
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Cant.</th>
                    <th>P. unit.</th>
                    <th>Total</th>
                    <th>Vendedor</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $v)
                <tr>
                    <td>{{ $v->fecha->format('d/m/Y H:i') }}</td>
                    <td>{{ $v->cliente->nombre }}</td>
                    <td>{{ $v->producto->nombre }}</td>
                    <td>{{ $v->cantidad }}</td>
                    <td>Q{{ number_format($v->precio_unitario, 2) }}</td>
                    <td class="fw-semibold">Q{{ number_format($v->total, 2) }}</td>
                    <td>{{ $v->user->name }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('ventas.edit', $v) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                        <form method="POST" action="{{ route('ventas.destroy', $v) }}" class="d-inline"
                            onsubmit="return confirm('¿Eliminar esta venta? El stock se devolverá.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $ventas->links('pagination::bootstrap-5') }}</div>
</div>
@endsection