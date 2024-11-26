{!! Form::open(['route'=>'admin.routezones.store']) !!}

{!! Form::open(['route' => 'admin.routezones.store', 'id' => 'addZoneForm']) !!}

    {!! Form::hidden('route_id', $route->id) !!}

    <div class="form-group">
        {!! Form::label('zone', 'Seleccionar Zona') !!}
        {!! Form::select('zone_id', $zones, null, ['class' => 'form-control', 'required']) !!}
    </div>

    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Agregar</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>

{!! Form::close() !!}
