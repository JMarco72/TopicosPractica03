<div class="form-group">
    {!! Form::label('name', 'Nombre') !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'placeholder' => 'Nombre del tipo de personal',
        'required',
    ]) !!}
    <small class="form-text text-muted">Ejemplo: Tipo A, Tipo B.</small>
</div>
<div class="form-group">
    {!! Form::label('description', 'Descripción') !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Descripción del tipo de personal',
    ]) !!}
    <small class="form-text text-muted">Opcional: Describe una funcionalidad importantes.</small>
</div>
