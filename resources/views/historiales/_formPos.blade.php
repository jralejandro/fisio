<input type="hidden" id="id" name="id" value="{{ isset($historiales) ? $historiales->id : old('id') }}" class="form-control" placeholder="">
<label>DIAGNÓSTICO DE REFERENCIA: </label> {{ $orden->diagnostico_ref }}<br>
<input type="hidden" id="orden_id" name="orden_id" value="{{$orden->id}}" class="form-control" placeholder="">  
<div class="row">
    <div class="col-sm-10">
        <div class="form-group">
            <label>MOTIVO DE CONSULTA</label>
            <input type="text" id="motivo" name="motivo" value="{{ isset($historiales) ? $historiales->motivo : old('motivo') }}" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <label>NÚMERO DE SESIONES</label>
            <input type="text" id="num_sesiones" name="num_sesiones" value="{{ isset($historiales) ? $historiales->num_sesiones : old('num_sesion') }}" class="form-control" placeholder="">
        </div>
    </div>
</div>      
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>ENFERMEDAD ACTUAL</label>
            @if (isset($historiales))
                <textarea rows="6" id="his_enfermedad" name="his_enfermedad" class="form-control" placeholder="">{{ $historiales->his_enfermedad}}</textarea>
            @else
                <textarea rows="6" id="his_enfermedad" name="his_enfermedad" class="form-control" placeholder=""></textarea>
            @endif           
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            @if ($rol->rol_id == '3')
                <label>EXAMEN FÍSICO</label>
            @else
                <label>EXAMEN FÍSICO KINÉSICO</label>
            @endif
            @if (isset($historiales))
                <textarea rows="6" id="examen_fis_kin" name="examen_fis_kin" class="form-control" placeholder="">{{ $historiales->examen_fis_kin}}</textarea>
            @else
                <textarea rows="6" id="examen_fis_kin" name="examen_fis_kin" class="form-control" placeholder=""></textarea>
            @endif 
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            @if ($rol->rol_id == '3')
                <label>DIAGNÓSTICO CLÍNICO</label>
            @else
                <label>DIAGNÓSTICO KINÉSICO</label>
            @endif
            @if (isset($historiales))
                <textarea rows="6" id="diagnostico_kin" name="diagnostico_kin" class="form-control" placeholder="">{{ $historiales->diagnostico_kin }}</textarea>
            @else
                <textarea rows="6" id="diagnostico_kin" name="diagnostico_kin" class="form-control" placeholder=""></textarea>
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>TRATAMIENTO</label>
            @if (isset($historiales))
                <textarea rows="6" id="tratamiento" name="tratamiento" class="form-control" placeholder="">{{ $historiales->tratamiento}}</textarea>
            @else
                <textarea rows="6" id="tratamiento" name="tratamiento" class="form-control" placeholder=""></textarea>
            @endif 
        </div>
    </div>
</div>