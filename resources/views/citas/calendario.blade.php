@extends('layouts.app')

@section('title')
    Pacientes
@endsection

@section('subtitulo')
    HCael
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2">
             <div class="card">
                <div class="card-body">    
                    <div class="form-group">
                        <a type="button" class=" btn btn-info float-right" href="{{ url('/bandejas') }}" style="margin-right: 5px;"><i class="fas fa-arrow-circle-left"></i> VOLVER</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Número de sesiones: </label>
                                <center><h1>{{$historial->num_sesiones}}</h1></center>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Sesiones registradas:</label>
                                <center>
                                    <input type="text" name="contador" id="contador" value="{{$contador}}" class="form-control" disabled>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Turno: </label>
                        <select id="turno_id" name="turno_id" class="form-control input-sm">
                            <option value="">SELECCIONE TURNO</option>
                            @foreach ($turnos as $turno)  
                                @if ( $turno->id <> "3")                  
                                    <option value="{{ $turno->id }}">{{ $turno->turno }}</option>
                                @endif                     
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Atendido por: </label>
                        <select id="fisio_id" name="fisio_id" class="form-control input-sm"></select>
                    </div>
                    <div class="form-group">
                        <button id="siguiente" name="siguiente" type="button" onclick="onclickSig()" class="btn btn-file btn-info pull-right float-right" style="margin-right: 5px;"><i class="fa fa-arrow-circle-right"></i>VER</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="card">
                <div id="ac" class="card-body">
                    <div id="CalendarioWeb">
                    </div>
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
//PARA LOS TURNOS Y LOS EMPLEADOS
    $(document).ready(function () {
        $('#turno_id').on('change', onSelectTurnoChange);
        // $('#siguiente').on('change', onclickSig);
    });
    function onSelectTurnoChange() {
        var turno_id = $(this).val();
        $.get('/api/empleado/' + turno_id + '/todos', function (data) {
            // console.log(data); 
            var html_select = '';
            for (var i = 0; i < data.length; ++i)
                html_select += '<option value="' + data[i].id + '">' + data[i].grado_academico + ' ' + data[i].nombre + ' ' + data[i].aPaterno + ' ' + data[i].aMaterno + '</option>';
            $('#fisio_id').html(html_select);
        });
    }
    var total = {{$historial->num_sesiones}};
    function onclickSig() {
        //let dias = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"];
        var empleado_id = document.getElementById('fisio_id').value;
        var dat = 'http://gabinetefisioterapia.test/api/empleado/' + empleado_id + '/sesiones';
        console.log(dat);
        // alert(dat);
        var fecha = "";
        //busca el div y lo convierte en calendario
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',

            headerToolbar: {
                //hoy, anterior, nuevo ademas se esta agregando el boton creado en general Mi Boton
                left: 'prev,next,today',
                center: 'title',
                //mes, semana, dia, agenda de semana, agenda del dia
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            locale: 'es',
            events: dat,
                
            dateClick: function (info) {
                fecha = info.dateStr;
                //para la fecha saber el dia que es
                var arrayDeCadenas = fecha.split("-");
                var s = arrayDeCadenas[1]+"/"+arrayDeCadenas[2]+"/"+arrayDeCadenas[0];
                var objFecha1 = new Date(s);
                // alert(objFecha1);
                var fec_inicio = document.getElementById("fechaInicio");
                fec_inicio.value = fecha;
                //fecha de fin que se sume
                var i = 1;
                if(objFecha1.getDay()== 0){
                    alert("No se puede registrar en domingo");
                }else{
                    if(objFecha1.getDay()== 6){
                        alert("No se puede registrar en sabado");
                    }else{
                        while(i<total){
                            if(objFecha1.getDay()== 0){
                                objFecha1.setDate(objFecha1.getDate() + 1);
                            }else{
                                if(objFecha1.getDay()== 6){
                                    objFecha1.setDate(objFecha1.getDate() + 1);
                                }else{
                                    i=i+1;
                                    objFecha1.setDate(objFecha1.getDate() + 1);  
                                }
                            }   
                        }
                        if(objFecha1.getDay()== 6){
                            objFecha1.setDate(objFecha1.getDate() + 2);  
                        }   
                        if(objFecha1.getDay()== 0){
                            objFecha1.setDate(objFecha1.getDate() + 1);  
                        }    
                        var a = objFecha1.getFullYear();
                        var m = objFecha1.getMonth() + 1;
                        var d = objFecha1.getDate();
                        if(d<10)
                            d='0'+d; //agrega cero si el menor de 10
                        if(m<10)
                            m='0'+m //agrega cero si el menor de 10
                        document.getElementById("fechaFin").value = a+"-"+m+"-"+d;
                        $("#sesionModal").modal("show");

                    }
                }
                
                //alert(dias[objFecha1.getDay()-1]+ " "+ objFecha1+" "+arrayDeCadenas[2])
                var fecha = document.getElementById("fechaInicio").value;
                var turno_id = document.getElementById('turno_id').value;
                var empleado_id = document.getElementById('fisio_id').value;
                document.getElementById("turno").value = turno_id;  //para poner valor al input
                
                console.log(turno_id + ' ' + empleado_id + ' ' + fecha);
                $.get('/api/horas/' + turno_id + '/' + empleado_id + '/' + fecha + '/datos', function (data) {
                    console.log(data); 
                    var html_hora= '';

                    console.log(data[0].hora);
                    for (var i = 0; i < data.length; ++i)
                        html_hora += '<option value="'+data[i].id+'">'+data[i].hora+'</option>';
                    $('#hora_id').html(html_hora);
                });
            }
        });
        calendar.render();
    } 
    
    function onclickGuardar() {
        var total = {{$historial->num_sesiones}};
        var fecha_inicio = document.getElementById("fechaInicio").value;
        var fecha_fin = document.getElementById("fechaFin").value;
//armado de la fecha inicio
        var arrayDeCadenas = fecha_inicio.split("-");
        var s = arrayDeCadenas[1]+"/"+arrayDeCadenas[2]+"/"+arrayDeCadenas[0];
        var objFecha1 = new Date(s);
        
//fecha fin
        var arrayDeCadenas = fecha_fin.split("-");
        var s1 = arrayDeCadenas[1]+"/"+arrayDeCadenas[2]+"/"+arrayDeCadenas[0];
        var objFecha2 = new Date(s1);
        var dif = objFecha2 - objFecha1;
        var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
 console.log(dias);

        var turno_id = document.getElementById('turno_id').value;
        var empleado_id = document.getElementById('fisio_id').value;
        var hora_id =document.getElementById('hora_id').value;
        var historial_id =document.getElementById('historial_id').value;
        var paciente_id =document.getElementById('paciente_id').value;
        var contador =document.getElementById('contador').value;
       
        if(contador < total){
            $.get('/api/horas/' + empleado_id + '/' + fecha_inicio + '/' + hora_id + '/' + dias +'/hordenes', function (data) {
            if(data[0].hay == 0){
                for(i=0; i<=dias; i=i+1){
                    console.log(objFecha1.getDay()+'dia');
                    if(objFecha1.getDay() == 0 || objFecha1.getDay()== 6){        
                        objFecha1.setDate(objFecha1.getDate() + 1); 
                    }else{
                        var a = objFecha1.getFullYear();
                        var m = objFecha1.getMonth() + 1;
                        var d = objFecha1.getDate();
                        if(d<10)
                            d='0'+d; //agrega cero si el menor de 10
                        if(m<10)
                            m='0'+m //agrega cero si el menor de 10
                        fecha = a+"-"+m+"-"+d;
                        
                        var sesiones = {
                            fecha_ini: fecha,
                            fecha_fin: fecha,
                            hora_id: hora_id,
                            turno_id: turno_id,
                            estado: "Pendiente",
                            historial_id: historial_id,
                            empleado_id: empleado_id,
                            paciente_id: paciente_id,
                        }; 
                        
                        axios({
                            method: 'post',
                            url: 'http://gabinetefisioterapia.test/citas/cstore',
                            data: sesiones 
                        }).then(result => {
                            console.log(result.data);
                            document.getElementById('contador').value=result.data;
                            $("#sesionModal").modal("hide");
                            onclickSig();
                            console.log(contador+ ' '+ total); 
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    console.log(i+'-----'); 
                    console.log(sesiones);

                    objFecha1.setDate(objFecha1.getDate() + 1);
                    }
                }

            }else{
                $("#sesionModal").modal("hide");
                alert("Hora no disponible");
            }
            });

        }else{
            alert("Ya no puede realizar mas registros");
            $("#sesionModal").modal("hide");

        }

        

        // for(i=0; i<=dias; i=i+1){
        //     console.log(objFecha1.getDay()+'dia');
        //     if(objFecha1.getDay() == 0 || objFecha1.getDay()== 6){        
        //         objFecha1.setDate(objFecha1.getDate() + 1); 
        //     }else{
        //         var a = objFecha1.getFullYear();
        //         var m = objFecha1.getMonth() + 1;
        //         var d = objFecha1.getDate();
        //         if(d<10)
        //             d='0'+d; //agrega cero si el menor de 10
        //         if(m<10)
        //             m='0'+m //agrega cero si el menor de 10
        //         fecha = a+"-"+m+"-"+d;
                
        //         var sesiones = {
        //             fecha_ini: fecha,
        //             fecha_fin: fecha,
        //             hora_id: hora_id,
        //             turno_id: turno_id,
        //             estado: "Pendiente",
        //             historial_id: historial_id,
        //             empleado_id: empleado_id,
        //             paciente_id: paciente_id,
        //         }; 
                // axios({
            //     method: 'post',
            //     url: 'http://gabinetefisioterapia.test/citas/cstore',
            //     data: sesiones 
            // }).then(result => {
            //     console.log(result.data);
            //     document.getElementById('contador').value=result.data;
            //     $("#sesionModal").modal("hide");
            //     onclickSig();
            //     console.log(contador+ ' '+ total); 
            // })
        //         console.log(i+'-----'); 
        //         console.log(sesiones);
                
                  
        //         objFecha1.setDate(objFecha1.getDate() + 1);
        //     }
        // }






        // if(contador < total){        
        //     console.log(turno_id + ' ' + empleado_id + ' ' + fecha_inicio);
        //     var sesiones = {
        //         fecha_ini: fecha,
        //         fecha_fin: fecha,
        //         hora_id: hora_id,
        //         turno_id: turno_id,
        //         estado: "Pendiente",
        //         historial_id: historial_id,
        //         empleado_id: empleado_id,
        //         paciente_id: paciente_id,
        //     };
        //     axios({
        //         method: 'post',
        //         url: 'http://gabinetefisioterapia.test/citas/cstore',
        //         data: sesiones 
        //     }).then(result => {
        //         console.log(result.data);
        //         document.getElementById('contador').value=result.data;
        //         $("#sesionModal").modal("hide");
        //         onclickSig();
        //         console.log(contador+ ' '+ total); 
        //     })
        //     .catch(function (error) {
        //         console.log(error);
        //     });
        // }else{
        //     alert("Ya no puede realizar mas registros");
        //     $("#sesionModal").modal("hide");
        // }
        // console.log(sesiones);               
    } 
</script>
{{-- <form action="{{route('citas.cstore')}}" method="POST"> --}}
    <form>
    @csrf
    <div class="modal fade" id="sesionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="tituloEvento">{{$paciente->nombre}} {{$paciente->aPaterno}} {{$paciente->aMaterno}}</h4> <!-- id jala la infromacion del title -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="turno" id="turno" class="form-control">
                <input type="hidden" name="historial_id" id="historial_id" value="{{$historial->id}}" class="form-control">          
                <input type="hidden" name="orden_id" id="orden_id" value="{{$orden_id}}" class="form-control">
                <input type="hidden" name="paciente_id" id="paciente_id" value="{{$paciente->id}}" class="form-control">
                <div class="modal-body">
                        <!-- mostrar el contenido de desripcion id-->
                    <div id="descripcionEvento">&times;</div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>FECHA INICIO:</label>
                            <input type="date" name="fechaInicio" id="fechaInicio" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>FECHA FIN:</label>
                            <input type="date" name="fechaFin" id="fechaFin" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>HORA:</label>
                            <select id="hora_id" name="hora_id" class="form-control input-sm"></select>
                        </div>            
                    </div>   
                </div>
                <div class="modal-footer">
                    {{-- <button type="submit" class="btn btn-success" id="btnguardar">Guardar</button> --}}
                    <button type="button" class="btn btn-success" id="btn" onclick="onclickGuardar()" >Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>      
                </div>
            </div>    
        </div>
    </div>
</form>
@endsection