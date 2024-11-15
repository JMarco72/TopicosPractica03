<div class="form-group">
    {!! Form::label('name', 'Nombre') !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'placeholder' => 'Nombre del color',
        'required',
    ]) !!}
</div>

<div class="form-group row">
    <div class="col">
        {!! Form::label('red', 'Rojo (0-255)', ['class' => 'font-weight-bold']) !!}
        {!! Form::text('red', null, [
            'class' => 'form-control',
            'placeholder' => '0-255',
            'maxlength' => 3,
            'required',
            'pattern' => '^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$', // Asegura que el valor esté entre 0 y 255
            'oninput' => 'this.value = this.value.replace(/[^0-9]/g, ""); 
                          if (this.value > 255) this.value = 255;', // Limita el valor máximo a 255
        ]) !!}
    </div>
    <div class="col">
        {!! Form::label('green', 'Verde (0-255)', ['class' => 'font-weight-bold']) !!}
        {!! Form::text('green', null, [
            'class' => 'form-control',
            'placeholder' => '0-255',
            'maxlength' => 3,
            'required',
            'pattern' => '^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$', // Asegura que el valor esté entre 0 y 255
            'oninput' => 'this.value = this.value.replace(/[^0-9]/g, "");
                                      if (this.value > 255) this.value = 255;', // Limita el valor máximo a 255
        ]) !!}
    </div>
    <div class="col">
        {!! Form::label('blue', 'Azul (0-255)', ['class' => 'font-weight-bold']) !!}
        {!! Form::text('blue', null, [
            'class' => 'form-control',
            'placeholder' => '0-255',
            'maxlength' => 3,
            'required',
            'pattern' => '^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$', // Asegura que el valor esté entre 0 y 255
            'oninput' => 'this.value = this.value.replace(/[^0-9]/g, "");
                                      if (this.value > 255) this.value = 255;', // Limita el valor máximo a 255
        ]) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('description', 'Descripción') !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Descripción del color',
    ]) !!}
</div>
