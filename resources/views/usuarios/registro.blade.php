<div class="card">
    <form action="{{route('usuarios.store')}}" method="POST">
        @csrf
        <div class="card-header">
            <div class="row">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-id-card"></i> Datos Personales                
                    </h4>
                </div>                
              </div>           
        </div>
        <div class="card-body">
            @include('usuarios._formPos')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-file btn-success pull-right float-right" style="margin-right: 5px;"><i class="fa fa-save"></i> GUARDAR</button>
            <a type="button" class=" btn btn-danger  float-right" href="{{ url()->previous() }}" style="margin-right: 5px;"><i class="fa fa-times-circle"></i> CANCELAR</a>   
        </div>
    </form>
</div>