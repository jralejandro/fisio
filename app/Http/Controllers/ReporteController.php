<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Rol;
use App\Models\Turno;
use App\Models\Orden;
use App\Models\Historial;
use App\Models\Empleado;
use App\Models\Paciente;
use App\Models\Sesion;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
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
                            ->orWhere('empleados.nombre', 'LIKE', '%'.$texto.'%')
                            ->orderBy('empleados.aPaterno', 'asc')
                            ->paginate(10);  
        $datos= array(
            'usr_sesion' => $usr_sesion,
            'empleados' => $empleados,
            'texto' => $texto,
        );
        return view('reportes.reporte')->with($datos);
        //return view('usuarios.usuario', compact('emple','empleados', 'texto','usuarios'));
    }

    //Lista de Personal
    public function pdfPersonal()
    {
        $fecha_actual = Carbon::now();
        $year = $fecha_actual->format('Y');
        $titulo_ventana = "Lista de Empleados";
        $fecha_impresion = $fecha_actual->format('d-m-Y').' ['.$fecha_actual->toTimeString().']';
        $titulo = "LISTA DEL PERSONAL";
        $nombrepdf = "Lista_Personal_".$fecha_actual->format('d-m-Y').".pdf";
        $j = 0;

        $empleados = DB::table('empleados')
                            ->select('empleados.ci', 'empleados.aPaterno', 'empleados.aMaterno', 'empleados.nombre', 'empleados.celular', 'empleados.telefono', 'users.rol_id', 'empleados.turno_id')
                            ->join('users', 'empleados.user_id', '=', 'users.id')
                            ->where('users.estado', '=', 'ACTIVO')
                            ->get();
        $roles = Rol::all();
        $turnos = Turno::all();
        // $test = $fecha_impresion;
        $footer ="Gabinete de Fisioterapia Isaac Duchen - ". $year;

        return \PDF::loadView(
            'reportes.listaPersonal',
            compact(
                'titulo_ventana',
                'fecha_impresion',
                'titulo',
                'j',
                'empleados',
                'roles',
                'turnos'
            )
        )
            ->setPaper('letter')
            ->setOption('encoding', 'utf-8')
            ->setOption('footer-right', 'Pagina [page] de [toPage]')
            ->setOption('footer-left', $footer)
            ->stream($nombrepdf);
    }
//id es del historial
    public function pdfPacienteHistorico($id)
    {
        $fecha_actual = Carbon::now();
        $year = $fecha_actual->format('Y');
        $titulo_ventana = "Hitoria Clinica";
        $fecha_impresion = $fecha_actual->format('d-m-Y').' ['.$fecha_actual->toTimeString().']';
       
        //Consulta del Historial
        $historial = Historial::find($id);

        //Consulta de la Orden
        $orden = Orden::find($historial->orden_id);

        //Consulta del Personal que atendio con esa Orden
        $personal = Empleado::find($orden->empleado_id);


        if( $personal->grado_academico == "Dra." || $personal->grado_academico == "Dr." ){
            $titulo = "HISTORIA CLINICA";
        }else{
            $titulo = "HISTORIA CLINICA KINESICA";
        }
        //Consulta del Paciente con esa Orden
        $paciente = Paciente::find($orden->paciente_id);

        //Edad del Paciente
        $edad_paciente = Carbon::parse($paciente->fechaNacimiento)->age;

        
        $nom = $paciente->aPaterno."_".$paciente->aMaterno."_".$paciente->nombre;
        $nombrepdf = "Historico_".$nom."_".$fecha_actual->format('d-m-Y').".pdf";
        $footer ="Gabinete de Fisioterapia Isaac Duchen - ". $year;

        // return $edad_paciente;

        return \PDF::loadView(
            'reportes.historialOrdenPaciente',
            compact(
                'titulo_ventana',
                'fecha_impresion',
                'titulo',
                'orden',
                'historial',
                'personal',
                'paciente',
                'edad_paciente'
            )
        )
            ->setPaper('letter')
            ->setOption('encoding', 'utf-8')
            ->setOption('footer-right', 'Pagina [page] de [toPage]')
            ->setOption('footer-left', $footer)
            ->stream($nombrepdf);
    }

    public function pdfCitas($id)
    {
        $fecha_actual = Carbon::now();
        $year = $fecha_actual->format('Y');
        $fecha = Carbon::now()->isoFormat('D \d\e MMMM \d\e\l Y');        
        $titulo_ventana = "Citas Medicas";
        $fecha_impresion = $fecha_actual->format('d-m-Y').' ['.$fecha_actual->toTimeString().']';
        $titulo = "CITAS MEDICAS";
        //Consulta del Historial
        $historial = Historial::find($id);

        //Consulta de la Orden
        $orden = Orden::find($historial->orden_id);

        //Consulta del Personal que atendio con esa Orden
        $personal = Empleado::find($orden->empleado_id);

        //Consulta del Paciente con esa Orden
        $paciente = Paciente::find($orden->paciente_id);
        //Edad del Paciente
        $edad_paciente = Carbon::parse($paciente->fechaNacimiento)->age;

        //Consulta de las Sesiones
        $sesion = DB::table('sesiones')
                            ->select('sesiones.id','sesiones.fecha_ini', 'sesiones.hora_id', 'horas.hora', 'empleados.grado_academico', 'empleados.nombre', 'empleados.aPaterno', 'empleados.aMaterno')
                            ->join('horas', 'sesiones.hora_id', '=', 'horas.id')
                            ->join('pacientes', 'sesiones.paciente_id', '=', 'pacientes.id')
                            ->join('empleados', 'sesiones.empleado_id', '=', 'empleados.id')
                            ->where('pacientes.id','=',$paciente->id)
                            ->get();
        // $sesion = DB:: Sesion::where('historial_id', $historial->id)->get();

        $nom = $paciente->aPaterno."".$paciente->aMaterno."".$paciente->nombre;
        $nombrepdf = "Citas_Medicas_".$nom."_".$fecha_actual->format('d-m-Y').".pdf";        
        $j = 0;

        $footer ="Gabinete de Fisioterapia Isaac Duchen - ". $year;

        return \PDF::loadView(
            'reportes.citasMedicas',
            compact(
                'titulo_ventana',
                'fecha',
                'fecha_impresion',
                'titulo',                
                'historial',
                'orden',
                'personal',
                'paciente',
                'sesion',
                'j',
                'edad_paciente'
            )
        )
            ->setPaper('letter')
            ->setOption('encoding', 'utf-8')
            ->setOption('footer-right', 'Pagina [page] de [toPage]')
            ->setOption('footer-left', $footer)
            ->stream($nombrepdf);
    }
}
