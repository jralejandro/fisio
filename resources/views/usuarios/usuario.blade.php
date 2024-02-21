@extends('layouts.app')

@section('title')
    Usuarios
@endsection

@section('subtitulo')
    Usuarios
@endsection

@section('content')
    <div class="row">
        <div class="col-4">
            <div class="callout callout-info">
                <center><h5>Total del personal: {{ $total }}</h5></center>
            </div>
        </div>
        <div class="col-4">
            <div class="callout callout-success">
                <center><h5>Personal activo: {{ $activo }}</h5></center>
            </div>
        </div>
        <div class="col-4">
            <div class="callout callout-danger">
                <center><h5>Personal inactivo: {{ $inactivo }}</h5></center>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            
            <div class="row">
                <div class="col-6 pull-right">
                    <form action="{{route('usuarios.index')}}" method="GET">
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
                <div class="col-6">
                    <a class="btn btn-social-icon bg-green float-right" href="{{ route('usuarios.create') }}">
                        <i class="fa fa-user-plus"></i>
                    </a>
                </div>
            </div>            
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped table-bordered table-hover display" width="100%">
                <thead>                  
                    <tr class="text-center" role="row">
                        <th>C.I.</th>
                        <th>Nombre</th>
                        <th>Celular</th>
                        <th>Fecha Nacimiento</th>
                        <th>Acciones</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($empleados) <= 0)                    
                        <tr>
                            <td colspan="6">No hay Resultados.</td>
                        </tr>
                    @else
                        @foreach($empleados as $emp)
                            <tr role="row" class="odd">
                                {{-- <td>{{ $i =$i+1 }}</td> --}}
                                <td>{{ $emp->ci }}</td>
                                <td>{{ $emp->aPaterno." ".$emp->aMaterno." ".$emp->nombre  }}</td>
                                <td>{{ $emp->celular }}</td>
                                <td>{{ $emp->fechaNacimiento }}</td>
                                <td>{{ $emp->estado }} </td>
                                <td class="text-center">
                                    <a href="{{ route('usuarios.show', $emp->id) }}"  class="btn btn-info" title="Ver Datos"><i class="fas fa-user" style="width: 12px"></i></a>
                                    <a href="{{ route('usuarios.edit', $emp->id) }}" class="btn btn-warning" title="Editar"><i class="fas fa-edit" style="width: 12px"></i></a>    
                                    @if ($emp->estado == "ACTIVO")
                                        <a href="{{ route('usuarios.inactivo', $emp->id) }}" class="btn btn-success" title="Inhabilitar"><i class="fas fa-user-times" style="width: 12px"></i></a>    
                                    @else
                                        <a href="{{ route('usuarios.inactivo', $emp->id) }}" class="btn btn-danger" title="Habilitar"><i class="fas fa-user" style="width: 12px"></i></a>
                                    @endif
                                
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
            {{ $empleados->links() }}          
        </div>
    </div>
@endsection