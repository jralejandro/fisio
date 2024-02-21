@extends('pdf.layoutpdf')

@section('content')
<div class="text-center">
    <h2>{{ $titulo }}</h2>
</div>

<div class="row">
    <div class="col">
        <div class="box box-default">
            <div class="box-body">
                <div class="box-body table-responsive">
                    <table class="table-info w-100 m-b-5" border="2">
                        <thead class="font-medium text-white text-sm font-bold bg-grey-darker">
                            <tr>
                                <th class="text-center" rowspan="2">N°</th>
                                <th class="text-center" rowspan="2">C.I.</th>
                                <th class="text-center" rowspan="2">Nombre Completo</th>                                
                                <th class="text-center" rowspan="2">Celular</th>
                                <th class="text-center" rowspan="2">Telefono</th>
                                <th class="text-center" rowspan="2">Cargo</th>
                                <th class="text-center" rowspan="2">Turno</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empleados as $emp)
                                <tr>
                                    <td>{{ $j = $j+1 }}</td>
                                    <td>{{ $emp->ci }}</td>
                                    <td>{{ $emp->aPaterno.' '.$emp->aMaterno.' '.$emp->nombre }}</td>                                    
                                    <td>
                                        @if ($emp->celular == "")
                                            <div class="text-center">
                                                -
                                            </div>
                                        @else
                                        {{ $emp->celular }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($emp->celular == "")
                                            <div class="text-center">
                                                -
                                            </div>
                                        @else
                                        {{ $emp->telefono }}
                                        @endif                                        
                                    </td>
                                    <td>
                                        @foreach ($roles as $rol)
                                            @if ($rol->id == $emp->rol_id)
                                            {{ $rol->rol }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($turnos as $tur)
                                            @if ($tur->id == $emp->turno_id)
                                            {{ $tur->turno }}
                                            @endif
                                        @endforeach                                        
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
