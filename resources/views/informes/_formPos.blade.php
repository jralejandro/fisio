
<input type="hidden" id="paciente_id" name="paciente_id" value="{{ $pacientes->id }}" class="form-control" placeholder="">
    <input type="hidden" id="empleado_id" name="empleado_id" value="{{$usr_sesion->id}}" class="form-control" placeholder="">  
<input type="hidden" id="historial_id" name="historial_id" value="{{$historiales->id}}" class="form-control" placeholder=""> 
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>NÚMERO DE SESIONES: </label>
            {{ $historiales->num_sesiones }} 
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>TRATAMIENTO: </label>
            {{ $historiales->tratamiento }} 
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>DIAGNOSTICO: </label>
            {{ $historiales->diagnostico_kin }} 
        </div>
    </div>
</div>      
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>EVALUACIÓN</label>
            @if (isset($informes))
                <textarea rows="6" id="evolucion" name="evolucion" class="form-control" placeholder="">{{ $informes->evolucion}}</textarea>
            @else
                <textarea rows="6" id="evolucion" name="evolucion" class="form-control" placeholder=""></textarea>
            @endif           
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>RECOMENTACIÓN</label>
            @if (isset($informes))
                <textarea rows="6" id="recomendacion" name="recomendacion" class="form-control" placeholder="">{{ $informes->recomendacion}}</textarea>
            @else
                <textarea rows="6" id="recomendacion" name="recomendacion" class="form-control" placeholder=""></textarea>
            @endif 
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>CONCLUSIÓN </label>
            @if (isset($informes))
                <textarea rows="6" id="conclusion" name="conclusion" class="form-control" placeholder="">{{ $informes->conclusions }}</textarea>
            @else
                <textarea rows="6" id="conclusion" name="conclusion" class="form-control" placeholder=""></textarea>
            @endif
        </div>
    </div>
</div>