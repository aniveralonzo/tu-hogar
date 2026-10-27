<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nueva contraseña | Tu Hogar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>

<body class="d-flex flex-column align-items-center justify-content-center">
    <div class="card login-card shadow-lg w-100 mx-3">
        <div class="card-body p-4 p-md-5">
            <h1 class="h3 text-center fw-bold mb-4 auth-titulo">Restablecer contraseña</h1>

            @if ($errors->any())
            <div class="alert alert-danger py-2">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                {{-- Token que viene en el enlace del correo --}}
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                        class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Nueva contraseña</label>
                    <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                </div>
                <button type="submit" class="btn btn-th w-100 py-2">GUARDAR CONTRASEÑA</button>
            </form>
        </div>
    </div>
</body>

</html>