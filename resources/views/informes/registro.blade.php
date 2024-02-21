<div class="card">
    <form action="{{route('informes.infostore')}}" method="POST">
        @csrf
        <div class="card-header">
            <div class="row">
                <div class="col-12">
                    <h4>
                        @if ($rol->rol_id == '3')
                            <i class="fas fa-id-card"></i>Informe Medico
                        @else
                            <i class="fas fa-id-card"></i>Informe Final
                        @endif           
                    </h4>
                </div>                
              </div>           
        </div>
        
        <div class="col-12">
            <div class="invoice p-3 mb-3">
                
                <!-- datos usuario obtenidos de la vista index texto plano row -->
                <div class="row invoice-info">
                    @include('pacientes.index')
                </div>
            </div>
        </div>


        <div class="card-body">
            @include('informes._formPos')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-file btn-success pull-right float-right" style="margin-right: 5px;"><i class="fa fa-save"></i> GUARDAR</button>
            <a type="button" class=" btn btn-danger  float-right" href="{{ url()->previous() }}" style="margin-right: 5px;"><i class="fa fa-times-circle"></i> CANCELAR</a>
        </div>
    </form>
</div>