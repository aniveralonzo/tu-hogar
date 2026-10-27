@extends('layouts.tuhogar')
@section('titulo', 'Registro de Empleados | Tu Hogar')

@section('contenido')
@php $fmt = fn ($s) => sprintf('%02d:%02d:%02d', intdiv($s, 3600), intdiv($s % 3600, 60), $s % 60); @endphp

<h3 class="th-titulo mb-3">Registro de Empleados</h3>

<div class="row g-4">
    {{-- IZQUIERDA: tabla de turnos --}}
    <div class="col-xl-9">
        <div class="card shadow-sm">
            <div class="card-header th-card-header">Turnos de esta semana (se actualiza cada 30 s)</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Empleado</th>
                                <th>Estado</th>
                                <th>Último inicio</th>
                                <th>Último fin</th>
                                @foreach ($dias as $nombreDia) <th>{{ $nombreDia }}</th> @endforeach
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($filas as $f)
                            <tr>
                                <td class="fw-semibold">{{ $f['empleado']->name }}</td>
                                <td>
                                    @if ($f['activo'])
                                    <span class="badge bg-success">Conectado</span>
                                    @else
                                    <span class="badge bg-secondary">Desconectado</span>
                                    @endif
                                </td>
                                <td>{{ $f['ultimo'] ? $f['ultimo']->inicio->format('d/m H:i') : '—' }}</td>
                                <td>{{ $f['ultimo'] && $f['ultimo']->fin ? $f['ultimo']->fin->format('d/m H:i') : ($f['activo'] ? 'En curso' : '—') }}</td>
                                @foreach ($f['porDia'] as $seg)
                                <td>{{ $seg ? $fmt($seg) : '—' }}</td>
                                @endforeach
                                <td class="fw-bold">{{ $fmt($f['total']) }}</td>
                                <td>
                                    @if ($f['activo'])
                                    <form method="POST" action="{{ route('admin.turnos.cerrar', $f['activo']) }}"
                                        onsubmit="return confirm('¿Cerrar el turno y desloguear a este empleado?')">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger">Desloguear</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- DERECHA: accesos en otra ventana (misma sesión) --}}
    <div class="col-xl-3">
        <div class="row g-3">
            <div class="col-md-6 col-xl-12">
                <a class="th-tile shadow-sm" href="{{ route('productos.index') }}" target="_blank" rel="noopener">
                    <div class="fs-2">📦</div>
                    <h6 class="fw-bold mt-1 mb-0">Registrar producto BD</h6>
                </a>
            </div>
            <div class="col-md-6 col-xl-12">
                <a class="th-tile shadow-sm" href="{{ route('ventas.index') }}" target="_blank" rel="noopener">
                    <div class="fs-2">🧾</div>
                    <h6 class="fw-bold mt-1 mb-0">Ingreso de Ventas</h6>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // "Tiempo real" sencillo: recarga la tabla cada 30 segundos
    setTimeout(() => location.reload(), 30000);
</script>
@endpush