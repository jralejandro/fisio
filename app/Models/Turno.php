<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    //
    protected $table = 'turnos';
    public function empleados()
    {
        return $this->hasMany('App\Models\Empleado');
    }

    public function ordenes()
    {
        return $this->hasMany('App\Models\Orden');
    }

    public function sesiones()
    {
        return $this->hasMany('App\Models\Sesion');
    }

    public function horas()
    {
        return $this->hasMany('App\Models\Hora');
    }
}
