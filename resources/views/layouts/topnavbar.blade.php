<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      {{-- <a href="{{ route('inicio')}}" >inicio</a> --}}
    </li>
  </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!--poner del login y logout-->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">{{ $usr_sesion->nombre }} {{ $usr_sesion->aPaterno }} {{ $usr_sesion->aMaterno }}</span>
        <div class="dropdown-divider"></div>   
        <a class="dropdown-item" href="{{ route('usuarios.show', $usr_sesion->id) }}">
          <i class="fas fa-user mr-2"></i> Datos
        </a>     
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
        <div class="dropdown-divider"></div>
        {{-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> --}}
      </div>
    </li>
  </ul>    
</nav>
<!-- /.navbar -->
