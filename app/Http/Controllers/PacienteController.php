<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Departamento;
use App\Models\Turno;
use App\Models\Rol;
use App\Models\Empleado;
use App\Models\Historial;
use App\Models\Paciente;
use App\Models\User;
use App\Models\Orden;
use App\Models\Sesion;
use App\Models\Tratamiento;
use App\Models\Informe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class PacienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hoy= Orden::where('fecha', Carbon::now()->toDateString())->count();
        $alta = DB::table('pacientes')->where('estado', '=' ,'ALTA')->count();
        $activos = DB::table('pacientes')->where('estado', '=' ,'ACTIVO')->count();
        $total = DB::table('pacientes')->count();
        $texto = trim($request->get('texto'));
        $id=auth()->user()->id;
        $usr_sesion= DB::table('empleados')->where('user_id', '=', $id)->first();
        $pacientes = DB::table('pacientes')
                            ->select('id', 'ci', 'aPaterno', 'aMaterno', 'nombre', 'celular', 'fechaNacimiento')
                            ->where('ci', 'LIKE', '%'.$texto.'%')
                            ->orWhere(DB::raw("concat(pacientes.aPaterno,' ',pacientes.aMaterno,' ',pacientes.nombre)"), 'LIKE', '%'.$texto.'%')
                            ->orderBy('id', 'desc')
                            ->paginate(10);     //CANTIDAD DE REGISTROS EN LISTA
        $datos= array(
            'hoy' => $hoy,
            'alta' => $alta,
            'activos' => $activos,
            'total' => $total,
            'usr_sesion' => $usr_sesion,
            'pacientes' => $pacientes,
            'texto' => $texto,
        );
        return view('pacientes.paciente')->with($datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //usuario de sesion que siemrpe es empleado
        $id = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id)->first();
        //Datos para registrar al usuario
        $departamentos = Departamento::All();
        $turnos = Turno::All();
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'departamentos' => $departamentos,
            'turnos' => $turnos,
        );
        return view('pacientes.paciente_registro')->with($datos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //usuario registro
        $usuarios= new User();
        $usuarios->email = $request->email;
        $user = Str::substr(Str::upper($request->aPaterno), 0, 1).''.Str::substr(Str::upper($request->aMaterno), 0, 1).''.$request->ci;
        $usuarios->usuario = $user;
        $usuarios->password = bcrypt($request->ci);
        $usuarios->fechaRegistro = Carbon::now();
        //directo el rol paciente id=6
        $usuarios->rol_id=6;
        //creador
        $id = auth()->user()->id;
        $creador = DB::table('empleados')->where('user_id', '=', $id)->first();
        $usuarios->creacion_usuario = Str::upper($creador->aPaterno.' ' .$creador->aMaterno.' '.$creador->nombre);
        $usuarios->created_at = Carbon::now();
        $usuarios->save();

        //Paciente que se creara
        $paciente = new Paciente();
        $paciente->ci = $request->ci;
        $paciente->departamento_id = $request->departamento_id;
        $paciente->aPaterno = Str::upper($request->aPaterno);
        $paciente->aMaterno = Str::upper($request->aMaterno);
        $paciente->nombre = Str::upper($request->nombre);
        $paciente->genero = $request->genero;
        $paciente->fechaNacimiento = $request->fechaNacimiento;
        $paciente->direccion = Str::upper($request->direccion);
        $paciente->telefono = $request->telefono;
        $paciente->celular = $request->celular;

        $usuario_id = User::where('usuario', '=', $user)->first();
        $paciente->user_id = $usuario_id->id;

        $paciente->creacion_usuario = Str::upper($creador->aPaterno.' '.$creador->aMaterno.' '.$creador->nombre);
        $paciente->created_at = Carbon::now();
        $paciente->save();
        // return $creador;
        //Flash::success('El empleado ' . $empleado->nombre . ' ' . $empleado->aPaterno . ' ' . $empleado->aMaterno . ' se creo con exito.');
        return redirect('/pacientes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //ver al empleado datos
        $id_sesion = auth()->user()->id;
        if(auth()->user()->rol_id == 5){
            $usr_sesion = DB::table('pacientes')->where('user_id', '=', $id_sesion)->first();
        }else{
            $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sesion)->first();
        }

        //datos para visualizar
        $pacientes = Paciente::find($id);
        $usuarios = DB::table('users')->where('id', '=', $pacientes->user_id)->first();
        $departamentos = DB::table('departamentos')->where('id', '=', $pacientes->departamento_id)->first();
        $turnos = DB::table('turnos')->where('id', '=', $pacientes->turno_id)->first();
        $roles = DB::table('roles')->where('id', '=', $usuarios->rol_id)->first();
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'pacientes' => $pacientes,
            'usuarios' => $usuarios,
            'departamentos' => $departamentos,
            'turnos' => $turnos,
            'roles' => $roles,
        );
        return view('pacientes.paciente_datos')->with($datos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //datos del empleado
        $id_sesion = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sesion)->first();
        //vista de pacientes editar
        $pacientes=Paciente::find($id);
        $usuarios=User::find($pacientes->user_id);
        $departamentos = Departamento::All();
        $turnos = Turno::All();
        $roles = Rol::All();
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'pacientes' => $pacientes,
            'usuarios' => $usuarios,
            'departamentos' => $departamentos,
            'turnos' => $turnos,
            'roles' => $roles,
        );
        return view('pacientes.paciente_editar')->with($datos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //usuario logeado
        $id = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id)->first();
        //paciente a ser modificado
        $paciente=Paciente::find($request->id);
        $paciente->ci = $request->ci;
        $paciente->departamento_id = $request->departamento_id;
        $paciente->aPaterno = Str::upper($request->aPaterno);
        $paciente->aMaterno = Str::upper($request->aMaterno);
        $paciente->nombre = Str::upper($request->nombre);
        $paciente->genero = $request->genero;
        $paciente->fechaNacimiento = $request->fechaNacimiento;
        $paciente->direccion = Str::upper($request->direccion);
        $paciente->telefono = $request->telefono;
        $paciente->celular = $request->celular;
        $paciente->modificacion_usuario = Str::upper($usr_sesion->aPaterno.' '.$usr_sesion->aMaterno.' '.$usr_sesion->nombre);
        $paciente->updated_at = Carbon::now();
        $paciente->save();

        //tabla usuario del paciente
        $usuario_pac = User::where('id', '=', $paciente->user_id)->first();
        $usuario_pac->email = $request->email;
        $usuario_pac->usuario = Str::substr(Str::upper($request->aPaterno), 0, 1).''.Str::substr(Str::upper($request->aMaterno), 0, 1).''.$request->ci; //aumentado ci
        isset($request->contraseña) ? $usuario_pac->password = bcrypt($request->password) :"";
        //return $usuario_pac;
        $usuario_pac->modificacion_usuario = Str::upper($usr_sesion->aPaterno.' '.$usr_sesion->aMaterno.' '.$usr_sesion->nombre);
        $usuario_pac->updated_at = Carbon::now();
        $usuario_pac->save();
        return redirect('pacientes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function orden($id, Request $request)
    {
        $id_sesion = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sesion)->first();

        //datos para visualizar
        $pacientes = Paciente::find($id);
        $usuarios = DB::table('users')->where('id', '=', $pacientes->user_id)->first();
        $departamentos = DB::table('departamentos')->where('id', '=', $pacientes->departamento_id)->first();
        $turnos = DB::table('turnos')->where('id', '=', $pacientes->turno_id)->first();
        $roles = DB::table('roles')->where('id', '=', $usuarios->rol_id)->first();
        $nturnos = Turno::All();
        $ordenes = DB::table('ordenes')
                            ->select('ordenes.id as orde','ordenes.fecha', 'ordenes.diagnostico_ref', 'ordenes.turno_id', 'ordenes.estado', 'empleados.nombre', 'empleados.aPaterno', 'empleados.aMaterno', 'empleados.grado_academico')
                            ->join('empleados', 'ordenes.empleado_id', '=', 'empleados.id')
                            ->where('ordenes.paciente_id','=',$id)
                            ->orderBy('fecha', 'desc')
                            ->paginate(10);
        // return $ordenes;
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'pacientes' => $pacientes,
            'usuarios' => $usuarios,
            'departamentos' => $departamentos,
            'turnos' => $turnos,
            'roles' => $roles,
            'ordenes' => $ordenes,
            'nturnos' => $nturnos,
        );
        return view('ordenes.orden')->with($datos);
    }

    public function ocreate($id)
    {
        //usuario de sesion que siemrpe es empleado
        $id_sec = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sec)->first();

        //ESTE METODO ERA PARA HACER TURNO Y MEDICOS AL AZAR------------------------
        //Datos para el paciente y su orden
        //$hora = Carbon::now()->toTimeString();
        //para poner los turnos y cantidad de ordenes
        // if($hora>="01:00:00" and $hora<="12:00:59"){
        //     $mañana_tarde=1;
        //     $contador= Orden::where('fecha', Carbon::now()->toDateString())
        //           ->where('turno_id',1)->count();
        //     $turnos = "MAÑANA";
        //     $turno_id = "1";
        // }else{
        //     $mañana_tarde=2;
        //     $contador= Orden::where('fecha', Carbon::now()->toDateString())
        //     ->where('turno_id',2)->count();
        //     $turnos = "TARDE";
        //     $turno_id = "2";
        // }
        // //return $contador;
        // //medicos por turno
        // $consulta_medicos = DB::table('users')
        //     ->select('users.id as user_id','empleados.id as emple_id', 'empleados.nombre', 'empleados.aPaterno', 'empleados.aMaterno')
        //     ->join('empleados', 'empleados.user_id', '=', 'users.id')
        //     ->where('empleados.turno_id','=',$mañana_tarde)
        //     ->where('users.estado','=','ACTIVO')
        //     ->where(function ($query) {
        //         $query->where('users.rol_id','=',3)
        //               ->orWhere('users.rol_id','=',4);
        //     })
        //     ->get();
        // $medicos= array();
        // $i=1;
        // foreach($consulta_medicos as $med){
        //     $medicos[$i]=array($med);
        //     $i=$i+1;
        // }
        // if($consulta_medicos->count() == "0"){
        //     // $posicion=($contador+1) % $consulta_medicos->count();
        //     // if($posicion == 0){
        //     //     $posicion=$consulta_medicos->count();
        //     // }
        //     // //return $posicion;
        //     // $medico_selec = $medicos[$posicion];
        //     $medico_selec = "NO HAY FISIOTERAPEUTAS DISPONIBLES";
        // }else{
        //     $posicion=($contador+1) % $consulta_medicos->count();
        //     if($posicion == 0){
        //         $posicion=$consulta_medicos->count();
        //     }
        //     //return $posicion;
        //     $medico_selec = $medicos[$posicion];
        // }
        // return $medico_selec;
        //return $nombre_med;
        // $datos = array(
        //     'usr_sesion' => $usr_sesion,
        //     'medicos' => $medicos,
        //     'turnos' => $turnos,
        //     'medico_selec' => $medico_selec,
        //     'id' => $id,
        //     'turno_id' => $turno_id,
        // );
        //-------------------------------------------------------------
        $fecha = Carbon::now()->toDateString();
        $turnos = Turno::All();
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'fecha' => $fecha,
            'turnos' => $turnos,
            'id' => $id,
       );
        //return $turnos;
        return view('ordenes.orden_registro')->with($datos);
    }

    public function ostore(Request $request)
    {
        //registro de la orden
        // return $request->turno_id;
        $orden= new Orden();
        $orden->fecha = $request->fecha;
        $orden->hora_id = $request->horas;
        // $orden->hora = Carbon::now()->toTimeString();
        $orden->estado = "En Espera";  //poner en espera
        $orden->diagnostico_ref = $request->diagnostico_ref;
        $orden->turno_id = $request->turno_id;
        $orden->empleado_id = $request->fisio_id;
        $orden->paciente_id = $request->pac_id;
        //usuario logeado
        $id = auth()->user()->id;
        $creador = DB::table('empleados')->where('user_id', '=', $id)->first();
        $orden->creacion_usuario = $creador->aPaterno.' ' .$creador->aMaterno.' '.$creador->nombre;
        $orden->created_at = Carbon::now();
        $orden->save();
        // return redirect('/pacientes');
        return Redirect::to('ordenes/' .$request->pac_id. '/orden');
    }

    public function oedit($id)
    {
        //datos del empleado
        $id_sesion = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sesion)->first();
        //vista de orden editar
        $ordenes=Orden::find($id);
        $turnos = Turno::All();
        $empleados = DB::table('empleados')
                ->select('empleados.id','empleados.nombre', 'empleados.aPaterno', 'empleados.aMaterno', 'empleados.grado_academico' ,'users.id AS id_users', 'users.rol_id')
                ->join('users', 'empleados.user_id', '=', 'users.id')
                ->where('users.estado', '=', 'ACTIVO')
                ->where('empleados.turno_id', '=', $ordenes->turno_id)
                ->where('users.rol_id', '<>', 1)
                ->get();
        //para las horas
        $orden=DB::table('ordenes')
                ->select('ordenes.hora_id')
                ->join('empleados', 'empleados.id', '=', 'ordenes.empleado_id')
                ->where('ordenes.fecha', '=', $ordenes->fecha)
                ->where('empleados.id', '=', $ordenes->empleado_id)
                ->get();

        $sesiones=DB::table('sesiones')
                ->select('sesiones.hora_id')
                ->join('empleados', 'empleados.id', '=', 'sesiones.empleado_id')
                ->where('sesiones.fecha_ini', '=', $ordenes->fecha)
                ->where('empleados.id', '=', $ordenes->empleado_id)
                ->get();

        // $sesiones=DB::table('sesiones')
        //         ->select('sesiones.hora_id')
        //         ->join('historiales', 'historiales.id', '=', 'sesiones.historial_id')
        //         ->join('ordenes', 'ordenes.id', '=', 'historiales.orden_id')
        //         ->join('empleados', 'empleados.id', '=', 'ordenes.empleado_id')
        //         ->where('sesiones.fecha_ini', '=', $ordenes->fecha)
        //         ->where('empleados.id', '=', $ordenes->empleado_id)
        //         ->get();

        $rol=DB::table('empleados')
                ->select('users.rol_id')
                ->join('users', 'empleados.user_id', '=', 'users.id')
                ->where('empleados.id', '=', $ordenes->empleado_id)
                ->first();

        $hora_id=[];
        foreach($orden as $or){
            $hora_id[] = array("hora_id" => $or->hora_id);
        }

        foreach($sesiones as $sesion){
            $hora_id[] = array("hora_id" => $sesion->hora_id);
        }
        $horas=DB::table('horas')->where('horas.turno_id', '=', $ordenes->turno_id)->where('horas.rol_id', '=', $rol->rol_id)->get();
        $resources=[];
        if(count($hora_id) == 0){
            foreach($horas as $hora){
                $resources[] = array('id' => $hora->id ,'hora' => $hora->hora);
            }
        }else{
            $ids_horas = Arr::flatten($hora_id);

            foreach($horas as $hora){
                $cont=0;
                for ($i=0; $i<count($ids_horas); $i++) {
                    if($hora->id == $ids_horas[$i]){
                        $cont=$cont+1;
                    }else
                    if($hora->id == $ordenes->hora_id){
                        $resources[] = array('id' => $hora->id ,'hora' => $hora->hora);
                        $cont=$cont+1;
                    }
                }
                if($cont == 0){
                    $resources[] = array('id' => $hora->id ,'hora' => $hora->hora);
                }
            }
        }
        $res = json_decode( json_encode( $resources ), true );
        //  return $horas;
        //$turnos =Turno::find($ordenes->turno_id);
        $empleado = Empleado::find($ordenes->empleado_id);
        // return $ordenes->diagnostico_ref;
        //para la hora de un paciente a editar
        $horaeditar=DB::table('ordenes')
                ->select('ordenes.hora_id','horas.hora')
                ->join('horas', 'horas.id', '=', 'ordenes.hora_id')
                ->where('ordenes.paciente_id', '=', $ordenes->paciente_id)
                ->where('ordenes.fecha', '=', $ordenes->fecha)
                ->first();

        $datos = array(
            'usr_sesion' => $usr_sesion,
            'turnos' => $turnos,
            'ordenes' => $ordenes,
            'empleado' => $empleado,
            'empleados' => $empleados,
            'resources' =>$res,
            // 'resources' =>$resources,
            'hora_id' => $hora_id,
            'horas' => $horas,
            'horaeditar' => $horaeditar
        );
        // $result = compact('datos','resources');
        // return $datos;
        return view('ordenes.orden_editar')->with($datos);
        // return view('ordenes.orden_editar', compact('datos','resources'));
    }

    public function oupdate(Request $request)
    {
        //usuario logeado
        $id = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id)->first();
        //paciente a ser modificado
        $orden=Orden::find($request->id);
        $orden->fecha = $request->fecha;
        // $orden->hora_id = $request->horas;
        if($request->horas == ''){
            $orden->hora_id = $request->hora_id_edit;
        }else{
            $orden->hora_id = $request->horas;
        }
        $orden->diagnostico_ref = $request->diagnostico_ref;
        $orden->turno_id = $request->turno_id;
        $orden->empleado_id = $request->fisio_id;
        $orden->modificacion_usuario = $usr_sesion->aPaterno.' '.$usr_sesion->aMaterno.' '.$usr_sesion->nombre;
        $orden->updated_at = Carbon::now();
        $orden->save();
        // return redirect('/pacientes');
        return Redirect::to('ordenes/' .$orden->paciente_id. '/orden');
    }

    //PARA LAS BANDEJAS
    public function bindex(Request $request)
    {
        $texto = trim($request->get('texto'));
        $id=auth()->user()->id;
        $usr_sesion= DB::table('empleados')->where('user_id', '=', $id)->first();
        $enespera = DB::table('ordenes')
                        ->select('ordenes.id')
                        ->join('pacientes', 'ordenes.paciente_id', '=', 'pacientes.id')
                        ->join('empleados', 'ordenes.empleado_id', '=', 'empleados.id')
                        ->where('empleados.id', '=', $usr_sesion->id)
                        ->where('ordenes.estado','=','En Espera')
                        ->where('ordenes.fecha','=',Carbon::now()->toDateString())
                        ->count();
        $atendidos = DB::table('ordenes')
                        ->select('ordenes.id')
                        ->join('pacientes', 'ordenes.paciente_id', '=', 'pacientes.id')
                        ->join('empleados', 'ordenes.empleado_id', '=', 'empleados.id')
                        ->where('empleados.id', '=', $usr_sesion->id)
                        ->where('ordenes.estado','=','Atendido')
                        ->where('ordenes.fecha','=',Carbon::now()->toDateString())
                        ->count();
        $pacientes = DB::table('empleados')
                            ->select('pacientes.id', 'pacientes.ci', 'pacientes.aPaterno', 'pacientes.aMaterno', 'pacientes.nombre', 'pacientes.celular', 'pacientes.fechaNacimiento','horas.hora', 'ordenes.diagnostico_ref')
                            ->join('ordenes', 'ordenes.empleado_id', '=', 'empleados.id')
                            ->join('pacientes', 'pacientes.id', '=', 'ordenes.paciente_id')
                            ->join('horas', 'horas.id', '=', 'ordenes.hora_id')
                            ->where('ordenes.empleado_id','=',$usr_sesion->id)
                            ->where('ordenes.estado','=','En Espera')  //aca poner en espera
                            ->where('ordenes.fecha','=',Carbon::now()->toDateString())
                            ->where(function ($query) use ($texto){
                                $query->where('pacientes.ci', 'LIKE', '%'.$texto.'%')
                                    ->orWhere(DB::raw("concat(pacientes.aPaterno,' ',pacientes.aMaterno,' ',pacientes.nombre)"), 'LIKE', '%'.$texto.'%');
                                })
                            // ->where('pacientes.ci', 'LIKE', '%'.$texto.'%')
                            // ->orwhere(DB::raw("concat(pacientes.aPaterno,' ',pacientes.aMaterno,' ',pacientes.nombre)"), 'LIKE', '%'.$texto1.'%')
                            ->orderBy('horas.hora', 'asc') //--------------------ARREGLAR URGENTE 23/07
                            ->paginate(10);     //CANTIDAD DE REGISTROS EN LISTA
        $datos= array(
            'usr_sesion' => $usr_sesion,
            'pacientes' => $pacientes,
            'texto' => $texto,
            'enespera' => $enespera,
            'atendidos' => $atendidos
        );
        // return $pacientes;
        return view('bandejas.paciente')->with($datos);
    }

    //PARA EL HISTORIAL
    public function historial($id, Request $request)
    {
        $id_sesion = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sesion)->first();

        //datos para visualizar
        $pacientes = Paciente::find($id);
        $usuarios = DB::table('users')->where('id', '=', $pacientes->user_id)->first();
        $departamentos = DB::table('departamentos')->where('id', '=', $pacientes->departamento_id)->first();
        $turnos = DB::table('turnos')->where('id', '=', $pacientes->turno_id)->first();
        $roles = DB::table('roles')->where('id', '=', $usuarios->rol_id)->first();
        $nturnos = Turno::All();

        // $historiales = DB::table('historiales')
        //                     ->select('historiales.id','historiales.fechaIngreso','historiales.motivo','historiales.tratamiento','empleados.nombre','empleados.aPaterno','empleados.aMaterno')
        //                     ->join('pacientes', 'historiales.paciente_id', '=', 'pacientes.id')
        //                     ->join('empleados', 'historiales.empleado_id', '=', 'empleados.id')
        //                     ->where('historiales.paciente_id','=',$pacientes->id)
        //                     ->orderBy('fechaIngreso', 'desc')
        //                     ->paginate(10);

        $historiales = DB::table('historiales')
                            ->select('historiales.id','historiales.fechaIngreso','historiales.motivo','historiales.tratamiento','empleados.nombre','empleados.aPaterno','empleados.aMaterno')
                            ->join('ordenes', 'historiales.orden_id', '=', 'ordenes.id')
                            ->join('pacientes', 'ordenes.paciente_id', '=', 'pacientes.id')
                            ->join('empleados', 'ordenes.empleado_id', '=', 'empleados.id')
                            ->where('pacientes.id','=',$pacientes->id)
                            ->orderBy('ordenes.fecha', 'desc')
                            ->paginate(10);
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'pacientes' => $pacientes,
            'usuarios' => $usuarios,
            'departamentos' => $departamentos,
            'turnos' => $turnos,
            'roles' => $roles,
            'historiales' => $historiales,
            'nturnos' => $nturnos,
        );
        // return $datos;
        return view('historiales.historial')->with($datos);
    }

    public function hcreate($id)
    {
        //usuario de sesion que siemrpe es empleado
        $id_sec = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sec)->first();
        //diagnostico de referencia
        $orden = Orden::select('ordenes.id', 'ordenes.diagnostico_ref')
                        ->join('pacientes', 'ordenes.paciente_id', '=', 'pacientes.id')
                        ->where('ordenes.paciente_id','=', $id)
                        ->where('ordenes.estado', '=', 'En Espera')//poner cancelado por En espera urgente
                        ->first();
        $rol= DB::table('users')->where('id', '=', $id_sec)->first();
        //return $rol;
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'orden' => $orden,
            'id' => $id,
            'rol' => $rol,
        );
        return view('historiales.historial_registro')->with($datos);
    }
