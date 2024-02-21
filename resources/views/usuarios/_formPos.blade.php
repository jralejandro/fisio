<input type="hidden" id="id" name="id" value="{{ isset($empleados) ? $empleados->id : old('id') }}" class="form-control" placeholder="">
<div class="row">
    <div class="col-sm-4">        
        <div class="form-group">
            <label>Nombres</label>
            @if ( $usuarios->id <> Auth::user()->id OR Auth::user()->rol_id==2 OR  Auth::user()->rol_id==1 )
                <input type="text" style="text-transform: uppercase;" required id="nombre" name="nombre" value="{{ isset($empleados) ? $empleados->nombre : old('nombre') }}" class="form-control" placeholder="">
            @else
                <input type="text" style="text-transform: uppercase;" required id="nombre" name="nombre" value="{{ isset($empleados) ? $empleados->nombre : old('nombre') }}" class="form-control" placeholder="" disabled>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Apellido Paterno</label>
            @if ( $usuarios->id <> Auth::user()->id OR Auth::user()->rol_id==2 OR  Auth::user()->rol_id==1 )
                <input type="text" style="text-transform: uppercase;" id="aPaterno" name="aPaterno" value="{{ isset($empleados) ? $empleados->aPaterno : old('aPaterno') }}" class="form-control" placeholder="">
            @else
                <input type="text" style="text-transform: uppercase;" id="aPaterno" name="aPaterno" value="{{ isset($empleados) ? $empleados->aPaterno : old('aPaterno') }}" class="form-control" placeholder="" disabled>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Apellido Materno</label>
            @if ( $usuarios->id <> Auth::user()->id OR Auth::user()->rol_id==2 OR  Auth::user()->rol_id==1 )
                <input type="text" style="text-transform: uppercase;" id="aMaterno" name="aMaterno" value="{{ isset($empleados) ? $empleados->aMaterno : old('aMaterno') }}" class="form-control" placeholder="">
            @else
                <input type="text" style="text-transform: uppercase;" id="aMaterno" name="aMaterno" value="{{ isset($empleados) ? $empleados->aMaterno : old('aMaterno') }}" class="form-control" placeholder="" disabled>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">        
        <div class="form-group">
            <label>N° de Documento</label>
            @if ( $usuarios->id <> Auth::user()->id OR Auth::user()->rol_id==2 OR  Auth::user()->rol_id==1 )
                <input type="text"  required id="ci" name="ci" value="{{ isset($empleados) ? $empleados->ci : old('ci') }}" class="form-control" placeholder="">
            @else
                <input type="text"  required id="ci" name="ci" value="{{ isset($empleados) ? $empleados->ci : old('ci') }}" class="form-control" placeholder="" disabled>
            @endif
        </div>
    </div>
    <div class="col-sm-2">        
        <div class="form-group">
            <label>Extención</label>
            @if ( $usuarios->id <> Auth::user()->id OR Auth::user()->rol_id==2 OR  Auth::user()->rol_id==1 )
                @if (isset($empleados))
                    <select id="departamento_id" name="departamento_id" class="form-control input-sm">
                        @foreach ($departamentos as $departamento)
                            @if ($empleados->departamento_id == $departamento->id)
                                <option value="{{ $departamento->id }}" selected>{{ $departamento->abreviatura }}</option> 
                            @else
                                <option value="{{ $departamento->id }}">{{ $departamento->abreviatura }}</option> 
                            @endif
                        @endforeach
                    </select>
                @else
                    <select id="departamento_id" name="departamento_id" class="form-control input-sm">
                        @foreach ($departamentos as $departamento)                    
                            <option value="{{ $departamento->id }}">{{ $departamento->abreviatura }}</option>                     
                        @endforeach
                    </select>
                @endif        
            @else
            <select id="departamento_id" name="departamento_id" class="form-control input-sm" disabled>
                @foreach ($departamentos as $departamento)
                    @if ($empleados->departamento_id == $departamento->id)
                        <option value="{{ $departamento->id }}" selected >{{ $departamento->abreviatura }}</option> 
                    @endif
                @endforeach
            </select>
            @endif
        </div>
    </div>
    <div class="col-sm-3">        
        <div class="form-group">
            <label>Fecha Nacimiento</label>
            <input type="date" id="fechaNacimiento" value="{{ isset($empleados) ? $empleados->fechaNacimiento : old('fechaNacimiento') }}" name="fechaNacimiento" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Genero</label>
            @if (isset($empleados))
                <select id="genero" name="genero" class="form-control input-sm">
                @if ($empleados->genero == "M")
                    <option value="M" selected>MASCULINO</option>
                    <option value="F">FEMENINO</option>  
                @else
                    <option value="M">MASCULINO</option>
                    <option value="F" selected>FEMENINO</option> 
                @endif
            </select>
            @else
                <select id="genero" name="genero" class="form-control input-sm">                 
                    <option value="M">MASCULINO</option>
                    <option value="F">FEMENINO</option> 
                </select>
            @endif 
        </div>
    </div>    
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Correo</label>
            <input type="email" id="email" name="email" value="{{ isset($usuarios) ? $usuarios->email : old('email') }}" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Celular</label>
            <input type="number" id="celular" name="celular" value="{{ isset($empleados) ? $empleados->celular : old('celular') }}" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Telefono</label>
            <input type="number" id="telefono" name="telefono" value="{{ isset($empleados) ? $empleados->telefono : old('telefono') }}" class="form-control" placeholder="">
        </div>
    </div>
