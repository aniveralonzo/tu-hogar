@extends('layouts.tuhogar')
@section('titulo', 'Inicio | Tu Hogar')

@section('contenido')
@php $fmt = fn ($s) => sprintf('%02d:%02d:%02d', intdiv($s, 3600), intdiv($s % 3600, 60), $s % 60); @endphp

<div class="row g-4">
    {{-- IZQUIERDA: control de turno --}}
    <div class="col-lg-5">
        <div class="card shadow-sm h-100">
            <div class="card-header th-card-header">Control de turno</div>
            <div class="card-body text-center">
                @if ($turnoActivo)
                <span class="badge bg-success mb-2">Turno en curso</span>
                <div class="display-5 fw-bold" id="reloj-turno">{{ $fmt($segundosTurno) }}</div>
                <p class="text-muted small">Inició a las {{ $turnoActivo->inicio->format('H:i:s') }}</p>
                <form method="POST" action="{{ route('empleado.turno.finalizar') }}">
                    @csrf
                    <button class="btn btn-danger w-100 py-2">Finalizar turno</button>
                </form>
                @else
                <span class="badge bg-secondary mb-2">Sin turno activo</span>
                <div class="display-5 fw-bold text-muted">00:00:00</div>
                <p class="text-muted small">Pulsa para empezar a contar tu tiempo</p>
                <form method="POST" action="{{ route('empleado.turno.iniciar') }}">
                    @csrf
                    <button class="btn btn-th w-100 py-2">Iniciar turno</button>
                </form>
                @endif

                <hr>
                <div class="text-muted small">Tiempo conectado hoy</div>
                <div class="fs-3 fw-semibold" id="reloj-hoy">{{ $fmt($segundosHoy) }}</div>

                @if ($turnosHoy->count())
                <div class="table-responsive mt-3">
                    <table class="table table-sm table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Inicio</th>
                                <th>Fin</th>
                                <th>Duración</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($turnosHoy as $t)
                            <tr>
                                <td>{{ $t->inicio->format('H:i') }}</td>
                                <td>{{ $t->fin ? $t->fin->format('H:i') : 'En curso' }}</td>
                                <td>{{ $fmt($t->segundos()) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- DERECHA: accesos (se abren en otra ventana, misma sesión) --}}
    <div class="col-lg-7">
        <div class="row gx-4 gy-0 h-100">
            <div class="col-md-6 d-flex mb-4 mb-md-0">
                <a class="th-tile shadow-sm w-100 d-flex flex-column justify-content-center text-center align-items-center" href="{{ route('productos.index') }}" target="_blank" rel="noopener">
                    <h5 class="fw-bold mt-2">Registrar producto BD</h5>
                    <p class="mb-0 small text-muted">CRUD de productos del Home Center.</p>
                </a>
            </div>
            <div class="col-md-6 d-flex">
                <a class="th-tile shadow-sm w-100 d-flex flex-column justify-content-center text-center align-items-center" href="{{ route('ventas.index') }}" target="_blank" rel="noopener">
                    <h5 class="fw-bold mt-2">Ingreso de Ventas</h5>
                    <p class="mb-0 small text-muted">Registrar ventas a clientes.</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if ($turnoActivo)
<script>
    // Contadores en vivo: se incrementan cada segundo mientras el turno está abierto
    let segTurno = {
        {
            $segundosTurno
        }
    };
    let segHoy = {
        {
            $segundosHoy
        }
    };
    const fmt = s => [Math.floor(s / 3600), Math.floor(s % 3600 / 60), s % 60]
        .map(n => String(n).padStart(2, '0')).join(':');

    setInterval(() => {
        segTurno++;
        segHoy++;
        document.getElementById('reloj-turno').textContent = fmt(segTurno);
        document.getElementById('reloj-hoy').textContent = fmt(segHoy);
    }, 1000);
</script>
@endif
@endpush