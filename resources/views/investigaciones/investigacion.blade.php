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
                    <form action="{{route('investigacion.invesindex')}}" method="GET">
                        <div class="form-row">
                            <div class="col-sm-6 my-1">
                                <input type="text" class="form-control" name="texto" placeholder="Introduzca el diagnostico" value="{{$texto}}">
                            </div>
                            <div class="col-auto my-1">
                                <input type="submit" class="btn btn-primary" value="Buscar">
                            </div>
                        </div>
                    </form> 
                </div>
            </div>            
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped table-bordered table-hover display" width="100%">
                <thead>                  
                    <tr class="text-center" role="row">
                        {{-- <th>Id</th> --}}
                        <th>Diagnostico</th>
                        <th>Nombre</th>
                        <th>Celular</th>
                        <th>Fecha Nacimiento</th>
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
                                <td>{{ $pac->diagnostico_kin }}</td>
                                <td>{{ $pac->aPaterno." ".$pac->aMaterno." ".$pac->nombre  }}</td>
                                <td>{{ $pac->celular }}</td>
                                <td>{{ $pac->fechaNacimiento }}</td>
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