</div>

<div class="row"> 
    <div class="col-sm-6">        
        <div class="form-group">
            <label>Dirección</label>
            <input type="text" style="text-transform: uppercase;" required id="direccion" name="direccion" value="{{ isset($empleados) ? $empleados->direccion : old('direccion') }}" class="form-control" placeholder="">
        </div>
    </div>   
    @if ( $usuarios->id <> Auth::user()->id OR Auth::user()->rol_id==2 OR  Auth::user()->rol_id==1 )
        <div class="col-sm-2">
            <div class="form-group">
                <label>Rol</label>
                @if (isset($usuarios))
                    <select id="rol_id" name="rol_id" class="form-control input-sm">
                        @foreach ($roles as $rol)
                            @if ($usuarios->rol_id == $rol->id)
                                <option value="{{ $rol->id }}" selected>{{ $rol->rol }}</option> 
                            @else
                                @if ( $rol->rol <> "PACIENTE")
                                    <option value="{{ $rol->id }}">{{ $rol->rol }}</option> 
                                @endif 
                            @endif
                        @endforeach
                    </select>
                @else
                    <select id="rol_id" name="rol_id" class="form-control input-sm">
                        @foreach ($roles as $rol) 
                            @if ( $rol->rol <> "PACIENTE")
                                <option value="{{ $rol->id }}">{{ $rol->rol }}</option>  
                            @endif                   
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label>Grado Académico</label>
                @if (isset($empleados))
                    <select id="grado_academico" name="grado_academico" class="form-control input-sm">
                    @if ($empleados->grado_academico == "Dr.")
                        <option value="Dr." selected>Dr.</option>
                        <option value="Dra.">Dra.</option>
                        <option value="Lic.">Lic.</option>
                        <option value="Int.">Int.</option>
                        <option value="Tec. Sup.">Tec. Sup.</option>
                        <option value="Tec. Med.">Tec. Med.</option>  
                    @else
                        @if ($empleados->grado_academico == "Dra.")
                            <option value="Dr.">Dr.</option>
                            <option value="Dra." selected>Dra.</option>
                            <option value="Lic.">Lic.</option>
                            <option value="Int.">Int.</option>
                            <option value="Tec. Sup.">Tec. Sup.</option>
                            <option value="Tec. Med.">Tec. Med.</option>      
                        @else
                            @if ($empleados->grado_academico == "Lic.")
                                <option value="Dr.">Dr.</option>
                                <option value="Dra.">Dra.</option>
                                <option value="Lic." selected>Lic.</option>
                                <option value="Int.">Int.</option>
                                <option value="Tec. Sup.">Tec. Sup.</option>
                                <option value="Tec. Med.">Tec. Med.</option>      
                            @else
                                @if ($empleados->grado_academico == "Int.")
                                    <option value="Dr.">Dr.</option>
                                    <option value="Dra.">Dra.</option>
                                    <option value="Lic.">Lic.</option>
                                    <option value="Int." selected>Int.</option>
                                    <option value="Tec. Sup.">Tec. Sup.</option>
                                    <option value="Tec. Med.">Tec. Med.</option>      
                                @else
                                    @if ($empleados->grado_academico == "Tec. Sup.")
                                        <option value="Dr.">Dr.</option>
                                        <option value="Dra.">Dra.</option>
                                        <option value="Lic.">Lic.</option>
                                        <option value="Int.">Int.</option>
                                        <option value="Tec. Sup." selected>Tec. Sup.</option>
                                        <option value="Tec. Med.">Tec. Med.</option>      
                                    @else
                                        <option value="Dr.">Dr.</option>
                                        <option value="Dra.">Dra.</option>
                                        <option value="Lic.">Lic.</option>
                                        <option value="Int.">Int.</option>
                                        <option value="Tec. Sup.">Tec. Sup.</option>
                                        <option value="Tec. Med." selected>Tec. Med.</option> 
                                    @endif 
                                @endif 
                            @endif
                        @endif
                    @endif
                
                </select>
                @else
                    <select id="grado_academico" name="grado_academico" class="form-control input-sm">                 
                        <option value="Dr.">Dr.</option>
                        <option value="Dra.">Dra.</option>
                        <option value="Lic.">Lic.</option>
                        <option value="Int.">Int.</option>
                        <option value="Tec. Sup.">Tec. Sup.</option>
                        <option value="Tec. Med.">Tec. Med.</option>   
                    </select>
                @endif 
            </div>
        </div>    
        <div class="col-sm-2">
            <div class="form-group">
                <label>Turno</label>
                @if (isset($empleados))
                    <select id="turno_id" name="turno_id" class="form-control input-sm">
                        @foreach ($turnos as $turno)
                            @if ($empleados->turno_id == $turno->id)
                                <option value="{{ $turno->id }}" selected>{{ $turno->turno }}</option> 
                            @else
                                <option value="{{ $turno->id }}">{{ $turno->turno }}</option> 
                            @endif
                        @endforeach
                    </select>
                @else
                    <select id="turno_id" name="turno_id" class="form-control input-sm">
                        @foreach ($turnos as $turno)                    
                            <option value="{{ $turno->id }}">{{ $turno->turno }}</option>                     
                        @endforeach
                    </select>
                @endif
            </div>
        </div> 
    @else
        <div class="col-sm-2">
            <div class="form-group">
                <label>Rol</label>
                @if (isset($usuarios))
                    <select id="rol_id" name="rol_id" class="form-control input-sm" disabled>
                        @foreach ($roles as $rol)
                            @if ($usuarios->rol_id == $rol->id)
                                <option value="{{ $rol->id }}" selected>{{ $rol->rol }}</option> 
                            @else
                                @if ( $rol->rol <> "PACIENTE")
                                    <option value="{{ $rol->id }}">{{ $rol->rol }}</option> 
                                @endif 
                            @endif
                        @endforeach
                    </select>
                @else
                    <select id="rol_id" name="rol_id" class="form-control input-sm" disabled>
                        @foreach ($roles as $rol) 
                            @if ( $rol->rol <> "PACIENTE")
                                <option value="{{ $rol->id }}">{{ $rol->rol }}</option>  
                            @endif                   
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label>Grado Académico</label>
                @if (isset($empleados))
                    <select id="grado_academico" name="grado_academico" class="form-control input-sm" disabled>
                    @if ($empleados->grado_academico == "Dr.")
                        <option value="Dr." selected>Dr.</option>
                        <option value="Dra.">Dra.</option>
                        <option value="Lic.">Lic.</option>
                        <option value="Int.">Int.</option>
                        <option value="Tec. Sup.">Tec. Sup.</option>
                        <option value="Tec. Med.">Tec. Med.</option>  
                    @else
                        @if ($empleados->grado_academico == "Dra.")
                            <option value="Dr.">Dr.</option>
                            <option value="Dra." selected>Dra.</option>
                            <option value="Lic.">Lic.</option>
                            <option value="Int.">Int.</option>
                            <option value="Tec. Sup.">Tec. Sup.</option>
                            <option value="Tec. Med.">Tec. Med.</option>      
                        @else
                            @if ($empleados->grado_academico == "Lic.")
                                <option value="Dr.">Dr.</option>
                                <option value="Dra.">Dra.</option>
                                <option value="Lic." selected>Lic.</option>
                                <option value="Int.">Int.</option>
                                <option value="Tec. Sup.">Tec. Sup.</option>
                                <option value="Tec. Med.">Tec. Med.</option>      
                            @else
                                @if ($empleados->grado_academico == "Int.")
                                    <option value="Dr.">Dr.</option>
                                    <option value="Dra.">Dra.</option>
                                    <option value="Lic.">Lic.</option>
                                    <option value="Int." selected>Int.</option>
                                    <option value="Tec. Sup.">Tec. Sup.</option>
                                    <option value="Tec. Med.">Tec. Med.</option>      
                                @else
                                    @if ($empleados->grado_academico == "Tec. Sup.")
                                        <option value="Dr.">Dr.</option>
                                        <option value="Dra.">Dra.</option>
                                        <option value="Lic.">Lic.</option>
                                        <option value="Int.">Int.</option>
                                        <option value="Tec. Sup." selected>Tec. Sup.</option>
                                        <option value="Tec. Med.">Tec. Med.</option>      
                                    @else
                                        <option value="Dr.">Dr.</option>
                                        <option value="Dra.">Dra.</option>
                                        <option value="Lic.">Lic.</option>
                                        <option value="Int.">Int.</option>
                                        <option value="Tec. Sup.">Tec. Sup.</option>
                                        <option value="Tec. Med." selected>Tec. Med.</option> 
                                    @endif 
                                @endif 
                            @endif
                        @endif
                    @endif
                
                </select>
                @else
                    <select id="grado_academico" name="grado_academico" class="form-control input-sm" disabled>                 
                        <option value="Dr.">Dr.</option>
                        <option value="Dra.">Dra.</option>
                        <option value="Lic.">Lic.</option>
                        <option value="Int.">Int.</option>
                        <option value="Tec. Sup.">Tec. Sup.</option>
                        <option value="Tec. Med.">Tec. Med.</option>   
                    </select>
                @endif 
            </div>
        </div>    
        <div class="col-sm-2">
            <div class="form-group">
                <label>Turno</label>
                @if (isset($empleados))
                    <select id="turno_id" name="turno_id" class="form-control input-sm" disabled>
                        @foreach ($turnos as $turno)
                            @if ($empleados->turno_id == $turno->id)
                                <option value="{{ $turno->id }}" selected>{{ $turno->turno }}</option> 
                            @else
                                <option value="{{ $turno->id }}">{{ $turno->turno }}</option> 
                            @endif
                        @endforeach
                    </select>
                @else
                    <select id="turno_id" name="turno_id" class="form-control input-sm" disabled>
                        @foreach ($turnos as $turno)                    
                            <option value="{{ $turno->id }}">{{ $turno->turno }}</option>                     
                        @endforeach
                    </select>
                @endif
            </div>
        </div> 
    @endif
    
