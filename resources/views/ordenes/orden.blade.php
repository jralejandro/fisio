@extends('layouts.app')

@section('title')
    Pacientes
@endsection

@section('subtitulo')
    Orden
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
                        <a class="btn btn-social-icon bg-green float-right" href="{{ route('ordenes.ocreate', $pacientes->id) }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                    <div class="col-1">
                        <a type="button" class=" btn btn-info float-right" href="{{ route('pacientes.index') }}" style="margin-right: 5px;"><i class="fas fa-arrow-circle-left"></i></a>
                    </div>
                </div>            
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-striped table-bordered table-hover display" width="100%">
                    <thead>                  
                        <tr class="text-center" role="row">
                            {{-- <th>Id</th> --}}
                            <th>Fecha</th>
                            <th>Diagnostico referencia</th>
                            <th>Turno</th>
                            <th>Atendido</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($ordenes) <= 0)                    
                        <tr>
                            <td colspan="6">No hay Resultados.</td>
                        </tr>
                        @else
                            @foreach($ordenes as $orden)
                                <tr role="row" class="odd">
                                    {{-- <td>{{ $i =$i+1 }}</td> --}}
                                    {{-- <td>{{ $orden->orde }}</td> --}}
                                    <td>{{ $orden->fecha }}</td>
                                    <td>{{ $orden->diagnostico_ref  }}</td>
                                    <td>
                                        @foreach ($nturnos as $turno)
                                            @if($orden->turno_id == $turno->id)
                                                {{ $turno->turno }}
                                            @endif  
                                        @endforeach
                                    </td>
                                    <td>
                                        {{$orden->grado_academico.' '.$orden->nombre.' '.$orden->aPaterno.' '.$orden->aMaterno}}
                                    </td>
                                    <td>{{ $orden->estado }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('ordenes.oedit', $orden->orde) }}" class="btn btn-warning" title="Editar"><i class="fas fa-edit" style="width: 12px"></i></a>
                                        {{-- ESTO PARA HISTORIAL MOVER <a href="{{ route('reportes.pacientehistorico', $orden->orde) }}" class="btn btn btn-info" title="Imprimir" target="_blank"><i class="fas fa-print" style="width: 12px"></i></a> --}}
                                       
                                        {{-- <a href="{{ route('ordenes.orden', $pac->id) }}"  class="btn btn-success"><i class="fas fa-clipboard" style="width: 12px"></i></a>
                                        <a href="{{ route('pacientes.show', $pac->id) }}"  class="btn btn-info"><i class="fas fa-user" style="width: 12px"></i></a>
                                        --}}
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
                {{ $ordenes->links() }}
            </div>
        </div>
    </div>

@endsection