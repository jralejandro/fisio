<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    //
    protected $table = 'historiales';

    public function ordenes()
    {
        return $this->belongsTo('App\Models\Orden');
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
