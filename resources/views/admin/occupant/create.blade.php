{!! Form::open(['route'=>'admin.occupant.store']) !!}
@include('admin.occupant.template.form')

<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Agregar</button>
<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
{!! Form::close() !!}