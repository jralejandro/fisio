@extends('layouts.app')

@section('title')
   Pacientes
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
                            <i class="fas fa-user"></i> Datos del tratamiento en cada sesión <br>
                        </h4>
                    </div>
                </div>
                <!-- datos usuario obtenidos de la vista index texto plano row -->
                <div class="row invoice-info">
                    {{-- @include('pacientes.index') --}}

                    <div class="col-sm-6 invoice-col">
                        <strong>OBSERVACIÓN:</strong> 
                            {{ $sesiones->observacion }}<br>
                        @foreach ($tratamientos as $tratamiento)
                            @foreach ($sesionestra as $sestra)
                            {{-- {{$tratamiento->id.'='.$sestra->tratamiento_id}} --}}
                                @if($tratamiento->id == $sestra->tratamiento_id)
                                    <strong>{{ $tratamiento->tratamiento}}:</strong>    
                                    {{ $sestra->detalle}}<br>
                                @endif
                            @endforeach                       
                        @endforeach
                    </div>
                </div>
                <div class="row no-print">
                    <div class="col-12" > 
                        <a type="button" class=" btn btn-info float-right" href="{{ url()->previous() }}" style="margin-right: 5px;"><i class="fas fa-arrow-circle-left"></i> VOLVER</a>
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