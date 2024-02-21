<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Gabinete Fisioterapia - @yield('title')</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{!! asset('/plugins/fontawesome-free/css/all.min.css') !!}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{!! asset('/dist/css/adminlte.min.css') !!}">
  <!-- Google Font: Source Sans Pro -->
  {{-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> --}}
  <link rel="stylesheet" href="{!! asset('/css/fonts.css') !!}">
 <!-- REQUIRED SCRIPTS ADMIN-->
  <!-- jQuery -->
  <script src="{!! asset('/plugins/jquery/jquery.min.js') !!}"></script>
  <!-- Bootstrap 4 -->
  <script src="{!! asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
  <!-- AdminLTE App -->
  <script src="{!! asset('/dist/js/adminlte.min.js') !!}"></script>

  <!-- Calendario -->
  {{-- <script src="{!! asset('/calendario/js/moment.min.js') !!}"></script>
  <link rel="stylesheet" href="{!! asset('/calendario/css/fullcalendar.min.css') !!}">
  <script src="{!! asset('/calendario/js/fullcalendar.min.js') !!}"></script>
  <script src="{!! asset('/calendario/js/es.js') !!}"></script> --}}
 
<!-- Calendario v5 render-->
  <link href="{!! asset('/calen/main.css') !!}" rel='stylesheet' />
  {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.9.0/main.css"> --}}
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.9.0/main.min.js"></script>
  {{-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.9.0/locales-all.js"></script> --}}
  <script src="{!! asset('/calen/locales-all.js') !!}"></script>
  <script src="{!! asset('/calen/main.js') !!}"></script>
{{-- axios --}}
  <script src="{!! asset('/axios/axios.min.js') !!}"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> --}}
  <script src="{!! asset('/java/popper.min.js') !!}"></script>
  <script src="{!! asset('/java/bootstrap.min.js') !!}"></script>


</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- arriba -->
    @include('layouts.topnavbar')
    <!-- menu -->
    @include('layouts.navbar')
    <!-- contenido -->
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <h1 class="m-0 text-dark">Gabinete Fisioterapia - @yield('subtitulo')</h1>
        </div><!-- /.container-fluid -->
      </div>
      <div class="content">
        @yield('content')
        @section('content')
        ajvakjsvhc
        @endsection
      </div>          
    </div>
    <!--footer -->
    @include('layouts.footer')
  </div>
 
</body>
</html>
