<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    //
    protected $table = 'departamentos';
    public function pacientes()
    {
        return $this->hasMany('App\Models\Paciente');
    }
    public function empleados()
    {
        return $this->hasMany('App\Models\Empleado');
    }
}
