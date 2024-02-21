@extends('pdf.layoutpdf')

@section('content')
<table class="table-info w-100 m-b-5" border="2">
    <thead>
        <tr>
            <th class="font-medium text-white text-sm font-bold bg-grey-darker">PACIENTE:</th>
            <th>{{ $paciente->aPaterno." ".$paciente->aMaterno." ".$paciente->nombre }}</th>
            <th class="font-medium text-white text-sm font-bold bg-grey-darker">NÚMERO SESIONES:</th>
            <th>{{ $historial->num_sesiones }}</th>
        </tr>
        <tr>
            <th class="font-medium text-white text-sm font-bold bg-grey-darker">MEDICO:</th>
            <th>
                {{ $personal->aPaterno." ".$personal->aMaterno." ".$personal->nombre }}
            </th>
            <th class="font-medium text-white text-sm font-bold bg-grey-darker">FECHA IMPRESIÓN:</th>
            <th>
                {{ $fecha }}
            </th>
        </tr>
        <tr>
            <th class="font-medium text-white text-sm font-bold bg-grey-darker">DIAGNOSTICO:</th>
            <th colspan="3">
                <div>
                    {{ $orden->diagnostico_ref }}
                </div>
            </th>
        </tr>
    </thead>
</table>
<br>
<div class="row">
    <div class="col">
        <div class="box box-default">
            <div class="box-body">
                <div class="box-body table-responsive">
                    <table class="table-info w-100 m-b-5" border="2">
                        <thead class="font-medium text-white text-sm font-bold bg-grey-darker">
                            <tr>
                                <th class="text-center" colspan="4"><h3>CITAS MEDICAS</h3></th>
                            </tr>
                            <tr>
                                <th class="text-center" style="width: 20%">SESIÓN N°</th>
                                <th class="text-center" style="width: 25%">FECHA</th>
                                <th class="text-center" style="width: 30%">HORA</th>                                
                                <th class="text-center" style="width: 25%">MEDICO - FIRMA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sesion as $ses)
                                <tr>
                                    <td class="text-center" style="height: 50px;">{{ $j = $j+1 }}</td>
                                    <td class="text-center">{{ $ses->fecha_ini }}</td>
                                    <td class="text-center">{{ $ses->hora_ini.' - '.$ses->hora_fin }}</td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>    
    </div>
</div>


@endsection