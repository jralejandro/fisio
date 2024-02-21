<div class="col-sm-6 invoice-col">
    <strong>{{ $roles->rol }}</strong> <br>
    <strong>Documento Identidad:</strong> {{ $pacientes->ci }} {{ $departamentos->abreviatura }}<br>
    <strong>Paterno:</strong> {{ $pacientes->aPaterno }} <br>
    <strong>Materno:</strong> {{ $pacientes->aMaterno }}  <br>
    <strong>Nombres:</strong> {{ $pacientes->nombre }}  <br>
    <strong>Genero:</strong> 
    @if ($pacientes->genero == "M" )
        MASCULINO
    @else
        FEMENINO
    @endif    
    <br>
    <strong>Fecha Nacimiento:</strong> {{ $pacientes->fechaNacimiento }}  <br>
</div>
<div class="col-sm-6 invoice-col"><br>
    <strong>Dirección:</strong> {{ $pacientes->direccion }} <br>
    <strong>Telefono:</strong> {{ $pacientes->telefono }}  <br>
    <strong>Celular:</strong> {{ $pacientes->celular }}  <br>
    <strong>Estado:</strong> {{ $pacientes->estado }}  <br>
    <strong>Usuario:</strong> {{ $usuarios->usuario }} <br>
    {{-- <strong>Turno:</strong> {{ $pacientes->turno }} <br> --}}
</div>