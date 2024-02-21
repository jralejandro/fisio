@extends('pdf.layoutpdf')

@section('content')
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
<br>
<div class="row">
    <div class="col">
        <div class="box box-default">
            <div class="box-body">
                <div class="box-body table-responsive">
                    <table class="table-info w-100 m-b-5" border="2">
                        <thead class="font-medium text-white text-sm font-bold bg-grey-darker">
                            <tr>
                                <th class="text-center" colspan="5"><h3>CITAS MEDICAS</h3></th>
                            </tr>
                            <tr>
                                <th class="text-center" style="width: 10%">SESIÓN N°</th>
                                <th class="text-center" style="width: 15%">FECHA</th>
                                <th class="text-center" style="width: 10%">HORA</th> 
                                <th class="text-center" style="width: 35%">NOMBRE</th>                                
                                <th class="text-center" style="width: 30%">FIRMA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sesion as $ses)
                                <tr>
                                    <td class="text-center" style="height: 50px;">{{ $j = $j+1 }}</td>
                                    <td class="text-center">{{ $ses->fecha_ini }}</td>
                                    <td class="text-center">{{ $ses->hora }}</td>
                                    <td class="text-center">{{ $ses->grado_academico.' '.$ses->nombre.' '.$ses->aPaterno.' '.$ses->aMaterno }}</td>
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