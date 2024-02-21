<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    //
    protected $table = 'empleados';
    public function departamentos()
    {
        return $this->belongsTo('App\Models\Departamento');
    }

    public function turnos()
    {
        return $this->belongsTo('App\Models\Turno');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function ordenes()
    {
        return $this->hasMany('App\Models\Orden');
    } 

    public function sesiones()
    {
        return $this->hasMany('App\Models\Sesion');
    }

    public function informes()
    {
        return $this->hasMany('App\Models\Informe');
    }   
}
