{!! Form::model($vehiclecolors, ['route' => ['admin.vehiclecolors.update', $vehiclecolors], 'method' => 'put', 'files' => true]) !!}
@include('admin.vehiclecolors.template.form')
<button type="submit" class="btn btn-success"><i class="fas fa-pen-square"></i> Actualizar</button>
<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-arrow-alt-circle-left"></i> Cerrar</button>

{!! Form::close() !!}