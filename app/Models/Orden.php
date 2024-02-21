<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orden extends Model
{
    //
    protected $table = 'ordenes';
    public function turnos()
    {
        return $this->belongsTo('App\Models\Turno');
    }

    public function empleados()
    {
        return $this->belongsTo('App\Models\Empleado');
    }

    public function pacientes()
    {
        return $this->belongsTo('App\Models\Paciente');
    }

    public function historiales()
    {
        return $this->hasMany('App\Models\Historial');
    }

    public function horas()
    {
        return $this->belongsTo('App\Models\Hora');
    }
}
