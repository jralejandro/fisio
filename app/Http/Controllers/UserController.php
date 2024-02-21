<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Departamento;
use App\Models\Turno;
use App\Models\Rol;
use App\Models\Empleado;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
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
        $texto = trim($request->get('texto'));
        // $usuario = DB::table('empleados')->select();
        $id=auth()->user()->id;
        $usr_sesion= DB::table('empleados')->where('user_id', '=', $id)->first();
        $empleados = DB::table('empleados')
                            ->select('empleados.id', 'empleados.ci', 'empleados.aPaterno', 'empleados.aMaterno', 'empleados.nombre', 'empleados.celular', 'empleados.fechaNacimiento','users.estado')
                            ->join('users', 'empleados.user_id', '=', 'users.id')
                            ->where('empleados.ci', 'LIKE', '%'.$texto.'%')
                            // ->orWhere('empleados.nombre', 'LIKE', '%'.$texto.'%')
                            ->orWhere(DB::raw("concat(empleados.aPaterno,' ',empleados.aMaterno,' ',empleados.nombre)"), 'LIKE', '%'.$texto.'%')
                            ->orderBy('empleados.aPaterno', 'asc')
                            ->paginate(10);  
        $activo=DB::table('empleados')->join('users', 'empleados.user_id', '=', 'users.id')
        ->where('users.estado', '=' ,'ACTIVO')
        ->count();
        $inactivo=DB::table('empleados')->join('users', 'empleados.user_id', '=', 'users.id')
        ->where('users.estado', '=' ,'INACTIVO')
        ->count();
        $total=DB::table('empleados')->count();
