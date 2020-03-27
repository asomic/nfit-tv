<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Acceder a NFIT TV</title>

    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Condensed:700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=2.0">
</head>
<body class="text-center login-wrapper">
    <div class="form-wrapper">
        <form class="form-signin"
              id="login-form" action="{{ route('login') }}"
              method="POST" novalidate="novalidate">
            @csrf
            <img class="logo" src="{{ asset('img/logo.png') }}" alt="NFIT">
            <h4 class="font-strong text-center">Iniciar Sesión</h4>
    
            <div class="form-group">
                <input id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-line" type="text" name="email" placeholder="Correo electrónico" required autofocus>
    
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
    
            <div class="form-group">
                <input
                    id="password"
                    type="password"
                    class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} form-control-line"
                    type="password"
                    name="password"
                    placeholder="Contraseña"
                />
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
    
            <div class="flexbox text-detail">
                <span>
                    <label class="ui-switch switch-icon mr-2 mb-0">
                        <input type="checkbox" checked="{{ old('remember') ? 'checked' : '' }}" type="checkbox" name="remember" id="remember" >
                        <span></span>
                    </label>Recuerdame
                </span>
    
                {{-- @if (Route::has('password.request'))
                    <a class="text-primary" href="{{ route('password.request') }}">
                            {{ __('Olvidaste tu contraseña?') }}
                    </a>
                @endif --}}
            </div>
    
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-rounded btn-block">
                    Ingresar
                </button>
            </div>
        </form>
    </div>

<script>
    $(function() {
        $('#login-form').validate({
            errorClass: "help-block",
            rules: {
                email: {
                        required: true,
                        email: true
                },
                password: {
                    required: true
                }
            },
            highlight: function(e) {
                $(e).closest(".form-group").addClass("has-error")
            },
            unhighlight: function(e) {
                $(e).closest(".form-group").removeClass("has-error")
            },
        });
    });
</script>
</body>
</html>

