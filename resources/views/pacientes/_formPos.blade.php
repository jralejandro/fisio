<input type="hidden" id="id" name="id" value="{{ isset($pacientes) ? $pacientes->id : old('id') }}" class="form-control" placeholder="">
<div class="row">
    <div class="col-sm-4">        
        <div class="form-group">
            <label>Nombres</label>
            <input type="text" style="text-transform: uppercase;" required id="nombre" name="nombre" value="{{ isset($pacientes) ? $pacientes->nombre : old('nombre') }}" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Apellido Paterno</label>
            <input type="text" style="text-transform: uppercase;" id="aPaterno" name="aPaterno" value="{{ isset($pacientes) ? $pacientes->aPaterno : old('aPaterno') }}" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Apellido Materno</label>
            <input type="text" style="text-transform: uppercase;" id="aMaterno" name="aMaterno" value="{{ isset($pacientes) ? $pacientes->aMaterno : old('aMaterno') }}" class="form-control" placeholder="">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">        
        <div class="form-group">
            <label>N° de Documento</label>
            <input type="text" required id="ci" name="ci" value="{{ isset($pacientes) ? $pacientes->ci : old('ci') }}" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-sm-1">        
        <div class="form-group">
            <label>Extención</label>
            @if (isset($pacientes))
                <select id="departamento_id" name="departamento_id" class="form-control input-sm">
                    @foreach ($departamentos as $departamento)
                        @if ($pacientes->departamento_id == $departamento->id)
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
        </div>
    </div>
    <div class="col-sm-4">        
        <div class="form-group">
            <label>Fecha Nacimiento</label>
            <input type="date" id="fechaNacimiento" value="{{ isset($pacientes) ? $pacientes->fechaNacimiento : old('fechaNacimiento') }}" name="fechaNacimiento" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Genero</label>
            @if (isset($pacientes))
                <select id="genero" name="genero" class="form-control input-sm">
                @if ($pacientes->genero == "M")
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
            <input type="number" id="celular" name="celular" value="{{ isset($pacientes) ? $pacientes->celular : old('celular') }}" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Telefono</label>
            <input type="number" id="telefono" name="telefono" value="{{ isset($pacientes) ? $pacientes->telefono : old('telefono') }}" class="form-control" placeholder="">
        </div>
    </div>
</div>

<div class="row">    
    <div class="col-sm-6">        
        <div class="form-group">
            <label>Dirección</label>
            <input type="text" style="text-transform: uppercase;" required id="direccion" name="direccion" value="{{ isset($pacientes) ? $pacientes->direccion : old('direccion') }}" class="form-control" placeholder="">
        </div>
    </div>
</div>
    
<div class="row">    
    <div class="col-sm-12">
        <div class="form-group">
            @if (isset($usuarios))
                <label>USUARIO:  </label> {{ $usuarios->usuario}} o puede ingresar con su <label>CORREO: </label> {{ $usuarios->email}}
                
                <div class="form-group">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customSwitch3" onchange="javascript:showContent()">
                      <label class="custom-control-label" for="customSwitch3">Cambiar contraseña</label>
                    </div>
                </div>
                <div id="cambio_contraseña" style="display: none;">
                    <div class="row">
                        <div class="col-sm-2">
                            <label>Contraseña nueva</label>
                        </div>
                        <div class="col-sm-4">
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
                
            @else
                <label>NOTA: </label> Usuario sera su inicial de apellido paterno, apellido materno y su numero de carnet. O puede ingresar con su correo<br>
                <label>EJEMPLO:</label> Luna Perez Tola CI. 2233115<BR>
                <label>USUARIO:</label> PT2233115
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