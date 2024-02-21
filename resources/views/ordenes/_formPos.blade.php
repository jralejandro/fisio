<input type="hidden" id="id" name="id" value="{{ isset($ordenes) ? $ordenes->id : old('id') }}" class="form-control" placeholder="">
<div class="row">
      
        <div class="col-sm-4">            
            <div class="form-group">
                <label>Turno: </label>
                @if (isset($ordenes))
                    <select id="turno_id" name="turno_id" class="form-control input-sm">
                        @foreach ($turnos as $turno)
                            @if ( $turno->id <> "3")  
                                @if ($ordenes->turno_id == $turno->id)
                                    <option value="{{ $turno->id }}" selected>{{ $turno->turno }}</option> 
                                @else
                                    <option value="{{ $turno->id }}">{{ $turno->turno }}</option> 
                                @endif
                            @endif    
                        @endforeach
                    </select>
                @else
                    <select id="turno_id" name="turno_id" class="form-control input-sm">
                        <option value="">SELECCIONE TURNO</option>
                        @foreach ($turnos as $turno)  
                            @if ( $turno->id <> "3")                  
                                <option value="{{ $turno->id }}">{{ $turno->turno }}</option>
                            @endif                     
                        @endforeach
                    </select>
                    <input type="hidden" id="pac_id" name="pac_id" value="{{$id}}" class="form-control" placeholder=""> 
                @endif
            </div>
            
            <div class="form-group">
                <label>Atendido por: </label>
                @if (isset($ordenes))    
                    <select id="fisio_id" name="fisio_id" class="form-control input-sm">
                        @foreach ($empleados as $emp)
                            @if ($ordenes->empleado_id == $emp->id)
                                <option value="{{ $emp->id }}" selected>{{ $emp->grado_academico.' '. $emp->nombre.' '. $emp->aPaterno.' '. $emp->aMaterno }}</option> 
                            @else
                                <option value="{{ $emp->id }}">{{ $emp->grado_academico.' '. $emp->nombre.' '. $emp->aPaterno.' '. $emp->aMaterno }}</option> 
                                {{-- <option value="{{ $emp->id }}">{{ $turno->turno }}</option>  --}}
                            @endif
                        @endforeach
                    </select>
                @else
                    <select id="fisio_id" name="fisio_id" class="form-control input-sm"></select>
                @endif
            </div> 
            <div class="form-group">
                {{-- <input type="date" name="cumpleanios" value="{{ $fecha }}"> --}}
                <label>Fecha: </label><br>
                <input type="date" id="fecha" name="fecha" value="{{ isset($ordenes) ? $ordenes->fecha : $fecha }}" class="form-control" placeholder=""> 
            </div>
            <div class="form-group">
                
                @if (isset($ordenes))
                    <button id="siguiente" name="siguiente" type="button" onclick="onclickSigEdit()" class="btn btn-file btn-info pull-right float-right" style="margin-right: 5px;"><i class="fa fa-arrow-circle-right"></i>VER HORAS</button>
                @else
                    <button id="siguiente" name="siguiente" type="button" onclick="onclickSig()" class="btn btn-file btn-info pull-right float-right" style="margin-right: 5px;"><i class="fa fa-arrow-circle-right"></i> SIGUIENTE</button>    
                @endif
            </div>
        </div>
   
    <div class="col-sm-2">
        @if(isset($ordenes))
            <br>Hora actual: <br>
            <input type="hidden" id="hora_edit" name="hora_edit" value="{{ $horaeditar->hora }}" class="form-control" placeholder="">
            <input type="hidden" id="hora_id_edit" name="hora_id_edit" value="{{ $horaeditar->hora_id }}" class="form-control" placeholder="">
            <div class="form-group" id="radio"> 
            </div>
            
            {{-- <div class="form-group" id="radio"> 
                @foreach ($horas as $hora)
                
                    @if ($ordenes->hora_id == $hora->id) 
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="{{ $hora->id }}" name="horas" value="{{ $hora->id }}" checked> 
                            <label class="form-check-label">{{ $hora->hora }}</label>  
                        </div>
                    @else
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="{{ $hora->id }}" name="horas" value="{{ $hora->id }}"> 
                            <label class="form-check-label">{{ $hora->hora }}</label> 
                        </div> 
                    @endif
                @endforeach
                
            </div> --}}   
        @endif
        <center> 
            <div class="form-group" id="radio"> 
            </div>
        </center>
    </div>
    <div class="col-sm-6">        
        <div class="form-group">
            <label>Diagnóstico de referencia</label>
            @if (isset($ordenes))
                <textarea rows="6" id="diagnostico_ref" name="diagnostico_ref" class="form-control" placeholder="">{{ $ordenes->diagnostico_ref}}</textarea>
            @else
                <textarea rows="6" id="diagnostico_ref" name="diagnostico_ref" class="form-control" placeholder=""></textarea>
            @endif
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> 
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){ 
        $('#turno_id').on('change', onSelectTurnoChange);
        // $('#siguiente').on('change', onclickSig);
    });
    function onSelectTurnoChange() {
        var turno_id = $(this).val();
        
        $.get('/api/empleado/'+turno_id+'/niveles', function(data){
            // console.log(data); 
            var html_select= '';
            for(var i=0; i<data.length; ++i)
                html_select += '<option value="'+data[i].id+'">'+data[i].grado_academico+' '+data[i].nombre+' '+data[i].aPaterno+' '+data[i].aMaterno+'</option>';
            $('#fisio_id').html(html_select);
        });
    }


    function onclickSig() {
        var turno_id = document.getElementById('turno_id').value;
        var empleado_id = document.getElementById('fisio_id').value;
        var fecha = document.getElementById('fecha').value;
        // let js={
        //     "tu":turno_id,
        //     "em":empleado_id,
        //     "fe":fecha
        // };
        // console.log(js);
        console.log(turno_id+' '+empleado_id+' '+fecha);
        $.get('/api/horas/'+turno_id+'/'+empleado_id+'/'+fecha+'/datos', function(data){ 
            // console.log(data); 
            var html_radio= '';
            console.log(data[0].hora);
            for(var i=0; i<data.length; ++i)
                html_radio += '<div class="form-check"><input class="form-check-input" type="radio" name="horas" value="'+data[i].id+'"> <label class="form-check-label">'+data[i].hora+'</label> </div>';
            $('#radio').html(html_radio);
        });
    }
    function onclickSigEdit() {
        var turno_id = document.getElementById('turno_id').value;
        var empleado_id = document.getElementById('fisio_id').value;
        var fecha = document.getElementById('fecha').value;
        var hora = document.getElementById('hora_edit').value;
        var id_hora = document.getElementById('hora_id_edit').value;
        // let js={
        //     "tu":turno_id,
        //     "em":empleado_id,
        //     "fe":fecha
        // };
        // console.log(js);
        console.log(turno_id+' '+empleado_id+' '+fecha);
        $.get('/api/horas/'+turno_id+'/'+empleado_id+'/'+fecha+'/datos', function(data){ 
            // console.log(data); 
            var html_radio= '';
            console.log(data[0].hora);
            html_radio += '<div class="form-check"><input class="form-check-input" type="radio" name="horas" value="'+id_hora+'" checked> <label class="form-check-label">'+hora+'</label> </div>';
            html_radio += 'Cambiar por';
            for(var i=0; i<data.length; ++i)
                html_radio += '<div class="form-check"><input class="form-check-input" type="radio" name="horas" value="'+data[i].id+'"> <label class="form-check-label">'+data[i].hora+'</label> </div>';
            $('#radio').html(html_radio);
        });
    }


</script>