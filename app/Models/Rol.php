<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    //
    protected $table = 'roles';
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function horas()
    {
        return $this->hasMany('App\Models\Hora');
    }
}
