<div class="col-sm-6 invoice-col">
    <strong>{{ $roles->rol }}</strong> <br>
    <strong>Documento Identidad:</strong> {{ $empleados->ci }} {{ $departamentos->abreviatura }}<br>
    <strong>Paterno:</strong> {{ $empleados->aPaterno }} <br>
    <strong>Materno:</strong> {{ $empleados->aMaterno }}  <br>
    <strong>Nombres:</strong> {{ $empleados->nombre }}  <br>
    <strong>Genero:</strong> 
    @if ($empleados->genero == "M" )
        MASCULINO
    @else
        FEMENINO
    @endif    
    <br>
    <strong>Fecha Nacimiento:</strong> {{ $empleados->fechaNacimiento }}  <br>
</div>
<div class="col-sm-6 invoice-col"><br>
    <strong>Dirección:</strong> {{ $empleados->direccion }} <br>
    <strong>Telefono:</strong> {{ $empleados->telefono }}  <br>
    <strong>Celular:</strong> {{ $empleados->celular }}  <br>
    <strong>Estado:</strong> {{ $usuarios->estado }}  <br>
    <strong>Usuario:</strong> {{ $usuarios->usuario }} <br>
    <strong>Turno:</strong> {{ $turnos->turno }} <br>
</div>