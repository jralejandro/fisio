<div class="card">
    <form action="{{route('sesiones.supdate',$sesiones->id)}}" method="POST">
        @csrf
        <div class="card-header">
            <div class="row">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-id-card"></i> TRATAMIENTO               
                    </h4>
                </div>                
              </div>           
        </div>
        <div class="card-body">
            @include('sesiones._formPos')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-file btn-success btn-flat pull-right fa fa-save float-right"> Guardar</button>
        </div>
    </form>
</div>