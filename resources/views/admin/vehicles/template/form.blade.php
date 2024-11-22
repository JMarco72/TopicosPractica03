<div class="form-row">
    <div class="form-group col-3">
        {!! Form::label('code', 'Código') !!}
        {!! Form::text('code', null, [
            'class' => 'form-control',
            'placeholder' => 'Código',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-9">
        {!! Form::label('name', 'Nombre') !!}
        {!! Form::text('name', null, [
            'class' => 'form-control',
            'placeholder' => 'Nombre del vehículo',
            'required',
        ]) !!}
    </div>

</div>
<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('brand_id', 'Marca') !!}
        {!! Form::select('brand_id', $brands, null, [
            'class' => 'form-control',
            'id' => 'brand_id',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('model_id', 'Model') !!}
        {!! Form::select('model_id', $models, null, [
            'class' => 'form-control',
            'id' => 'model_id',
            'required',
        ]) !!}
    </div>
</div>
<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('type_id', 'Tipo') !!}
        {!! Form::select('type_id', $types, null, [
            'class' => 'form-control',
            'id' => 'type_id',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-6">
    {!! Form::label('color_id', 'Color') !!}
    <div class="d-flex align-items-center">
        <select name="color_id" id="color_id" class="form-control" required>
            <option value="" disabled selected>Seleccione un color</option>
            @foreach ($colors as $id => $color)
                <option value="{{ $id }}" data-rgb="{{ $color['rgb'] }}" 
                    {{ isset($vehicle) && $vehicle->color_id == $id ? 'selected' : '' }}>
                    {{ $color['name'] }}
                </option>
            @endforeach
        </select>
        <div id="colorPreview" style="
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid #ddd; /* Borde suave */
            margin-left: 10px; /* Espaciado entre el select y el círculo */
            background-color: {{ isset($vehicle) && isset($colors[$vehicle->color_id]) ? $colors[$vehicle->color_id]['rgb'] : '#ffffff' }};
        "></div>
    </div>
</div>
</div>

<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('plate', 'Placa') !!}
        {!! Form::text('plate', isset($vehicle) ? $vehicle->plate : 'PERU ', [
    'class' => 'form-control',
    'placeholder' => 'placa del vehículo',
    'required',
    'maxlength' => '12'
]) !!}
        <small class="form-text text-muted">
            El formato debe ser: <strong>PERU 123-456</strong>
        </small>
    </div>
    <div class="form-group col-6">
        {!! Form::label('year', 'Año') !!}
        {!! Form::select('year', 
            array_combine(range(2000, date('Y')), range(2000, date('Y'))), 
            null, [
                'class' => 'form-control',
                'required' => 'required',
                'placeholder' => 'Seleccione el año del vehículo',
            ]) !!}
    
    </div> 
</div>
<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('occupant_capacity', 'Capacidad de ocupantes') !!}
        {!! Form::select('occupant_capacity', 
        array_combine(range(1, 6), range(1, 6)), 
        null, [
            'class' => 'form-control',
            'placeholder' => 'Capacidad de ocupantes del vehículo',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('load_capacity', 'Capacidad de carga (TN)') !!}
        {!! Form::number('load_capacity', null, [
            'class' => 'form-control',
            'placeholder' => 'Capacidad de carga del vehículo',
            'required',
        ]) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('description', 'Descripción') !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Descripción del vehículo',
        'rows' => 5,
    ]) !!}
</div>
<div class="form-check">

    {!! Form::checkbox('status', 1, null, [
        'class' => 'form-check-input',
    ]) !!}
    {!! Form::label('status', 'Activo') !!}
</div>
<div class="form-row">
    <div class="form-group col-3">
        {!! Form::file('image', [
            'class' => 'form-control-file d-none', // Oculta el input
            'accept' => 'image/*',
            'id' => 'imageInput',
        ]) !!}
        <button type="button" class="btn btn-primary" id="imageButton"><i class="fas fa-image"></i> Seleccionar Imagen</button>

    </div>
    <div class="form-group col-9">
        <img id="imagePreview" src="#" alt="Vista previa de la imagen"
            style="max-width: 100%; height: auto; display: none;">
    </div>
</div>

<script>
    $("#brand_id").change(function() {
        var id = $(this).val();

        $.ajax({
            url: "{{ route('admin.modelsbybrand', '_id') }}".replace('_id', id),
            type: "GET",
            datatype: "JSON",
            contentype: "application/json",
            success: function(response) {
                $("#model_id").empty();
                $.each(response, function(key, value) {
                    $("#model_id").append("<option value=" + value.id + ">" + value.name +
                        "</option>");
                });
                console.log(response);

            }
        });
    });

    $('#imageInput').change(function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });

    $('#imageButton').click(function() {
        $('#imageInput').click();
    });

    $(document).ready(function () {
    // Inicializar la vista previa del color al cargar (solo para editar)
    var selectedOption = $('#color_id').find(':selected'); // Captura la opción seleccionada
    var colorRgb = selectedOption.data('rgb'); // Obtén el valor RGB
    if (colorRgb) {
        $('#colorPreview').css('background-color', colorRgb); // Cambia el color del círculo
    } else {
        $('#colorPreview').css('background-color', '#ffffff'); // Blanco por defecto si no hay selección
    }

    // Cambiar la vista previa al seleccionar un nuevo color
    $('#color_id').change(function () {
        var selectedOption = $(this).find(':selected'); // Captura la opción seleccionada
        var colorRgb = selectedOption.data('rgb'); // Obtén el valor RGB
        $('#colorPreview').css('background-color', colorRgb); // Cambia el color del círculo
    });
});


</script>
