<div class="form-group">
    {!! Form::label('name', 'Nombre') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la zona', 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('sector_id', 'Sector') !!}
    {!! Form::select('sector_id', $sectors, null, ['class' => 'form-control', 'required']) !!}
</div>