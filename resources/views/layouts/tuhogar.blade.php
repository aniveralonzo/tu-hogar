<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Tu Hogar')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('css/base.css')}}" rel="stylesheet">
    <link href="{{asset('css/layout.css')}}" rel="stylesheet">
    <link href="{{asset('css/componentes.css')}}" rel="stylesheet">
    @stack('estilos')
</head>

<body class="d-flex flex-column min-vh-100">

    {{-- HEADER: nombre de la app + usuario | Log Out --}}
    <header class="th-header py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <span class="fs-4 fw-bold">Tu <span class="th-acento">Hogar</span></span>
            <div class="d-flex align-items-center gap-2 small">
                <span>{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
                <span>|</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-amarillo">Log Out</button>
                </form>
            </div>
        </div>
    </header>

    {{-- NAVEGACIÓN según el rol --}}
    <nav class="navbar navbar-expand-md navbar-dark th-nav py-0">
        <div class="container">
            <span class="navbar-text text-white d-md-none py-2">Menú</span>
            <button class="navbar-toggler my-1" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav">
                    @if (auth()->user()->role === 'administrador')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.turnos', 'productos.*', 'ventas.*') ? 'active' : '' }}"
                            href="{{ route('admin.turnos') }}">Registro de Empleados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pedidos.*') ? 'active' : '' }}"
                            href="{{ route('pedidos.index') }}">Pedidos Proveedores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('planilla.*') ? 'active' : '' }}"
                            href="{{ route('planilla.index') }}">Planilla-Finanzas</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('empleado.*', 'productos.*', 'ventas.*') ? 'active' : '' }}"
                            href="{{ route('empleado.inicio') }}">Inicio</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="container py-4 flex-grow-1">
        @if (session('ok'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('ok') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('contenido')
    </main>

    {{-- FOOTER --}}
    <footer class="th-footer py-2 text-center">
        <small>Hazlo tú mismo!!!</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>