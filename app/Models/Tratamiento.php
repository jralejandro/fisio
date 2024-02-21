<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    //
    protected $table = 'tratamientos';

    public function sesiones() 
    {
        return $this->belongsToMany('App\Models\Sesion','sesionesTratamientos', 'sesion_id', 'tratamiento_id')->withPivot('detalle')->withTimestamps();
        // return $this->belongsToMany('App\Curso','curso_estudiante','curso_id','estudiante_id')->withPivot('fecha_ins', 'estado')->withTimestamps();
    }
}
