{!! Form::model($vehiclecolor, [
    'route' => ['admin.vehiclecolors.update', $vehiclecolor->id],
    'method' => 'put',
    'files' => true,
    'id' => 'formEdit',
]) !!}

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('name', 'Nombre') !!}
            {!! Form::text('name', null, [
                'class' => 'form-control',
                'placeholder' => 'Nombre del color',
                'required',
            ]) !!}
            <small class="form-text text-muted">Ejemplo: Rojo, Azul, Verde.</small>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('color_code', 'Color') !!}
            <input type="color" name="color_code" id="color_code" class="form-control"
                value="{{ $vehiclecolor->color_code }}">
            <small class="form-text text-muted">Selecciona un color de la paleta.</small>
        </div>
    </div>
</div>

<input type="hidden" name="red" id="red" value="{{ $vehiclecolor->red }}">
<input type="hidden" name="green" id="green" value="{{ $vehiclecolor->green }}">
<input type="hidden" name="blue" id="blue" value="{{ $vehiclecolor->blue }}">

<div class="form-group">
    {!! Form::label('description', 'Descripción') !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Descripción del color',
    ]) !!}
</div>

<button type="submit" class="btn btn-success">
    <i class="fas fa-save"></i> Actualizar
</button>
<button type="button" class="btn btn-danger" data-dismiss="modal">
    <i class="fas fa-window-close"></i> Cancelar
</button>

{!! Form::close() !!}

<script>
    // Actualizar los valores RGB al seleccionar un color
    document.getElementById('color_code').addEventListener('input', function() {
        const hex = this.value;
        document.getElementById('red').value = parseInt(hex.slice(1, 3), 16);
        document.getElementById('green').value = parseInt(hex.slice(3, 5), 16);
        document.getElementById('blue').value = parseInt(hex.slice(5, 7), 16);
    });
</script>
