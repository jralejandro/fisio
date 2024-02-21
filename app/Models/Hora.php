<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    protected $table = 'horas';

    public function turnos()
    {
        return $this->belongsTo('App\Models\Turno');
    }

    public function roles()
    {
        return $this->belongsTo('App\Models\Rol');
    }

    public function sesiones()
    {
        return $this->hasMany('App\Models\Sesion');
    } 

    public function ordenes()
    {
        return $this->hasMany('App\Models\Orden');
    }
}
