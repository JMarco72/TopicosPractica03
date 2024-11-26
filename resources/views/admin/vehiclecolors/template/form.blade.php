<div class="row">
    <!-- Campo para el nombre -->
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

    <!-- Campo para el selector de color -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('color_code', 'Color') !!}
            <input type="color" name="color_code" id="color_code" class="form-control">
            <small class="form-text text-muted">Selecciona un color de la paleta.</small>
        </div>
    </div>
</div>

<!-- Campos ocultos para red, green, blue -->
<input type="hidden" name="red" id="red">
<input type="hidden" name="green" id="green">
<input type="hidden" name="blue" id="blue">

<!-- Campo para la descripción -->
<div class="form-group">
    {!! Form::label('description', 'Descripción') !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Descripción del color',
    ]) !!}
    <small class="form-text text-muted">Opcional: Describe cómo o dónde se utiliza este color.</small>
</div>

<script>
    // Actualizar los valores RGB cuando se selecciona un color
    document.getElementById('color_code').addEventListener('input', function() {
        const hex = this.value;
        const r = parseInt(hex.slice(1, 3), 16);
        const g = parseInt(hex.slice(3, 5), 16);
        const b = parseInt(hex.slice(5, 7), 16);

        document.getElementById('red').value = r;
        document.getElementById('green').value = g;
        document.getElementById('blue').value = b;
    });
</script>
