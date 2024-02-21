<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

 
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
  <link rel="stylesheet" href="../../css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  {{-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> --}}
  <link rel="stylesheet" href="../../css/fonts.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.css">
</head>
<body style="background-image: url('../img/fondo.jpg'); background-repeat: no-repeat; background-size: cover;" class="hold-transition login-page" >
{{-- <body style="background: linear-gradient(to bottom, rgb(1, 1, 44), rgb(1, 1, 44), rgb(127,144,218));" class="hold-transition login-page" > --}}
       
<div class="login-box">  
  <div class="login-logo">
    <div class="register-box">
      <a href="/"><b style="color:#ecfc15">GABINETE DE FISIOTERAPIA</b></a></P>
      <img src={{asset('img/logo.png')}} width="30%" height="30%" alt="">
    </div>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Iniciar Sesion</p>
      <form method="POST" action="{{ route('login') }}">
        @csrf
        {{-- usuario
        <div class="input-group mb-3">
          <input id="usuario" type="text" class="form-control" placeholder="Usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <button type="submit" class="btn btn-primary btn-block">INGRESAR</button>
        </div> --}}
        <div class="bmd-form-group{{ $errors->has('usuario') ? ' has-danger' : '' }}">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
              </div>
              <input type="text" name="usuario" class="form-control" placeholder="{{ __('Usuario o Correo') }}"
                  value="{{ old('usuario', null) }}" required autocomplete="usuario" autofocus>
          </div>
          @if ($errors->has('usuario'))
          <div id="usuario-error" class="error text-danger pl-3" for="usuario" style="display: block;">
              <strong>{{ $errors->first('usuario') }}</strong>
          </div>
          @endif
      </div>
      <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
          <div class="input-group">
              <div class="input-group-prepend">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
              </div>
              <input type="password" name="password" id="password" class="form-control"
                  placeholder="{{ __('Password...') }}" required autocomplete="current-password">
          </div>
          @if ($errors->has('password'))
          <div id="password-error" class="error text-danger pl-3" for="password"
              style="display: block;">
              <strong>{{ $errors->first('password') }}</strong>
          </div>
          @endif
      </div>
      {{-- <div class="form-check mr-auto ml-3 mt-3">
        <label class="form-check-label">
            <input class="form-check-input" type="checkbox" name="remember"
                {{ old('remember') ? 'checked' : '' }}> {{ __('Remember me') }}
            <span class="form-check-sign">
                <span class="check"></span>
            </span>
        </label>
    </div> --}}
</div>
<div class="card-footer justify-content-center">
   
    <button type="submit" class="btn btn-block btn-primary  btn-lg">{{ __('Ingresar') }}</button>
</div>


      </form> 
      {{-- <p class="mb-1">
        <a href="forgot-password.html">Olvidé mi contraseña</a>
      </p> --}}
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

</body>
</html>

{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
