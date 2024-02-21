@extends('layouts.app')

@section('title')
    Pacientes
@endsection

@section('subtitulo')
    Historia Clinica
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
                        <a class="btn btn-social-icon bg-green float-right" href="{{ route('historiales.hcreate', $pacientes->id) }}" title="Añadir historial">
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
                            <th>Motivo</th>
                            <th>Tratamiento</th>
                            <th>Atendido por</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($historiales) <= 0)                    
                        <tr>
                            <td colspan="6">No hay Resultados.</td>
                        </tr>
                        @else
                            @foreach($historiales as $historial)
                                <tr role="row" class="odd">
                                    {{-- <td>{{ $i =$i+1 }}</td> --}}
                                    <td>{{ $historial->id }}</td>
                                    <td>{{ $historial->fechaIngreso }}</td>
                                    <td>{{ $historial->motivo }}</td>
                                    <td>{{ $historial->tratamiento }}</td>
                                    <td>{{ $historial->nombre.' '.$historial->aPaterno.' '.$historial->aMaterno }}</td>
                                    
                                    <td class="text-center">

                                        <a href="{{ route('reportes.pdfCitas', $historial->id) }}" class="btn btn btn-info" title="Citas" target="_blank"><i class="fas fa-print" style="width: 12px"></i></a>
                                        <a href="{{ route('reportes.pacientehistorico', $historial->id) }}" class="btn btn btn-warning" title="Historial" target="_blank"><i class="fas fa-print" style="width: 12px"></i></a>
                                        <a href="{{ route('sesiones.sesion', $pacientes->id) }}" class="btn btn-success" title="Sesion"><i class="fas fa-clipboard" style="width: 12px"></i></a>
                                        <a href="{{ route('informes.inshow', $historial->id) }}" class="btn btn-info" title="Informes"><i class="fas fa-clipboard" style="width: 12px"></i></a>
                                        
                                    </td>
                                </tr>
                            @endforeach                        
                        @endif                 
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $historiales->links() }}
            </div>
        </div>
    </div>

@endsection