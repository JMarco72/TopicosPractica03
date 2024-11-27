<div class="form-group">
    {!! Form::label('name', 'Nombre') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre del modelo', 'requerid']) !!}
    <small class="form-text text-muted">Ejemplo: Modelo A, Modelo B.</small>
</div>

<div class="form-group">
    {!! Form::label('brand_id', 'Marca') !!}
    {!! Form::select('brand_id', $brands, null, ['class' => 'form-control', 'required']) !!}
    <small class="form-text text-muted">Selecciona una marca.</small>
</div>

<div class="form-group">
    {!! Form::label('description', 'Descripción') !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Descripción del modelo',
    ]) !!}
    <small class="form-text text-muted">Opcional: Describe una caracteristicas importantes.</small>
</div>
