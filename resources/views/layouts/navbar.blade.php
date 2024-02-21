<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{!! asset('img/logo.jpg') !!}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">Gabinete Isacc Duchen</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div> --}}

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @if (Auth::user()->rol_id==2 OR  Auth::user()->rol_id==1 )
          <li class="nav-item">
            <a href="{{ route('usuarios.index') }}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Usuarios
              </p>
            </a>
          </li>
        @endif
        @if (Auth::user()->rol_id<>5 )
          <li class="nav-item">
            <a href="{{ route('pacientes.index') }}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Pacientes
              </p>
            </a>
          </li>
        @endif

        <li class="nav-item">
          <a href="{{ route('bandejas.index') }}" class="nav-link">
            <i class="nav-icon fas fa-inbox"></i>
            <p>
              Bandeja
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('historiales.index') }}" class="nav-link">
            <i class="nav-icon fas fa-file"></i>
            <p>
              Historiales
            </p>
          </a>
        </li>

        <li class="nav-item">
          {{-- cuando es Fisioterapeuta --}}
          <a href="{{ route('citas.indexf') }}" class="nav-link">
            <i class="nav-icon fas fa-calendar-check"></i>
            <p>
              Citas
            </p>
          </a>
        </li>

        {{-- <li class="nav-item">
          <a href="{{ route('informes.inindex') }}" class="nav-link">
            <i class="nav-icon fas fa-file"></i>
            <p>
              Informes
            </p>
          </a>
        </li> --}}

        <li class="nav-item">
          <a href="{{ route('reportes.index') }}" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
              Reportes
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('investigacion.invesindex') }}" class="nav-link">
            <i class="nav-icon fas fa-search-plus"></i>
            <p>
              Investigación
            </p>
          </a>
        </li>

        
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

