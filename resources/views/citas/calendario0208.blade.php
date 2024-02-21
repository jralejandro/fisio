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
                        <label>Turno: </label>
                        <select id="turno_id" name="turno_id" class="form-control input-sm">
                            <option value="">TURNO</option>
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
                    {{-- <div class="form-group">
                        <button id="siguiente" class="btn btn-file btn-info pull-right float-right" style="margin-right: 5px;"><i class="fa fa-arrow-circle-right"></i>dos</button>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="card">
                <div id="ac" class="card-body">
                  
                    <div id="CalendarioWeb">
                    </div>
               
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
//PARA LOS TURNOS Y LOS EMPLEADOS
    $(document).ready(function(){ 
        $('#turno_id').on('change', onSelectTurnoChange);
        // $('#siguiente').on('change', onclickSig);
    });
    function onSelectTurnoChange() {
        var turno_id = $(this).val();
        $.get('/api/empleado/'+turno_id+'/todos', function(data){
            // console.log(data); 
            var html_select= '';
            for(var i=0; i<data.length; ++i)
                html_select += '<option value="'+data[i].id+'">'+data[i].grado_academico+' '+data[i].nombre+' '+data[i].aPaterno+' '+data[i].aMaterno+'</option>';
            $('#fisio_id').html(html_select);
        });
    }
 

    function onclickSig() {
        console.log('entra');
        var turno_id = document.getElementById('turno_id').value;
        var empleado_id = document.getElementById('fisio_id').value;
        // let js={
        //     "tu":turno_id,
        //     "em":empleado_id,
        //     "fe":fecha
        // };
        // console.log(js);
//         console.log(turno_id+' '+empleado_id+'aaaaaaaaaaaaaaaaaaaaaaaaa');
  
//         $.get('/api/empleado/'+empleado_id+'/sesiones', function(data){
//             console.log(data); 
//             // var html_select= '';
//             var events  = [];
// var objeto = {};
//             for(var i=0; i<data.length; ++i){
                
//                 events.push({ 
//                     "id" : data[i].idse,
//                     "title" : data[i].estado,
//                     "descipcion" : data[i].hora,
//                     "start" : data[i].fecha_ini,
//                 });
//                 //obj['datos'].push({"id":data[i].idse,"title":data[i].estado,"descripcion":data[i].hora,"start":data[i].fecha_ini});
//             //     html_select += '<option value="'+data[i].id+'">'+data[i].grado_academico+' '+data[i].nombre+' '+data[i].aPaterno+' '+data[i].aMaterno+'</option>';
//             }
//             objeto.events = events;
//             console.log(JSON.stringify(objeto));
//             // json= JSON.stringify(obj);
//             // console.log(json);
//         });
        var a;
        $.get('/api/empleado/'+empleado_id+'/sesiones', function(data){
            a=data;
            console.log(a+'esto'); 
        });
console.log(empleado_id);
        $('#CalendarioWeb').fullCalendar({
           
        //la parte de arriba
        header:{
            //hoy, anterior, nuevo ademas se esta agregando el boton creado en general Mi Boton
            left:'today,prev,next,Miboton',
            center:'title',
            //mes, semana, dia, agenda de semana, agenda del dia
            right: 'month,basicWeek,basicDay,agendaWeek,agendaDay'
        },
        //para agregar botones arriba en el header
        customButtons:{
            //nombre del boton
            Miboton:{
                //nombre del boton
                text:"Boton 1",
                //lo que va aparecer al dar clik
                click:function(){
                    alert("Accion del Boton");
                }

            }
        },
        //al dar clik en un dia va devovler fecha, evento y una vista
        dayClick:function(date,jsEvent,view){
            //muestra el dia
            alert("Valor seleccionar:"+date.format());
            //nombre de la vista
            alert("vista actual"+view.name);
            //aplicar color al elemento que se da click
            $(this).css('background-color','red');
            //para abrir el modal
            $("#exampleModal").modal();
        },

        // events:a,
        events:'http://gabinetefisioterapia.test/api/empleado/'+empleado_id+'/sesiones',
        // eventSources:[{
        //         //para los datos
        //         events:[
        //             //para un solo dia
        //             {
        //                 id:1, 
        //                 title:'Luis Mamani',
        //                 //descripcion de evento
        //                 descripcion:"10:30 a 11:00",
        //                 start:'2021-07-03',
        //                 end:'2021-07-10',
        //                 //para poner color al seleccionado
        //                 color: "#FFF000",
        //                 textColor:" #000000"
        //             },
        //             //para varios dias
        //             {
        //                 title:'Juana Perez',
        //                 descripcion:"para la prueba2",
        //                 start:'2021-07-03',
        //                 end: '2021-06-10',
        //             },
        //             //oara ocupar todo el dia
        //             {
        //                 title:'Luis Mamani',
        //                 start:'2021-07-08',
        //                 descripcion:"para la prueba3",
        //                 allDay:false,
        //                 color: "#FFF000",
        //                 textColor:" #000000"
        //             }
        //         ],
        //         //oara poner color a todos los sintillos
        //         color: "black",
        //         textColor:" yellow"
        //     }],
  
                
        //     ],
        // eventSources:[{
        //     //para los datos
            
        //     //oara poner color a todos los sintillos
        //     color: "black",
        //     textColor:" yellow"
        // }],
        //para pasar datos al modal al momento de dar click
        //funcion parametros del calendario que tiene en cada evento,evento, vista
        eventClick:function(calEvent,jsEvent,view){
            $('#tituloEvento').html(calEvent.title);
            $('#descripcionEvento').html(calEvent.descripcion);
            $("#exampleModal").modal();
        }

        eventSource.refetch();
        
    });

    console.log('calen');
    }
// document.getElementById('siguiente').onclick = function(){
//     //location.reload();
//     onclickSig();
//     console.log("ggggg");
// }
</script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="tituloEvento"></h4> <!-- id jala la infromacion del title -->
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <input type="text" name="id_sesion" id="id_sesion" class="form-control">
    <div class="modal-body">
        <!-- mostrar el contenido de desripcion id-->
        <div id="descripcionEvento">&times;</div>

        <div class="form-row">
  
            <div class="form-group col-md-6">
                <label>FECHA INICIO:</label>
                <input type="date" name="fechaNacimiento" id="fechaNacimiento" class="form-control input-sm">
            </div>
            <div class="form-group col-md-6">
                <label>FECHA FIN:</label>
                <input type="date" name="fechaNacimiento" id="fechaNacimiento" class="form-control input-sm">
            </div>


        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>HORA INICIO:</label>
                <input type="time" name="fechaNacimiento" id="fechaNacimiento" class="form-control input-sm">
            </div>
            <div class="form-group col-md-6">
                <label>HORA FIN:</label>
                <input type="time" name="fechaNacimiento" id="fechaNacimiento" class="form-control input-sm">
            </div>
            
        </div>
      
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="agregar">Agregar</button>
        <button type="submit" class="btn btn-success">Modificar</button>
        <button type="submit" class="btn btn-danger">Borrar</button>
        <button type="submit" class="btn btn-def" data-dismiss="modal">Cancelar</button> 
    </div>
  </div>
</div>
</div>
@endsection