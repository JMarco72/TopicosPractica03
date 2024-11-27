<div class="form-group">
    {!! Form::label('name', 'Nombre del sector') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre del sector', 'required']) !!}
    <small class="form-text text-muted">Ejemplo: Sector A, Sector B.</small>
</div>

<div class="form-group">
    {!! Form::label('area', 'Área') !!}
    {!! Form::number('area', null, [
        'class' => 'form-control',
        'placeholder' => 'Área del sector en metros cuadrados',
        'step' => '0.01',
    ]) !!}
    <small class="form-text text-muted">Ejemplo: 123, 250.</small>

</div>

<div class="form-group">
    {!! Form::label('district_id', 'Distrito') !!}
    {!! Form::select('district_id', $districts, null, ['class' => 'form-control', 'required']) !!}
    <small class="form-text text-muted">Selecciona un distrito.</small>
</div>

<div class="form-group">
    {!! Form::label('description', 'Descripción') !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Descripción del sector (opcional)',
    ]) !!}
    <small class="form-text text-muted">Opcional: Caracteristicas del sector.</small>
</div>
