<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('rol');
            $table->string('creacion_usuario')->nullable();
            $table->string('modificacion_usuario')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('departamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('abreviatura');
            $table->string('creacion_usuario')->nullable();
            $table->string('modificacion_usuario')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('turnos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('turno');
            $table->string('creacion_usuario')->nullable();
            $table->string('modificacion_usuario')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique()->nullable();
            $table->string('usuario')->unique();
            $table->string('password');
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->date('fechaRegistro')->nullable();
            $table->bigInteger('rol_id')->unsigned();
            $table->foreign('rol_id')->references('id')->on('roles');
            $table->string('creacion_usuario')->nullable();
            $table->string('modificacion_usuario')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('empleados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ci')->unique(); //identificación del ci
            $table->bigInteger('departamento_id')->unsigned();
            $table->string('aPaterno')->nullable();
            $table->string('aMaterno')->nullable();
            $table->string('nombre');
            $table->string('grado_academico')->nullable();//AUMENTADO EL 16 JUL
            $table->enum('genero', ['M', 'F']);
            $table->date('fechaNacimiento')->nullable(); // poner para fecha de nacimiento
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            //$table->enum('turno', ['MAÑANA', 'TARDE'])->default('MAÑANA');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('turno_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('turno_id')->references('id')->on('turnos');
            $table->foreign('departamento_id')->references('id')->on('departamentos');
            $table->string('creacion_usuario')->nullable();
            $table->string('modificacion_usuario')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('horas', function (Blueprint $table) { //tabla aumentada el 16 de juli
            $table->bigIncrements('id');
            $table->time('hora')->nullable();
            $table->bigInteger('turno_id')->unsigned();
            $table->bigInteger('rol_id')->unsigned();
            $table->foreign('turno_id')->references('id')->on('turnos');
            $table->foreign('rol_id')->references('id')->on('roles');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pacientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ci')->unique(); //identificación del ci
            $table->bigInteger('departamento_id')->unsigned();
            $table->string('aPaterno')->nullable();
            $table->string('aMaterno')->nullable();
            $table->string('nombre');
            $table->enum('genero', ['M', 'F']);
            $table->date('fechaNacimiento')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->enum('estado', ['ACTIVO', 'ALTA']);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('departamento_id')->references('id')->on('departamentos');
            $table->string('creacion_usuario')->nullable();
            $table->string('modificacion_usuario')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
        // tratamiento es de m a n
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('tratamiento');
            $table->string('creacion_usuario')->nullable();
            $table->string('modificacion_usuario')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ordenes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha')->nullable();
            $table->bigInteger('hora_id')->unsigned();
            $table->enum('estado', ['En Espera', 'Atendido', 'Cancelado']); //En espera aumentar
            $table->string('diagnostico_ref')->nullable();
            $table->bigInteger('turno_id')->unsigned();
            $table->foreign('turno_id')->references('id')->on('turnos');            
            $table->bigInteger('empleado_id')->unsigned();
            $table->bigInteger('paciente_id')->unsigned();
            $table->foreign('hora_id')->references('id')->on('horas');
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->string('creacion_usuario')->nullable();
            $table->string('modificacion_usuario')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('historiales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('fechaIngreso')->nullable();
            //$table->string('diagnostico_ref')->nullable();
            $table->string('motivo')->nullable();
            $table->string('his_enfermedad')->nullable();
            $table->string('examen_fis_kin')->nullable();
            $table->string('diagnostico_kin')->nullable();
            $table->string('tratamiento')->nullable();
            $table->string('observaciones')->nullable();
            $table->integer('num_sesiones')->nullable(); 
            $table->bigInteger('orden_id')->unsigned();
            $table->foreign('orden_id')->references('id')->on('ordenes');
            $table->string('creacion_usuario')->nullable();
            $table->string('modificacion_usuario')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sesiones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha_ini')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->bigInteger('hora_id')->unsigned();
            $table->bigInteger('turno_id')->unsigned();
            $table->foreign('turno_id')->references('id')->on('turnos');
            $table->enum('estado', ['Pendiente', 'Asistio', 'No asistio']); 
            $table->string('observacion')->nullable(); //AUMENTADO 16 JULIO
            $table->bigInteger('historial_id')->unsigned();
            $table->bigInteger('empleado_id')->unsigned(); //aumentado el 9 de agosto
            $table->bigInteger('paciente_id')->unsigned();
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('hora_id')->references('id')->on('horas');
            $table->foreign('historial_id')->references('id')->on('historiales');
            $table->string('creacion_usuario')->nullable();
            $table->string('modificacion_usuario')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });        

        Schema::create('sesionesTratamientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sesion_id')->unsigned();
            $table->bigInteger('tratamiento_id')->unsigned();
            $table->foreign('sesion_id')->references('id')->on('sesiones');
            $table->foreign('tratamiento_id')->references('id')->on('tratamientos'); //aumentar dos campos 31/07
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('informes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('evolucion')->nullable();
            $table->string('recomendacion')->nullable();
            $table->string('conclusion')->nullable();
            $table->bigInteger('historial_id')->unsigned();
            $table->bigInteger('empleado_id')->unsigned(); 
            $table->bigInteger('paciente_id')->unsigned();
            $table->foreign('historial_id')->references('id')->on('historiales');
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->string('creacion_usuario')->nullable();
            $table->string('modificacion_usuario')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
        Schema::drop('departamentos');
        Schema::drop('turnos');
        Schema::drop('users');
        Schema::drop('empleados');
        Schema::drop('horas');
        Schema::drop('pacientes');
        Schema::drop('tratamientos');
        Schema::drop('ordenes');
        Schema::drop('historiales');        
        Schema::drop('sesiones');
        Schema::drop('sesionesTratamientos'); //crear modelo
    }
}
