<?php

namespace App\Http\Controllers;
use App\Models\Empleado;
use App\Models\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\For_;
use Illuminate\Support\Arr;
use Monolog\Formatter\NormalizerFormatter;

class EmpleadoController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    //
    public function byEmpleado($id)
    {
        return DB::table('empleados')
                            ->select('empleados.id','empleados.nombre', 'empleados.aPaterno', 'empleados.aMaterno', 'empleados.grado_academico' ,'users.id AS id_users', 'users.rol_id')
                            ->join('users', 'empleados.user_id', '=', 'users.id')
                            ->where('users.estado', '=', 'ACTIVO')
                            ->where('empleados.turno_id', '=', $id)
                            ->where('users.rol_id', '<>', 1)
                            ->get();
     
    }
    public function byHoras($turno, $fisio, $fecha)
    {
        $ordenes=DB::table('ordenes')
                ->select('ordenes.hora_id')
                ->join('empleados', 'empleados.id', '=', 'ordenes.empleado_id')
                ->where('ordenes.fecha', '=', $fecha)
                ->where('empleados.id', '=', $fisio)
                ->get();
        
        $sesiones=DB::table('sesiones')
                ->select('sesiones.hora_id')
                ->join('empleados', 'empleados.id', '=', 'sesiones.empleado_id')
                ->where('sesiones.fecha_ini', '=', $fecha)
                ->where('empleados.id', '=', $fisio)
                ->get();
        //sin el id de emple.ado
        // $sesiones=DB::table('sesiones')
        //         ->select('sesiones.hora_id')
        //         ->join('historiales', 'historiales.id', '=', 'sesiones.historial_id')
        //         ->join('ordenes', 'ordenes.id', '=', 'historiales.orden_id')
        //         ->join('empleados', 'empleados.id', '=', 'ordenes.empleado_id')
        //         ->where('sesiones.fecha_ini', '=', $fecha)
        //         ->where('empleados.id', '=', $fisio)
        //         ->get();
                
        $rol=DB::table('empleados')
                ->select('users.rol_id')
                ->join('users', 'empleados.user_id', '=', 'users.id')
                ->where('empleados.id', '=', $fisio)
                ->first();
        $hora_id=[];
        foreach($ordenes as $orden){
            $hora_id[] = array("hora_id" => $orden->hora_id); 
        }
        
        foreach($sesiones as $sesion){
            $hora_id[] = array("hora_id" => $sesion->hora_id); 
        }
        $horas=DB::table('horas')->where('horas.turno_id', '=', $turno)->where('horas.rol_id', '=', $rol->rol_id)->get();
        
        
        if(count($hora_id) == 0){
            foreach($horas as $hora){
                $resources[] = array("id" => $hora->id ,"hora" => $hora->hora);    
            }
        }else{
            $ids_horas = Arr::flatten($hora_id);
            foreach($horas as $hora){
                $cont=0;
                for ($i=0; $i<count($ids_horas); $i++) { 
                    if($hora->id == $ids_horas[$i]){
                        $cont=$cont+1;
                    }
                }   
                if($cont == 0){
                    $resources[] = array("id" => $hora->id ,"hora" => $hora->hora);
                }
            }
        }       
//  return $horas;
        
        return $resources;
        // return [
        //     foreach ($horas as $hora) {
                
        //     }
        //     'id' => $this->id,
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        // ];
    }

    public function todosEmpleado($id)
    {
        return DB::table('empleados')
                            ->select('empleados.id','empleados.nombre', 'empleados.aPaterno', 'empleados.aMaterno', 'empleados.grado_academico' ,'users.id AS id_users', 'users.rol_id')
                            ->join('users', 'empleados.user_id', '=', 'users.id')
                            ->where('users.estado', '=', 'ACTIVO')
                            ->where('empleados.turno_id', '=', $id)
                            ->where('users.rol_id', '<>', 1)
                            ->Where('users.rol_id', '<>', 3)  
                            ->get();     
    }

    public function sesionesEmpleado($id)
    {
        // $a = DB::table('empleados')  
        // //->select('sesiones.id as idse', 'sesiones.fecha_ini', 'sesiones.fecha_fin', 'sesiones.estado', 'sesiones.hora_id AS idhora', 'horas.hora')
        // ->select('sesiones.id as id', DB::raw("concat(pacientes.nombre,' ',pacientes.aPaterno,' ',pacientes.aMaterno) as title"), 'sesiones.estado', 'horas.hora as descripcion', DB::raw("concat(sesiones.fecha_ini,'T',horas.hora) as start"))
        // ->join('pacientes', 'pacientes.id', '=', 'ordenes.paciente_id') 
        // ->join('historiales', 'historiales.orden_id', '=', 'ordenes.id')
        // ->join('sesiones', 'sesiones.historial_id', '=', 'historiales.id')
        // ->join('sesiones', 'sesiones.empleado_id', '=', 'empleados.id')
        // ->join('horas', 'horas.id', '=', 'sesiones.hora_id')
        // ->where('empleados.id', '=', $id)
        // ->get();
        //nuevo con datos añadidos el 9 agosto
      
        $sesiones = DB::table('empleados')  
        //->select('sesiones.id as idse', 'sesiones.fecha_ini', 'sesiones.fecha_fin', 'sesiones.estado', 'sesiones.hora_id AS idhora', 'horas.hora')
        ->select('sesiones.id as id', DB::raw("concat(pacientes.nombre,' ',pacientes.aPaterno,' ',pacientes.aMaterno) as title"), 'sesiones.estado', 'horas.hora as descripcion', DB::raw("concat(sesiones.fecha_ini,'T',horas.hora) as start"))
        ->join('sesiones', 'sesiones.empleado_id', '=', 'empleados.id')
        ->join('pacientes', 'pacientes.id', '=', 'sesiones.paciente_id')
        ->join('horas', 'horas.id', '=', 'sesiones.hora_id')
        ->where('empleados.id', '=', $id)
        ->get();

        //añadido
        $ordenes = DB::table('empleados')  
        ->select('ordenes.id as id', DB::raw("concat(pacientes.nombre,' ',pacientes.aPaterno,' ',pacientes.aMaterno) as title"), 'ordenes.estado', 'horas.hora as descripcion', DB::raw("concat(ordenes.fecha,'T',horas.hora) as start"))
        ->join('ordenes', 'ordenes.empleado_id', '=', 'empleados.id')
        ->join('pacientes', 'pacientes.id', '=', 'ordenes.paciente_id')
        ->join('horas', 'horas.id', '=', 'ordenes.hora_id')
        ->where('empleados.id', '=', $id)
        ->get();

        foreach($sesiones as $sesion){
            $resources[] = array("id" => $sesion->id ,"title" => $sesion->title, "estado" => $sesion->estado ,"descripcion" => $sesion->descripcion, "start" => $sesion->start);    
        }

        foreach($ordenes as $orden){
            $resources[] = array("id" => $orden->id ,"title" => $orden->title, "estado" => $orden->estado ,"descripcion" => $orden->descripcion, "start" => $orden->start);    
        }
        return json_encode($resources);
        // return json_encode($sesiones);
    }
    //para saber si hay horas
    public function counthorassec($fisio, $fecha, $hora)
    {       
        $sesiones = DB::table('sesiones')
                ->select('sesiones.hora_id')
                ->join('empleados', 'empleados.id', '=', 'sesiones.empleado_id')
                ->where('sesiones.fecha_ini', '=', $fecha)
                ->where('empleados.id', '=', $fisio)
                ->where('sesiones.hora_id', '=', $hora)
                ->count();
        $ordenes = DB::table('ordenes')
                ->select('ordenes.hora_id')
                ->join('empleados', 'empleados.id', '=', 'ordenes.empleado_id')
                ->where('ordenes.fecha', '=', $fecha)
                ->where('empleados.id', '=', $fisio)
                ->where('ordenes.hora_id', '=', $hora)
                ->count(); 
        // $suma = $sesiones + $ordenes;
        // $suma = $fecha+1;
        return date("Y-m-d",strtotime($fecha."+ 1 days")); 
    }

    public function counthorasord($fisio, $fecha_ini, $hora, $dias)
    {
        $hay = 0;
        $nohay = 0;
        
        for($i=0 ; $i<$dias; $i++){
            $sesiones = DB::table('sesiones')
                ->select('sesiones.hora_id')
                ->join('empleados', 'empleados.id', '=', 'sesiones.empleado_id')
                ->where('sesiones.fecha_ini', '=', $fecha_ini)
                ->where('empleados.id', '=', $fisio)
                ->where('sesiones.hora_id', '=', $hora)
                ->count();
            $ordenes = DB::table('ordenes')
                ->select('ordenes.hora_id')
                ->join('empleados', 'empleados.id', '=', 'ordenes.empleado_id')
                ->where('ordenes.fecha', '=', $fecha_ini)
                ->where('empleados.id', '=', $fisio)
                ->where('ordenes.hora_id', '=', $hora)
                ->count();
            $suma = $ordenes+$sesiones;
            if($suma>0){
                $hay = $hay +1; 
            }else{
                $nohay = $nohay+1;
                
            }
            $fecha_ini = date("Y-m-d",strtotime($fecha_ini."+ 1 days"));
        }
        $resources[] = array("hay" => $hay, "nohay" => $nohay);
        return $resources;
    }

}
