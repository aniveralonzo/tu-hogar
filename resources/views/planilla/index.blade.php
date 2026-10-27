@extends('layouts.tuhogar')
@section('titulo', 'Planilla | Finanzas | Tu Hogar')

@section('contenido')
<h3 class="th-titulo mb-3">Planilla | Finanzas</h3>

{{-- TABLA 1: planilla de sueldos --}}
<div class="card shadow-sm mb-4">
    <div class="card-header th-card-header">Planilla de sueldos</div>
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Puesto</th>
                    <th>Sueldo base (Q)</th>
                    <th>Bono 37-2001 (Q)</th>
                    <th>Comisiones (Q)</th>
                    <th>Total devengado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($empleados as $e)
                <tr>
                    <td class="fw-semibold">{{ $e->name }}</td>
                    <td>{{ $e->puesto }}</td>
                    {{-- Los inputs apuntan al <form> del final de la fila con el atributo form="" --}}
                    <td style="min-width:140px">
                        <input form="f{{ $e->id }}" name="sueldo_base" type="number" step="0.01" min="0"
                            class="form-control form-control-sm" value="{{ $e->sueldo_base }}">
                    </td>
                    <td>{{ number_format(\App\Models\User::BONO_37_2001, 2) }}</td>
                    <td style="min-width:140px">
                        <input form="f{{ $e->id }}" name="comisiones" type="number" step="0.01" min="0"
                            class="form-control form-control-sm" value="{{ $e->comisiones }}">
                    </td>
                    <td class="fw-bold">Q{{ number_format($e->total_devengado, 2) }}</td>
                    <td>
                        <form id="f{{ $e->id }}" method="POST" action="{{ route('planilla.update', $e) }}">
                            @csrf @method('PUT')
                            <button class="btn btn-sm btn-th">Guardar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <td colspan="5" class="text-end fw-bold">Total sueldos</td>
                    <td colspan="2" class="fw-bold">Q{{ number_format($totalSueldos, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

{{-- TABLA 2: resumen de ganancias --}}
<div class="card shadow-sm">
    <div class="card-header th-card-header">Resumen de ganancias</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <tbody>
                <tr>
                    <td>Ingresos por ventas</td>
                    <td class="text-end">Q{{ number_format($ingresos, 2) }}</td>
                </tr>
                <tr>
                    <td>(−) Costo de pedidos a proveedores</td>
                    <td class="text-end">Q{{ number_format($costosPedidos, 2) }}</td>
                </tr>
                <tr>
                    <td>(−) Costo total de sueldos</td>
                    <td class="text-end">Q{{ number_format($totalSueldos, 2) }}</td>
                </tr>
                <tr class="fw-bold {{ $ganancia >= 0 ? 'table-success' : 'table-danger' }}">
                    <td>Ganancia neta</td>
                    <td class="text-end">Q{{ number_format($ganancia, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection