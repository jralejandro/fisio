@extends('pdf.layoutpdf')

@section('content')
<div class="text-center">
    <h2>{{ $titulo }}</h2>
</div>
<table class="table-info w-100 m-b-5" border="2">
    <thead>
        <tr>
            <th class="font-medium text-white text-sm font-bold bg-grey-darker">NOMBRE:</th>
            <th>{{ $paciente->aPaterno." ".$paciente->aMaterno." ".$paciente->nombre }}</th>
            <th class="font-medium text-white text-sm font-bold bg-grey-darker">FECHA INGRESO:</th>
            <th>{{ $orden->fecha }}</th>
        </tr>
        <tr>
            <th class="font-medium text-white text-sm font-bold bg-grey-darker">EDAD:</th>
            <th>
                {{ $edad_paciente }}
            </th>
            <th class="font-medium text-white text-sm font-bold bg-grey-darker">CELULAR:</th>
            <th>
                {{ $paciente->celular }}
            </th>
        </tr>
        <tr>
            <th class="font-medium text-white text-sm font-bold bg-grey-darker">DOMICILIO:</th>
            <th colspan="3">
                <div>
                     {{ $paciente->direccion }}
                </div>
            </th>
        </tr>
    </thead>
</table>

<table class="w-100 m-b-15">
    <tr>                            
        <th>
            <div class="px-20 mx-20 text-justify font-light leading-tight text-md h6">
                <span class="font-bold">DIAGNÓSTICO DE REFERENCIA:</span>
                {{ $orden->diagnostico_ref }}<br><br>
                <span class="font-bold">MOTIVO DE CONSULTA:</span>
                {{ $historial->motivo }}<br><br>
                <span class="font-bold">ENFERMEDAD ACTUAL:</span>
                {{ $historial->his_enfermedad }}<br><br>
                @if ($personal->grado_academico == "Dra." || $personal->grado_academico == "Dr.")
                    <span class="font-bold">EXAMEN FÍSICO:</span>
                @else
                    <span class="font-bold">EXAMEN FÍSICO KINESICO:</span> 
                @endif
                {{ $historial->examen_fis_kin }}<br><br>
                @if ($personal->grado_academico == "Dra." || $personal->grado_academico == "Dr.")
                    <span class="font-bold">DIAGNÓSTICO CLÍNICO:</span>
                @else
                    <span class="font-bold">DIAGNÓSTICO KINÉSICO:</span>
                @endif
                {{ $historial->diagnostico_kin }} <br><br>
                <span class="font-bold">TRATAMIENTO:</span>
                <table class="w-100 m-b-15">
                    <tr>
                        <th class="w-25 text-left no-padding no-margins align-middle">
                            
                        </th>
                        <th>
                            <span class="font-light leading-tight text-md h6">
                                {{ $historial->tratamiento }}<br>
                                {{-- • Calor superficial en pierna y tobillo<br>
                                • Tens convencional puntos de dolor<br>
                                • Masaje de relajación en toda la zona<br>
                                • Propiocepcion de tobillo<br>
                                • Fortalecimiento muscular general de miembros inferiores<br> --}}
                            </span>
                        </th>
                        <th class="w-15 text-left no-padding no-margins align-middle">
                            
                        </th>
                    </tr>
                </table>
            </div>
        </th>                            
    </tr>
</table>

<br><br><br><br><br><br>
<div class="text-center font-bold">
    <span class="font-bold">.............................................................</span><br>
    {{ $personal->grado_academico." ".$personal->aPaterno." ".$personal->aMaterno." ".$personal->nombre }}<br>
    {{-- Docente de fisioterapia en gabinete --}}
</div>
<br><br>
@endsection
