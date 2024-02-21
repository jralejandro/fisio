@extends('layouts.app')

@section('title')
    Pacientes
@endsection

@section('subtitulo')
    Sesiones
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="invoice p-3 mb-3">
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-user"></i> Datos del paciente <br>
                                {{-- <small class="float-right">Date: 2/10/2014</small> --}}
                            </h4>
                        </div>
                    </div>
                    <!-- datos usuario obtenidos de la vista index texto plano row -->
                    <div class="row invoice-info">
                        @include('pacientes.index')
                    </div>
                    <div class="row no-print">
                        <div class="col-12">              
                            {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                                Payment
                            </button> --}}
                            {{-- <a type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fas fa-pr"></i> Generate PDF
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-11">
                        <a class="btn btn-social-icon bg-green float-right" href="{{ route('informes.icreate', $pacientes->id) }}" title="Añadir informe">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>            
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-striped table-bordered table-hover display" width="100%">
                    <thead>                  
                        <tr class="text-center" role="row">
                            <th>Id</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($sesiones) <= 0)                    
                        <tr>
                            <td colspan="6">No hay Resultados.</td>
                        </tr>
                        @else
                            @foreach($sesiones as $sesion)
                                <tr role="row" class="odd">
                                    {{-- <td>{{ $i =$i+1 }}</td> --}}
                                    <td>{{ $sesion->id }}</td>
                                    <td>{{ $sesion->fecha_ini }}</td>
                                    <td>{{ $sesion->hora }}</td>
                                    <td>{{ $sesion->estado }}</td>
                                    
                                    <td class="text-center">
                                        @if ($sesion->fecha_ini == $fechaactual)
                                            {{-- <a onclick="return false;" href="{{ route('sesiones.screate', $sesion->id) }}" class="btn btn-success"><i class="fas fa-edit" style="width: 12px"></i></a> --}}
                                            @if ($sesion->estado == "Pendiente")
                                                <a href="{{ route('sesiones.screate', $sesion->id) }}" class="btn btn-warning"><i class="fas fa-edit" style="width: 12px"></i></a>
                                                {{-- <a href="{{ route('sesiones.noasistio', $sesion->id) }}" class="btn btn-danger" title="No asistio"><i class="fas fa-user-times" style="width: 12px"></i></a> --}}
                                            @endif
                                            @if ($sesion->estado == "Asistio")
                                                    <a href="{{ route('sesiones.noasistio', $sesion->id) }}" class="btn btn-success" title="Asistio"><i class="fas fa-user-times" style="width: 12px"></i></a>    
                                            @else
                                                    <a href="{{ route('sesiones.noasistio', $sesion->id) }}" class="btn btn-danger" title="No Asistio"><i class="fas fa-user-times" style="width: 12px"></i></a>
                                            @endif
                                        @endif
                                        <a href="{{ route('sesiones.sshow', $sesion->id) }}"  class="btn btn-info" title="Ver"><i class="fas fa-user" style="width: 12px"></i></a>
                                    </td>
                                </tr>
                            @endforeach                        
                        @endif                 
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $sesiones->links() }}
            </div>
        </div>
    </div>

@endsection