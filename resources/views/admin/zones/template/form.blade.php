<div class="form-group">
    {!! Form::label('name', 'Nombre') !!}
<<<<<<< HEAD
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la zona', 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('sector_id', 'Sector') !!}
    {!! Form::select('sector_id', $sectors, null, ['class' => 'form-control', 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('district_id', 'Distrito') !!}
    {!! Form::select('district_id', $districts, null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('area', 'Area') !!}
    {!! Form::number('area', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la zona', 'required']) !!}
=======
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la zona', 'requerid']) !!}
</div>

<div class="form-group">
    {!! Form::label('area', 'Area (metro)') !!}
    {!! Form::number('area', null, ['class' => 'form-control', 'placeholder' => 'Area de la zona', 'requerid']) !!}

</div>

<div class="form-group">
    {!! Form::label('sector_id', 'Sector') !!}
    {!! Form::select('sector_id', $sector, null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('district_id', 'Distrito') !!}
    {!! Form::select('district_id', $district, null, ['class' => 'form-control', 'required']) !!}
>>>>>>> c5f00a88efe3ce68bc5efdf7ffce97ddc9386baf
</div>

<div class="form-group">
    {!! Form::label('description', 'Descripción') !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Descripción de la marca',
    ]) !!}
</div>
