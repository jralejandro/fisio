<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    public function historiales()
    {
        return $this->belongsTo('App\Models\Historial');
    }
    
    public function empleados()
    {
        return $this->belongsTo('App\Models\Empleado');
    }

    public function pacientes()
    {
        return $this->belongsTo('App\Models\Paciente');
    }
}




