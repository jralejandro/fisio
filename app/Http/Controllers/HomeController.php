<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use App\Models\Rol;
use App\Models\Turno;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id=auth()->user()->id;
        if(auth()->user()->rol_id == 5){
            $usr_sesion= DB::table('pacientes')->where('user_id', '=', $id)->first();
            
        }else{
            $usr_sesion= DB::table('empleados')->where('user_id', '=', $id)->first();
        }
        $datos= array(
            'usr_sesion' => $usr_sesion,
        );
        return Redirect::to('usuarios/' . $id. '/show');
        // return view('layouts.app')->with($datos);
        // $usr_sesion= DB::table('empleados')->where('user_id', '=', $id)->first();
        // $datos= array(
        //     'usr_sesion' => $usr_sesion,
        // );
        // return view('layouts.app')->with($datos);
    }

    //pdf prueba
    public function pdfPrueba()
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
            'welcome',
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
}
