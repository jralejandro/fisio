<div class="row">
    <div class="col-sm-6">
        @if ($cont > 0)
            <div class="form-group">
                @foreach ($tratamientos as $tratamiento)
                    @foreach ($sesionestra as $sestra)
                    {{-- {{$tratamiento->id.'='.$sestra->tratamiento_id}} --}}
                        @if($tratamiento->id == $sestra->tratamiento_id)
                        <?php $s = $s+1 ?>
                            <div class="checkbox">
                                <label><input type="checkbox" id='trat_{{$tratamiento->id}}' name='trat_{{$tratamiento->id}}' value="{{$tratamiento->id}}" checked> {{ $tratamiento->tratamiento}}</label>   
                                <textarea rows="4" id='detalle_{{$tratamiento->id}}' name='detalle_{{$tratamiento->id}}' class="form-control" placeholder="">{{ $sestra->detalle}}</textarea>                                    
                            </div>
                        @endif
                    @endforeach                    
                    @if ( $s == 0 )
                        <div class="checkbox">
                            <label><input type="checkbox" id='trat_{{$tratamiento->id}}' name='trat_{{$tratamiento->id}}' value="{{$tratamiento->id}}"> {{ $tratamiento->tratamiento}}</label>   
                            <textarea rows="4" id='detalle_{{$tratamiento->id}}' name='detalle_{{$tratamiento->id}}' class="form-control" placeholder=""></textarea>                                    
                        </div>  
                    @endif
                    <?php $s=0 ?>
                @endforeach
            </div> 
        @else
            <div class="form-group">
                @foreach ($tratamientos as $tratamiento)
                    <div class="checkbox">
                        <label><input type="checkbox" id='trat_{{$tratamiento->id}}' name='trat_{{$tratamiento->id}}' value="{{$tratamiento->id}}"> {{ $tratamiento->tratamiento}}</label>   
                        <textarea rows="4" id='detalle_{{$tratamiento->id}}' name='detalle_{{$tratamiento->id}}' class="form-control" placeholder=""></textarea>                                    
                    </div>
                @endforeach
            </div>  
        @endif  
        <input type="hidden" id="ses_id" name="ses_id" value="{{$sesiones->id}}" class="form-control" placeholder="">
            <label>OBSERVACIÓN</label>
            <input type="text" id="observacion" name="observacion" value="" class="form-control" placeholder="">                  
    </div>
    <div class="col-ms-6">
        <a href="{{ route('sesiones.svaciar', $sesiones->id) }}"  class="btn btn-danger" title="Asistio"><i class="fas fa-trash" style="width: 12px"></i> BORRAR</a>
    </div>
</div>