//FALTAAAAAA REVISAR SI FUNCION Y PONER LA VISTA
    public function hstore(Request $request)
    {
        //registro de la orden
        $historial = new Historial();
        $historial->fechaIngreso = Carbon::now();
        $historial->motivo = $request->motivo;
        $historial->his_enfermedad = $request->his_enfermedad;
        $historial->examen_fis_kin = $request->examen_fis_kin;
        $historial->diagnostico_kin = $request->diagnostico_kin;
        $historial->tratamiento = $request->tratamiento;
        // $historial->empleado_id = $request->empleado_id;
        // $historial->paciente_id = $request->paciente_id;
        //aumentado
        $historial->num_sesiones = $request->num_sesiones;
        $historial->orden_id = $request->orden_id;
        //id paciente
        $orden=Orden::find($request->orden_id);
        $paciente = DB::table('pacientes')->where('id', '=', $orden->paciente_id)->first();
        //usuario logeado
        $id = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id)->first();
        $historial->creacion_usuario = $usr_sesion->aPaterno.' ' .$usr_sesion->aMaterno.' '.$usr_sesion->nombre;
        $historial->created_at = Carbon::now();
        $historial->save();

        //cambiar la orden a atendido
        $orden->estado = "Atendido";
        $orden->save();
        //mandar ha hstorial para qe luego se aña la cita
        return Redirect::to('citas/' . $paciente->id.'/'.$request->orden_id. '/programar');
    }

    //PARA EL CALENDARIO DE CITAS Y/O SESIONES
    public function cindex($id,$orden)
    {
        //logeado
        $id_us=auth()->user()->id;
        $usr_sesion= DB::table('empleados')->where('user_id', '=', $id_us)->first();
        //para el turno y empleado
        $turnos = Turno::All();
        $paciente = Paciente::find($id);
        $historial= DB::table('historiales')->where('historiales.orden_id', '=', $orden)->first();
        $orden_id = $orden;
        $contador = DB::table('sesiones')
                        ->join('historiales', 'sesiones.historial_id', '=', 'historiales.id')
                        ->where('historiales.id','=', $historial->id)
                        ->count();

        // return $sesion;
        $datos= array(
            'usr_sesion' => $usr_sesion,
            'paciente' => $paciente,
            'turnos' => $turnos,
            'historial' => $historial,
            'orden_id' => $orden_id,
            'contador' => $contador,
        );
        // return $datos;
        return view('citas.calendario')->with($datos);
    }
    //registro de las sesiones osea de las citas
    public function cstore(Request $request)
    {
        //registro de la orden
        // return $request->turno_id;
        $sesion= new Sesion();
        $sesion->fecha_ini = $request->fecha_ini;
        $sesion->fecha_fin = $request->fecha_fin;
        $sesion->hora_id = $request->hora_id;
        $sesion->turno_id = $request->turno_id;
        // $orden->hora = Carbon::now()->toTimeString();
        $sesion->estado = $request->estado;
        $sesion->historial_id = $request->historial_id;
        $sesion->empleado_id = $request->empleado_id;
        $sesion->paciente_id = $request->paciente_id;
        //usuario logeado
        $id = auth()->user()->id;
        $creador = DB::table('empleados')->where('user_id', '=', $id)->first();
        $sesion->creacion_usuario = $creador->aPaterno.' ' .$creador->aMaterno.' '.$creador->nombre;
        $sesion->created_at = Carbon::now();
        $sesion->save();
        $contador = DB::table('sesiones')
                        ->join('historiales', 'sesiones.historial_id', '=', 'historiales.id')
                        ->where('historiales.id','=', $request->historial_id)
                        ->count();
        return $contador;
// $sesion=Sesion::create($request->all());
        // poner los datos que ya estaban
        // $id_us=auth()->user()->id;
        // $usr_sesion= DB::table('empleados')->where('user_id', '=', $id_us)->first();
        // $turnos = Turno::All();
        // $empleados = DB::table('empleados')
        //         ->select('empleados.id','empleados.nombre', 'empleados.aPaterno', 'empleados.aMaterno', 'empleados.grado_academico' ,'users.id AS id_users', 'users.rol_id')
        //         ->join('users', 'empleados.user_id', '=', 'users.id')
        //         ->where('users.estado', '=', 'ACTIVO')
        //         ->where('empleados.turno_id', '=', $request->turno)
        //         ->where('users.rol_id', '<>', 1)
        //         ->get();
        // $paciente = Paciente::find($request->paciente_id);
        // $historial= DB::table('historiales')->where('historiales.orden_id', '=', $request->orden_id)->first();
        // $ordenes = Orden::find($request->orden_id);
        // $orden_id = $request->orden_id;
        // $datos= array(
        //     'usr_sesion' => $usr_sesion,
        //     'turnos' => $turnos,
        //     'empleados' => $empleados,
        //     'paciente' => $paciente,
        //     'historial' => $historial,
        //     'ordenes' => $ordenes,
        //     'orden_id' => $orden_id,
        // );


        // return view('citas.calendario')->with($datos);

    }

    //para el historial en general
    public function hindex(Request $request)
    {
        $contador= Orden::where('fecha', Carbon::now()->toDateString())->count();
        $texto = trim($request->get('texto'));
        $id=auth()->user()->id;
        $usr_sesion= DB::table('empleados')->where('user_id', '=', $id)->first();
        $pacientes = DB::table('pacientes')
                            ->select('id', 'ci', 'aPaterno', 'aMaterno', 'nombre', 'celular', 'fechaNacimiento')
                            ->where('ci', 'LIKE', '%'.$texto.'%')
                            ->orWhere(DB::raw("concat(pacientes.aPaterno,' ',pacientes.aMaterno,' ',pacientes.nombre)"), 'LIKE', '%'.$texto.'%')
                            ->orderBy('id', 'desc')
                            ->paginate(10);     //CANTIDAD DE REGISTROS EN LISTA
        $datos= array(
            'contador' => $contador,
            'usr_sesion' => $usr_sesion,
            'pacientes' => $pacientes,
            'texto' => $texto,
        );
        return view('historiales.historial_todos')->with($datos);
    }

    //para las citas de los fisioterapeutas en el dia
    public function cfindex(Request $request)
    {
        $contador= Orden::where('fecha', Carbon::now()->toDateString())
                            ->where('estado','En Espera')  //aca poner en espera y arreglar
                            ->count(); //ACA ARREGLAR PARA QUE CUENTE SOLO DE UN MEDICO URGENTE!!!!!!!1
        $texto = trim($request->get('texto'));
        $id=auth()->user()->id;
        $usr_sesion= DB::table('empleados')->where('user_id', '=', $id)->first();
        //nuevo que se añadio el 9 de agosto pac, his,se
        $pacientes = DB::table('pacientes')
                        ->select('pacientes.id as id_pac', 'pacientes.ci', 'pacientes.aPaterno', 'pacientes.aMaterno', 'pacientes.nombre', 'pacientes.celular', 'historiales.num_sesiones', 'sesiones.id', 'historiales.id')
                        ->join('sesiones', 'pacientes.id', '=', 'sesiones.paciente_id')
                        ->join('empleados', 'sesiones.empleado_id', '=', 'empleados.id')
                        ->join('historiales', 'historiales.id', '=', 'sesiones.historial_id')
                        // ->where('pacientes.estado','=','ACTIVO')
                        ->where('empleados.id','=',$usr_sesion->id)
                        ->where('sesiones.fecha_ini','=',Carbon::now()->toDateString())
                        ->where(function ($query) use ($texto){
                            $query->where('pacientes.ci', 'LIKE', '%'.$texto.'%')
                                ->orWhere(DB::raw("concat(pacientes.aPaterno,' ',pacientes.aMaterno,' ',pacientes.nombre)"), 'LIKE', '%'.$texto.'%');
                            })
                        ->orderBy('sesiones.fecha_ini', 'asc') //ver i se puede cambiar a hora mas F
                        ->paginate(10);

        // $pacientes = DB::table('pacientes')
        //                     ->select('pacientes.id as id_pac', 'pacientes.ci', 'pacientes.aPaterno', 'pacientes.aMaterno', 'pacientes.nombre', 'pacientes.celular', 'historiales.num_sesiones', 'sesiones.id', 'historiales.id')
        //                     ->join('ordenes', 'pacientes.id', '=', 'ordenes.paciente_id')
        //                     ->join('empleados', 'ordenes.empleado_id', '=', 'empleados.id')
        //                     ->join('historiales', 'ordenes.id', '=', 'historiales.orden_id')
        //                     ->join('sesiones', 'historiales.id', '=', 'sesiones.historial_id')
        //                     ->where('pacientes.estado','=','ACTIVO')
        //                     ->where('empleados.id','=',$usr_sesion->id)
        //                     ->where('sesiones.fecha_ini','=',Carbon::now()->toDateString())
        //                     ->orderBy('sesiones.fecha_ini', 'asc') //ver i se puede cambiar a hora mas F
        //                     ->paginate(10);     //CANTIDAD DE REGISTROS EN LISTA
        $datos= array(
            'contador' => $contador,
            'usr_sesion' => $usr_sesion,
            'pacientes' => $pacientes,
            'texto' => $texto,
        );
        // return $pacientes;
        return view('citas.citasF')->with($datos);
    }

    //PARA LAS SESIONES
    public function sesion($id, Request $request)
    {
        $id_sesion = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sesion)->first();

        //datos para visualizar
        $pacientes = Paciente::find($id);
        $usuarios = DB::table('users')->where('id', '=', $pacientes->user_id)->first();
        $departamentos = DB::table('departamentos')->where('id', '=', $pacientes->departamento_id)->first();
        $turnos = DB::table('turnos')->where('id', '=', $pacientes->turno_id)->first();
        $roles = DB::table('roles')->where('id', '=', $usuarios->rol_id)->first();
        $nturnos = Turno::All();

        // $sesiones = DB::table('sesiones')
        //                     ->select('sesiones.id','sesiones.fecha_ini','sesiones.hora_id','sesiones.estado')
        //                     ->join('historiales', 'sesiones.historial_id', '=', 'historiales.id')
        //                     ->join('ordenes', 'historiales.orden_id', '=', 'ordenes.id')
        //                     ->join('pacientes', 'ordenes.paciente_id', '=', 'pacientes.id')
        //                     ->where('pacientes.id','=',$pacientes->id)
        //                     ->orderBy('ordenes.fecha', 'desc')
        //                     ->paginate(10);
        //9 de agosto
        $sesiones = DB::table('sesiones')
                    ->select('sesiones.id','sesiones.fecha_ini','sesiones.hora_id','sesiones.estado', 'horas.hora')
                    ->join('pacientes', 'sesiones.paciente_id', '=', 'pacientes.id')
                    ->join('horas', 'sesiones.hora_id', '=', 'horas.id')
                    ->where('pacientes.id','=',$pacientes->id)
                    ->orderBy('sesiones.fecha_ini', 'asc')
                    ->paginate(10);
        $fechaactual = Carbon::now()->toDateString();
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'pacientes' => $pacientes,
            'usuarios' => $usuarios,
            'departamentos' => $departamentos,
            'turnos' => $turnos,
            'roles' => $roles,
            'sesiones' => $sesiones,
            'nturnos' => $nturnos,
            'fechaactual' => $fechaactual,
        );
        // return $sesiones;
        return view('sesiones.sesion')->with($datos);
    }

    public function screate($id)
    {
        //usuario de sesion que siemrpe es empleado
        $id_sec = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sec)->first();
        //diagnostico de referencia
        $sesiones = Sesion::find($id);
        $tratamientos = Tratamiento::All();
        $sesant = $sesiones->id - 1;
        $sesionestra = DB::table('sesionestratamientos')->select('sesionestratamientos.sesion_id', 'sesionestratamientos.tratamiento_id', 'sesionestratamientos.detalle')
                        ->join('sesiones', 'sesiones.id', '=', 'sesionestratamientos.sesion_id')
                        ->where('sesionestratamientos.sesion_id', '=', $sesant)
                        ->where('sesiones.paciente_id', '=', $sesiones->paciente_id)
                        ->get();
                        // return $aaa;
        $cont = DB::table('sesionestratamientos')->select('sesionestratamientos.sesion_id', 'sesionestratamientos.tratamiento_id', 'sesionestratamientos.detalle')
                        ->join('sesiones', 'sesiones.id', '=', 'sesionestratamientos.sesion_id')
                        ->where('sesionestratamientos.sesion_id', '=', $sesant)
                        ->where('sesiones.paciente_id', '=', $sesiones->paciente_id)
                        ->count();
        $s = 0;
    // return $sesionestra;
        // WHERE sesionestratamientos.sesion_id=56 AND sesiones.paciente_id=6;
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'sesiones' => $sesiones,
            'id' => $id,
            'tratamientos' => $tratamientos,
            'sesionestra' => $sesionestra,
            'cont' => $cont,
            's' => $s,
        );
        return view('sesiones.sesion_registro')->with($datos);
    }

    public function sshow($id)
    {
        //usuario de sesion que siemrpe es empleado
        $id_sec = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sec)->first();
        //diagnostico de referencia
        $sesiones = Sesion::find($id);
        $tratamientos = Tratamiento::All();
        $sesionestra = DB::table('sesionestratamientos')->select('sesionestratamientos.sesion_id', 'sesionestratamientos.tratamiento_id', 'sesionestratamientos.detalle')
                        ->join('sesiones', 'sesiones.id', '=', 'sesionestratamientos.sesion_id')
                        ->where('sesionestratamientos.sesion_id', '=', $sesiones->id)
                        ->where('sesiones.paciente_id', '=', $sesiones->paciente_id)
                        ->get();
                        // return $aaa;
        $s = 0;
    // return $sesionestra;
        // WHERE sesionestratamientos.sesion_id=56 AND sesiones.paciente_id=6;
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'sesiones' => $sesiones,
            'id' => $id,
            'tratamientos' => $tratamientos,
            'sesionestra' => $sesionestra,
            's' => $s,
        );
        return view('sesiones.show')->with($datos);
    }

    public function svaciar($id)
    {
        //usuario de sesion que siemrpe es empleado
        $id_sec = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sec)->first();
        //diagnostico de referencia
        $sesiones = Sesion::find($id);
        $tratamientos = Tratamiento::All();
        $sesant = $sesiones->id - 1;
        $sesionestra = DB::table('sesionestratamientos')->select('sesionestratamientos.sesion_id', 'sesionestratamientos.tratamiento_id', 'sesionestratamientos.detalle')
                        ->join('sesiones', 'sesiones.id', '=', 'sesionestratamientos.sesion_id')
                        ->where('sesionestratamientos.sesion_id', '=', $sesant)
                        ->where('sesiones.paciente_id', '=', $sesiones->paciente_id)
                        ->get();
                        // return $aaa;
        $cont = 0;
        $s = 0;
    // return $sesionestra;
        // WHERE sesionestratamientos.sesion_id=56 AND sesiones.paciente_id=6;
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'sesiones' => $sesiones,
            'id' => $id,
            'tratamientos' => $tratamientos,
            'sesionestra' => $sesionestra,
            'cont' => $cont,
            's' => $s,
        );
        return view('sesiones.sesion_registro')->with($datos);
    }

    public function sestore(Request $request)
    {
        //usuario logeado
        $id = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id)->first();
        // sesiones

        $trat1 = $request->trat_1;
        $det1 = $request->detalle_1;
        $trat2 = $request->trat_2;
        $det2 = $request->detalle_2;
        $trat3 = $request->trat_3;
        $det3 = $request->detalle_3;
        $trat4 = $request->trat_4;
        $det4 = $request->detalle_4;
        $trat5 = $request->trat_5;
        $det5 = $request->detalle_5;
        $trat6 = $request->trat_6;
        $det6 = $request->detalle_6;
        $trat7 = $request->trat_7;
        $det7 = $request->detalle_7;
        $sesion = Sesion::find($request->ses_id);
        $sesion->observacion = $request->observacion;
        $sesion->estado = "Asistio";
        $sesion->save();
        if($trat1 <>'null'){
            $sesion->tratamientos()->attach($trat1, ['detalle' => $det1]);
        }
        if($trat2 <>'null'){
            $sesion->tratamientos()->attach($trat2, ['detalle' => $det2]);
        }
        if($trat3 <>'null'){
            $sesion->tratamientos()->attach($trat3, ['detalle' => $det3]);
        }
        if($trat4 <>'null'){
            $sesion->tratamientos()->attach($trat4, ['detalle' => $det4]);
        }
        if($trat5 <>'null'){
            $sesion->tratamientos()->attach($trat5, ['detalle' => $det5]);
        }
        if($trat6 <>'null'){
            $sesion->tratamientos()->attach($trat6, ['detalle' => $det6]);
        }
        if($trat7 <>'null'){
            $sesion->tratamientos()->attach($trat7, ['detalle' => $det7]);
        }
        $datos = array(
            'trat1' => $trat1,
            'det1' => $det1,
            'trat2' => $trat2,
            'det2' => $det2,
            'trat3' => $trat3,
            'det3' => $det3,
            'trat4' => $trat4,
            'det4' => $det4,
            'trat5' => $trat5,
            'det5' => $det5,
            'trat6' => $trat6,
            'det6' => $det6,
            'trat7' => $trat7,
            'det7' => $det7,
            'id' => $id,
        );
        return Redirect::to('/citasF');
        // return $datos;
        // /7$sesion=Sesion::find($request->ses_id)->first();
        // $sesion->estado = "Asistio";
       // return $sesion;
        //$sesion->modificacion_usuario = $usr_sesion->aPaterno.' '.$usr_sesion->aMaterno.' '.$usr_sesion->nombre;
       // $sesion->updated_at = Carbon::now();
        //$sesion->save();
        // return redirect('');
        //return Redirect::to('/sesiones/' . $paciente->id. '/sesionhistoriales');
    }

    public function noasistio($id)
    {
        //usuario logeado
        $iduser = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $iduser)->first();
        //sesion a ser modificado
        $sesion=Sesion::find($id);

        if ($sesion->estado == "No asistio") {
            $sesion->estado = "Asistio";
        } else {
            $sesion->estado = "No asistio";
        }
        $sesion->modificacion_usuario = Str::upper($usr_sesion->aPaterno.' '.$usr_sesion->aMaterno.' '.$usr_sesion->nombre);
        $sesion->updated_at = Carbon::now();
        $sesion->save();
        return Redirect::to('/sesiones/' . $sesion->paciente_id. '/sesion');

        // return redirect('/usuarios');
    }

    public function inindex(Request $request)
    {
        $contador= Orden::where('fecha', Carbon::now()->toDateString())
                            ->where('estado','En Espera')  //aca poner en espera y arreglar
                            ->count(); //ACA ARREGLAR PARA QUE CUENTE SOLO DE UN MEDICO URGENTE!!!!!!!1
        $texto = trim($request->get('texto'));
        $id=auth()->user()->id;
        $usr_sesion= DB::table('empleados')->where('user_id', '=', $id)->first();
        //nuevo que se añadio el 9 de agosto pac, his,se
        $pacientes = DB::table('pacientes')
                        ->select('pacientes.id as id_pac', 'pacientes.ci', 'pacientes.aPaterno', 'pacientes.aMaterno', 'pacientes.nombre', 'pacientes.celular', 'historiales.num_sesiones', 'sesiones.id', 'historiales.id')
                        ->join('sesiones', 'pacientes.id', '=', 'sesiones.paciente_id')
                        ->join('empleados', 'sesiones.empleado_id', '=', 'empleados.id')
                        ->join('historiales', 'historiales.id', '=', 'sesiones.historial_id')
                        // ->where('pacientes.estado','=','ACTIVO')
                        ->where('empleados.id','=',$usr_sesion->id)
                        ->where(function ($query) use ($texto){
                            $query->where('pacientes.ci', 'LIKE', '%'.$texto.'%')
                                ->orWhere(DB::raw("concat(pacientes.aPaterno,' ',pacientes.aMaterno,' ',pacientes.nombre)"), 'LIKE', '%'.$texto.'%');
                            })
                        ->orderBy('sesiones.fecha_ini', 'asc') //ver i se puede cambiar a hora mas F
                        ->paginate(10);

        // $pacientes = DB::table('pacientes')
        //                     ->select('pacientes.id as id_pac', 'pacientes.ci', 'pacientes.aPaterno', 'pacientes.aMaterno', 'pacientes.nombre', 'pacientes.celular', 'historiales.num_sesiones', 'sesiones.id', 'historiales.id')
        //                     ->join('ordenes', 'pacientes.id', '=', 'ordenes.paciente_id')
        //                     ->join('empleados', 'ordenes.empleado_id', '=', 'empleados.id')
        //                     ->join('historiales', 'ordenes.id', '=', 'historiales.orden_id')
        //                     ->join('sesiones', 'historiales.id', '=', 'sesiones.historial_id')
        //                     ->where('pacientes.estado','=','ACTIVO')
        //                     ->where('empleados.id','=',$usr_sesion->id)
        //                     ->where('sesiones.fecha_ini','=',Carbon::now()->toDateString())
        //                     ->orderBy('sesiones.fecha_ini', 'asc') //ver i se puede cambiar a hora mas F
        //                     ->paginate(10);     //CANTIDAD DE REGISTROS EN LISTA
        $datos= array(
            'contador' => $contador,
            'usr_sesion' => $usr_sesion,
            'pacientes' => $pacientes,
            'texto' => $texto,
        );
        // return $pacientes;
        return view('informes.informes')->with($datos);
    }

    public function icreate($id)
    {
        //CORREGIRRRR URENTE!!!!!!!!!!!!!!!!
        //usuario de sesion que siemrpe es empleado
        $id_sec = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sec)->first();
        
        //datos del paciente
        $pacientes = Paciente::find($id);
        $usuarios = DB::table('users')->where('id', '=', $pacientes->user_id)->first();
        $departamentos = DB::table('departamentos')->where('id', '=', $pacientes->departamento_id)->first();
        $turnos = DB::table('turnos')->where('id', '=', $pacientes->turno_id)->first();
        $roles = DB::table('roles')->where('id', '=', $usuarios->rol_id)->first();
                          
        if(auth()->user()->rol_id == 3){
            $ordenes = Orden::where('ordenes.paciente_id',$id)
                            ->orderBy('ordenes.id', 'desc')
                        ->get();
            $cont = 0;
            $idhisto = 0;
            foreach($ordenes as $orden){
                if($cont == 1){
                    $idhisto=$orden->id;
                }
                $cont=$cont+1;
            }
            $historiales = Historial::where('historiales.orden_id',$idhisto)
            // $historiales = Historial::where('historiales.orden_id',22)
                    ->orderBy('historiales.id', 'desc')
                                ->first();
        }else{
            $ordenes = Orden::where('ordenes.paciente_id',$id)
                            ->orderBy('ordenes.id', 'desc')
                        ->get();
                        $cont = 0;
            $idhistos = 0;
            foreach($ordenes as $orden){
                if($cont == 0){
                    $idhisto=$orden->id;
                }
            }
           
            $historiales = Historial::where('historiales.orden_id',$idhisto) 
            // $historiales = Historial::where('historiales.orden_id',22)
                    ->orderBy('historiales.id', 'desc')
                                ->first();
                             
        }
        
        $rol= DB::table('users')->where('id', '=', $id_sec)->first();
        
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'pacientes' => $pacientes,
            'usuarios' => $usuarios,
            'departamentos' => $departamentos,
            'turnos' => $turnos,
            'roles' => $roles,
            'ordenes' => $ordenes,
            'historiales' => $historiales,
            'id' => $id,
            'rol' => $rol,
        );
        return view('informes.informe_registro')->with($datos);
    }

    public function infostore(Request $request)
    {
        //registro de la orden
        $informe = new Informe();
        // $informe->id = 1;
        $informe->evolucion = $request->evolucion;
        $informe->recomendacion = $request->recomendacion;
        $informe->conclusion = $request->conclusion;
        $informe->historial_id = $request->historial_id;
        $informe->empleado_id = $request->empleado_id;
        $informe->paciente_id = $request->paciente_id;
        
        //usuario logeado
        $id = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id)->first();

        $informe->creacion_usuario = $usr_sesion->aPaterno.' ' .$usr_sesion->aMaterno.' '.$usr_sesion->nombre;
        //$informe->created_at = Carbon::now(); -------------------DESCOMENTAR EN DESARROLO
        $informe->save();

        //mandar ha hstorial para qe luego se aña la cita
        return Redirect::to('/citasF');
    }

    public function invesindex(Request $request)
    {
        $hoy= Orden::where('fecha', Carbon::now()->toDateString())->count();
        $alta = DB::table('pacientes')->where('estado', '=' ,'ALTA')->count();
        $activos = DB::table('pacientes')->where('estado', '=' ,'ACTIVO')->count();
        $total = DB::table('pacientes')->count();
        $texto = trim($request->get('texto'));
        $id=auth()->user()->id;
        $usr_sesion= DB::table('empleados')->where('user_id', '=', $id)->first();
        $pacientes = DB::table('historiales')
                            ->select('historiales.id', 'historiales.diagnostico_kin', 'pacientes.aPaterno', 'pacientes.aMaterno', 'pacientes.nombre', 'pacientes.celular', 'pacientes.fechaNacimiento')
                            ->join('ordenes', 'ordenes.id', '=', 'historiales.orden_id')
                            ->join('pacientes', 'pacientes.id', '=', 'ordenes.paciente_id')
                            ->where('historiales.diagnostico_kin', 'LIKE', '%'.$texto.'%')
                            ->orderBy('historiales.id', 'desc')
                            ->paginate(50);     //CANTIDAD DE REGISTROS EN LISTA

        $datos= array(
            'hoy' => $hoy,
            'alta' => $alta,
            'activos' => $activos,
            'total' => $total,
            'usr_sesion' => $usr_sesion,
            'pacientes' => $pacientes,
            'texto' => $texto,
        );
        return view('investigaciones.investigacion')->with($datos);
    }

    public function inshow($id)
    {
        //usuario de sesion que siemrpe es empleado
        $id_sec = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sec)->first();
        //diagnostico de referencia
        //datos del paciente
        $historiales = Historial::find($id);
        $ordenes = Orden::find($historiales->orden_id);
        $pacientes = Paciente::find($ordenes->paciente_id);
        $usuarios = DB::table('users')->where('id', '=', $pacientes->user_id)->first();
        $departamentos = DB::table('departamentos')->where('id', '=', $pacientes->departamento_id)->first();
        $turnos = DB::table('turnos')->where('id', '=', $pacientes->turno_id)->first();
        $roles = DB::table('roles')->where('id', '=', $usuarios->rol_id)->first();

        $informes = DB::table('informes')
                        ->select('informes.evolucion', 'informes.recomendacion', 'informes.conclusion', 'informes.creacion_usuario')
                        ->join('pacientes', 'pacientes.id', '=', 'informes.paciente_id')
                        ->join('historiales', 'historiales.id', '=', 'informes.historial_id')
                        ->where('informes.paciente_id', '=', $pacientes->id)
                        ->where('informes.historial_id', '=', $historiales->id)
                        ->get();
        $cont = 0; 

    // return $sesionestra;
        // WHERE sesionestratamientos.sesion_id=56 AND sesiones.paciente_id=6;
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'historiales' => $historiales,
            'ordenes' => $ordenes,
            'pacientes' => $pacientes,
            'usuarios' => $usuarios,
            'departamentos' => $departamentos,
            'turnos' => $turnos,
            'roles' => $roles,
            'id' => $id,
            'informes' => $informes,
            'cont' => $cont,
        );
        return view('informes.show')->with($datos);
    }

}