</div>    
<div class="row">    
    <div class="col-sm-12">
        <div class="form-group">
            @if (isset($registro))
                <label>NOTA: </label> Usuario sera su inicial de apellido paterno, apellido materno y su numero de carnet.<br>
                <label>EJEMPLO:</label> Luna Perez Tola CI. 2233115<BR>
                <label>USUARIO:</label> PT2233115
            @else
                @if ($usuarios->id == Auth::user()->id or Auth::user()->rol_id==2 OR Auth::user()->rol_id==1)
                    <label>USUARIO:  </label> {{ $usuarios->usuario}}
                    <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input type="checkbox" class="custom-control-input" id="customSwitch3" name="customSwitch3" onchange="javascript:showContent()">
                        <label class="custom-control-label" for="customSwitch3">Cambiar contraseña</label>
                        </div>
                    </div>
                    <div id="cambio_contraseña" style="display: none;">
                        <div class="row">
                            <div class="col-sm-2">
                                <label>Contraseña nueva</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="password" id="password" name="password" class="form-control" placeholder="">
                            </div>
                            {{-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Repita la contraseña</label>
                                    <input type="password" id="contraseñaR" name="contraseñaR" class="form-control" placeholder="">
                                </div>
                            </div> --}}
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
    
</div>

<script>
    function showContent() {
		element = document.getElementById("cambio_contraseña");
		check = document.getElementById("customSwitch3");
		if (check.checked) {
			element.style.display='block';
		}
		else {
			element.style.display='none';
		}
	}
</script>
