<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    //
    protected $table = 'sesiones';
    public function turnos()
    {
        return $this->belongsTo('App\Models\Turno');
    }

    public function historiales()
    {
        return $this->belongsTo('App\Models\Historial');
    }
    
    public function tratamientos() 
    {
        // return $this->belongsToMany('App\Models\Tratamiento');
        return $this->belongsToMany('App\Models\Sesion','sesionesTratamientos', 'sesion_id', 'tratamiento_id')->withPivot('detalle')->withTimestamps();
    }

    public function horas()
    {
        return $this->belongsTo('App\Models\Hora');
    }
//aumentado el  9 
    public function empleados()
    {
        return $this->belongsTo('App\Models\Empleado');
    }

    public function pacientes()
    {
        return $this->belongsTo('App\Models\Paciente');
    }
}
