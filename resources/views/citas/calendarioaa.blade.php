<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

 <!-- Calendario -->
  <script src="{!! asset('/calendario/js/jquery.min.js') !!}"></script>
  <script src="{!! asset('/calendario/js/moment.min.js') !!}"></script>
 
  <link rel="stylesheet" href="{!! asset('/calendario/css/fullcalendar.min.css') !!}">
  <script src="{!! asset('/calendario/js/fullcalendar.min.js') !!}"></script>
  <script src="{!! asset('/calendario/js/es.js') !!}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>    


    
    <title>Calendario </title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="invoice p-3 mb-3">
                    <div class="row">
                        <div class="col-12" id="CalendarioWeb">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        
    
    

<script>
    $(document).ready(function(){
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
            eventSources:[{
                //para los datos
                events:[
                    //para un solo dia
                    {
                        title:'Luis Mamani',
                        //descripcion de evento
                        descripcion:"para la prueba1",
                        start:'2021-06-03',
                        //para poner color al seleccionado
                        color: "#FFF000",
                        textColor:" #000000"
                    },
                    //para varios dias
                    {
                        title:'Juana Perez',
                        descripcion:"para la prueba2",
                        start:'2021-06-03',
                        end: '2021-06-10',
                    },
                    //oara ocupar todo el dia
                    {
                        title:'Luis Mamani',
                        start:'2021-06-08',
                        descripcion:"para la prueba3",
                        allDay:false,
                        color: "#FFF000",
                        textColor:" #000000"
                    }
                ],
                //oara poner color a todos los sintillos
                color: "black",
                textColor:" yellow"
            }],
            //para pasar datos al modal al momento de dar click
            //funcion parametros del calendario que tiene en cada evento,evento, vista
            eventClick:function(calEvent,jsEvent,view){
                $('#tituloEvento').html(calEvent.title);
                $('#descripcionEvento').html(calEvent.descripcion);
                $("#exampleModal").modal();
            }
            
        });
    });
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
          <div class="form-row">
              <div class="form-group col-md-6">
                  <label>GENERO</label>
                  <select id="genero" name="genero" class="form-control">
                      <option selected>F</option>
                      <option>M</option>
                  </select>
              </div>
              <div class="form-group col-md-6">
                  <label>FECHA NACIMIENTO</label>
                  <input type="date" name="fechaNacimiento" id="fechaNacimiento" class="form-control input-sm">
              </div>
          </div>
          <label>DOMICILIO</label>
          <input type="text" name="domicilio" id="domicilio" class="form-control input-sm">
          <div class="form-row">
              <div class="form-group col-md-6">
                  <label>TELEFONO</label>
                  <input type="text" name="telefono" id="telefono" class="form-control input-sm">
              </div>
              <div class="form-group col-md-6">
                  <label>CELULAR</label>
                  <input type="text" name="celular" id="celular" class="form-control input-sm">
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

</body>
</html>