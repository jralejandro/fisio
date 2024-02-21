@extends('layouts.app')

@section('title')
    Usuarios
@endsection

@section('subtitulo')
    Datos
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="invoice p-3 mb-3">
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-user"></i> Datos del empleado <br>
                            {{-- <small class="float-right">Date: 2/10/2014</small> --}}
                        </h4>
                    </div>
                </div>
                <!-- datos usuario obtenidos de la vista index texto plano row -->
                <div class="row invoice-info">
                    @include('usuarios.index')
                </div>
                <div class="row no-print">
                    <div class="col-12"> 
                        @if ( $usuarios->id == Auth::user()->id )
                            <a href="{{ route('usuarios.edit', $empleados->id) }}" class="btn btn-warning float-right" title="Editar"><i class="fas fa-edit" style="width: 12px"></i>  EDITAR DATOS</a>    
                        @else
                            <a type="button" class=" btn btn-info float-right" href="{{ url()->previous() }}" style="margin-right: 5px;"><i class="fas fa-arrow-circle-left"></i> VOLVER</a>
                        @endif       
                        
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

@endsection