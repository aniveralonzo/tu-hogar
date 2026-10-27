@extends('layouts.tuhogar')
@section('titulo', 'Editar venta | Tu Hogar')

@section('contenido')
<h3 class="th-titulo mb-3">Editar venta #{{ $venta->id }}</h3>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('ventas.update', $venta) }}" class="row g-3">
            @csrf @method('PUT')
            <div class="col-md-4">
                <label class="form-label">Cliente</label>
                <select name="cliente_id" class="form-select" required>
                    @foreach ($clientes as $c)
                    <option value="{{ $c->id }}" @selected(old('cliente_id', $venta->cliente_id) == $c->id)>{{ $c->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Producto</label>
                <select name="producto_id" class="form-select" required>
                    @foreach ($productos as $p)
                    <option value="{{ $p->id }}" @selected(old('producto_id', $venta->producto_id) == $p->id)>
                        {{ $p->nombre }} — Q{{ number_format($p->precio, 2) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Cantidad</label>
                <input name="cantidad" type="number" min="1" class="form-control" value="{{ old('cantidad', $venta->cantidad) }}" required>
            </div>
            <div class="col-12">
                <button class="btn btn-th">Actualizar</button>
                <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection