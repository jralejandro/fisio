
@extends('layouts.app')

@section('title')
    Pacientes
@endsection

@section('subtitulo')
    Pacientes
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="callout callout-warning">
                <center><h5>Cantidad de pacientes, agendados: {{ $hoy }}</h5></center>
            </div>
        </div>
        <div class="col-3">
            <div class="callout callout-info">
                <center><h5>Cantidad de pacientes: {{ $total }}</h5></center>
            </div>
        </div>
        <div class="col-3">
            <div class="callout callout-success">
                <center><h5>Pacientes activos: {{ $activos }}</h5></center>
            </div>
        </div>
        <div class="col-3">
            <div class="callout callout-danger">
                <center><h5>Pacientes dados de alta: {{ $alta }}</h5></center>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6 pull-right">
                    <form action="{{route('pacientes.index')}}" method="GET">
                        <div class="form-row">
                            <div class="col-sm-6 my-1">
                                <input type="text" class="form-control" name="texto" placeholder="Introduzca el C.I. o (ap. pat. mat. nombre)" value="{{$texto}}">
                            </div>
                            <div class="col-auto my-1">
                                <input type="submit" class="btn btn-primary" value="Buscar">
                            </div>
                        </div>
                    </form> 
                </div>
                <div class="col-6">
                    @if (Auth::user()->rol_id==2 OR  Auth::user()->rol_id==1 )
                        <a class="btn btn-social-icon bg-green float-right" href="{{ route('pacientes.create') }}" title="Registrar Paciente">
                            <i class="fa fa-user-plus"></i>
                        </a>
                    @endif
                </div>
            </div>            
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped table-bordered table-hover display" width="100%">
                <thead>                  
                    <tr class="text-center" role="row">
                        {{-- <th>Id</th> --}}
                        <th>C.I.</th>
                        <th>Nombre</th>
                        <th>Celular</th>
                        <th>Fecha Nacimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($pacientes) <= 0)                    
                        <tr>
                            <td colspan="6">No hay Resultados.</td>
                        </tr>
                    @else
                        @foreach($pacientes as $pac)
                            <tr role="row" class="odd">
                                {{-- <td>{{ $i =$i+1 }}</td> --}}
                                {{-- <td>{{ $pac->id }}</td> --}}
                                <td>{{ $pac->ci }}</td>
                                <td>{{ $pac->aPaterno." ".$pac->aMaterno." ".$pac->nombre  }}</td>
                                <td>{{ $pac->celular }}</td>
                                <td>{{ $pac->fechaNacimiento }}</td>
                                
                                <td class="text-center">
                                    @if (Auth::user()->rol_id==2 OR  Auth::user()->rol_id==1 )
                                    <a href="{{ route('ordenes.orden', $pac->id) }}"  class="btn btn-success" title="Crear orden"><i class="fas fa-clipboard" style="width: 12px"></i></a>
                                    @endif
                                    <a href="{{ route('pacientes.show', $pac->id) }}"  class="btn btn-info" title="Ver"><i class="fas fa-user" style="width: 12px"></i></a>
                                    @if (Auth::user()->rol_id==2 OR  Auth::user()->rol_id==1 )
                                    <a href="{{ route('pacientes.edit', $pac->id) }}" class="btn btn-warning" title="Editar"><i class="fas fa-edit" style="width: 12px"></i></a>
                                    @endif
                                    {{-- <a href="{{ route('historiales.historial', $pac->id) }}" class="btn btn-warning" title="Historial"><i class="fas fa-book" style="width: 12px"></i></a> --}}
                                </td>
                            </tr>
                        @endforeach                        
                    @endif
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            {{ $pacientes->links() }}            
        </div>
    </div>
@endsection