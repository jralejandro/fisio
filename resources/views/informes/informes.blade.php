@extends('layouts.app')

@section('title')
    Pacientes
@endsection

@section('subtitulo')
    Pacientes
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6 pull-right">
                    <form action="{{route('informes.inindex')}}" method="GET">
                        <div class="form-row">
                            <div class="col-sm-8 my-1">
                                <input type="text" class="form-control" name="texto" placeholder="Introduzca el C.I. o (ap. pat. mat. nombre)" value="{{$texto}}">
                            </div>
                            <div class="col-auto my-1">
                                <input type="submit" class="btn btn-primary" value="Buscar">
                            </div>
                        </div>
                    </form> 
                </div>
                {{-- <div class="col-sm-2">
                    <label>Número de Pacientes en espera</label> <br><center>{{ $contador }}</center>
                </div> --}}
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
                        <th>Número de sesiones</th>
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
                                {{-- <td>{{ $pac->id_pac }}</td> --}}
                                <td>{{ $pac->ci }}</td>
                                <td>{{ $pac->aPaterno." ".$pac->aMaterno." ".$pac->nombre  }}</td>
                                <td>{{ $pac->celular }}</td>
                                <td>{{ $pac->num_sesiones}}</td>
                                
                                <td class="text-center">
                                    <a href="{{ route('sesiones.sesion', $pac->id_pac) }}"  class="btn btn-success" title="Sesion"><i class="fas fa-clipboard" style="width: 12px"></i></a>
                                    <a href="{{ route('pacientes.show', $pac->id_pac) }}"  class="btn btn-info" title="Ver"><i class="fas fa-user" style="width: 12px"></i></a>
                                    {{-- <a class="btn btn-social-icon bg-green" href="{{ route('estudiantes.show', $estudiante) }}">
                                        <i class="fa fa-file-text"></i>
                                    </a>
                                    <a class="btn btn-social-icon bg-green" href="{{ route('estudiantes.edit', $estudiante) }}">                           
                                        <i class="fa fa-edit"></i>
                                    </a> --}}
                                    
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