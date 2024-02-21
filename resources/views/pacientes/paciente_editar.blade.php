@extends('layouts.app')

@section('title')
    Pacientes
@endsection

@section('subtitulo')
    Editar
@endsection

@section('content')

    @include('pacientes.editar')
    
@endsection

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> 
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script type="text/javascript">
$(document).ready(function(){ 
   $('#alternar-respuesta-ej1').on('click',function(){
      $('#respuesta-ej1').toggle();
   });
});
</script>