// return $total;
        $datos= array(
            'usr_sesion' => $usr_sesion,
            'empleados' => $empleados,
            'texto' => $texto,
            'activo' => $activo,
            'inactivo' => $inactivo,
            'total' => $total,
        );
        return view('usuarios.usuario')->with($datos);
        //return view('usuarios.usuario', compact('emple','empleados', 'texto','usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id)->first();
        $usuarios = DB::table('users')->where('id', '=', $usr_sesion->user_id)->first();
        $departamentos = Departamento::All();
        $turnos = Turno::All();
        $roles = Rol::All();
        $registro = "registro";
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'usuarios' => $usuarios,
            'departamentos' => $departamentos,
            'turnos' => $turnos,
            'registro' => $registro,
            'roles' => $roles,
        );
        return view('usuarios.usuario_registro')->with($datos);
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
        $usuarios->rol_id=$request->rol_id;
        //creador
        $id = auth()->user()->id;
        $creador = DB::table('empleados')->where('user_id', '=', $id)->first();
        $usuarios->creacion_usuario = Str::upper($creador->aPaterno.' ' .$creador->aMaterno.' '.$creador->nombre);
        $usuarios->created_at = Carbon::now();
        $usuarios->save();
        //Empleado que se creara
        $empleado = new Empleado();
        $empleado->ci = $request->ci;
        $empleado->departamento_id = $request->departamento_id;
        $empleado->aPaterno = Str::upper($request->aPaterno);
        $empleado->aMaterno = Str::upper($request->aMaterno);
        $empleado->nombre = Str::upper($request->nombre);
        $empleado->grado_academico = $request->grado_academico;
        $empleado->genero = $request->genero;
        $empleado->fechaNacimiento = $request->fechaNacimiento;
        $empleado->direccion = Str::upper($request->direccion);
        $empleado->telefono = $request->telefono;
        $empleado->celular = $request->celular;
        
        $usuario_id = User::where('usuario', '=', $user)->first();
        $empleado->user_id = $usuario_id->id;
        $empleado->turno_id = $request->turno_id;
        $empleado->creacion_usuario = Str::upper($creador->aPaterno.' '.$creador->aMaterno.' '.$creador->nombre);
        $empleado->created_at = Carbon::now();
        $empleado->save();
        // return $creador;
        //Flash::success('El empleado ' . $empleado->nombre . ' ' . $empleado->aPaterno . ' ' . $empleado->aMaterno . ' se creo con exito.');
        return redirect('/usuarios');
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
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sesion)->first();
        
        $empleados = Empleado::find($id);
        $usuarios = DB::table('users')->where('id', '=', $empleados->user_id)->first();
        $departamentos = DB::table('departamentos')->where('id', '=', $empleados->departamento_id)->first();
        $turnos = DB::table('turnos')->where('id', '=', $empleados->turno_id)->first();
        $roles = DB::table('roles')->where('id', '=', $usuarios->rol_id)->first();
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'empleados' => $empleados,
            'usuarios' => $usuarios,
            'departamentos' => $departamentos,
            'turnos' => $turnos,
            'roles' => $roles,
        );
        return view('usuarios.usuario_datos')->with($datos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_sesion = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $id_sesion)->first();
        
        $empleados=Empleado::find($id);
        $usuarios=User::find($empleados->user_id);
        $departamentos = Departamento::All();
        $turnos = Turno::All();
        $roles = Rol::All();
        $datos = array(
            'usr_sesion' => $usr_sesion,
            'empleados' => $empleados,
            'usuarios' => $usuarios,
            'departamentos' => $departamentos,
            'turnos' => $turnos,
            'roles' => $roles,
        );
        return view('usuarios.usuario_editar')->with($datos);
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
        //empleado a ser modificado
        $empleado=Empleado::find($request->id);
        if (auth()->user()->rol_id==2 OR  auth()->user()->rol_id==1 ){
            $empleado->ci = $request->ci;
            $empleado->departamento_id = $request->departamento_id;
            $empleado->aPaterno = Str::upper($request->aPaterno);
            $empleado->aMaterno = Str::upper($request->aMaterno);
            $empleado->nombre = Str::upper($request->nombre);
            $empleado->grado_academico = $request->grado_academico; 
            $empleado->turno_id = $request->turno_id;
        }
        $empleado->genero = $request->genero;
        $empleado->fechaNacimiento = $request->fechaNacimiento;
        $empleado->direccion = Str::upper($request->direccion);
        $empleado->telefono = $request->telefono;
        $empleado->celular = $request->celular;
        $empleado->modificacion_usuario = Str::upper($usr_sesion->aPaterno.' '.$usr_sesion->aMaterno.' '.$usr_sesion->nombre);
        $empleado->updated_at = Carbon::now();
        $empleado->save();

        $estado = $request->customSwitch3;

        //tabla usuario del empleado
        $usuario_emp = User::where('id', '=', $empleado->user_id)->first();
        $usuario_emp->email = $request->email;
        if($estado == 'on')
        {            
            $usuario_emp->password = bcrypt($request->password);            
        }
        if (auth()->user()->rol_id==2 OR  auth()->user()->rol_id==1 ){
            $usuario_emp->rol_id = $request->rol_id;
        }
        $usuario_emp->modificacion_usuario = $usr_sesion->aPaterno.' '.$usr_sesion->aMaterno.' '.$usr_sesion->nombre;
        $usuario_emp->updated_at = Carbon::now();
        $usuario_emp->save();   
        if (auth()->user()->rol_id==2 OR  auth()->user()->rol_id==1 ){
            return redirect('/usuarios');
        }else{
            return Redirect::to('usuarios/' .$request->id. '/show');
        } 
    }
    
    public function inactivo($id)
    {
        //usuario logeado
        $iduser = auth()->user()->id;
        $usr_sesion = DB::table('empleados')->where('user_id', '=', $iduser)->first();
        //empleado a ser modificado
        $empleado=Empleado::find($id);
        $usuario = User::where('id', '=', $empleado->user_id)->first();
        if ($usuario->estado == "ACTIVO") {
            $usuario->estado = "INACTIVO";
        } else {
            $usuario->estado = "ACTIVO";
        }
        $usuario->modificacion_usuario = Str::upper($usr_sesion->aPaterno.' '.$usr_sesion->aMaterno.' '.$usr_sesion->nombre);
        $usuario->updated_at = Carbon::now();
        $usuario->save();     
        return redirect('/usuarios');
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
}
