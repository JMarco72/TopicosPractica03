<div class="form-group">
    {!! Form::label('dni', 'DNI') !!}
    {!! Form::text('dni', null, [
        'class' => 'form-control',
        'placeholder' => 'Ingrese el DNI del usuario',
        'required',
        'maxlength' => 8,
        'pattern' => '[0-9]{8}',
        'title' => 'Debe contener exactamente 8 dígitos numéricos'
    ]) !!}
</div>

<div class="form-group">
    {!! Form::label('name', 'Nombre') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del usuario', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('email', 'Correo Electrónico') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el correo electrónico del usuario', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('license', 'Licencia') !!}
    {!! Form::text('license', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la licencia del usuario']) !!}
</div>

<div class="form-group">
    {!! Form::label('usertype_id', 'Tipo de Usuario') !!}
    {!! Form::select('usertype_id', $usertypes, null, ['class' => 'form-control', 'placeholder' => 'Seleccione el tipo de usuario', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('password', 'Contraseña') !!}
    {!! Form::password('password', [
        'class' => 'form-control',
        'placeholder' => 'Ingrese una contraseña',
        // Solo aplica 'required' en modo creación
        'required' => Route::currentRouteName() === 'admin.users.create' ? 'required' : null
    ]) !!}
</div>

<div class="form-group">
    {!! Form::label('password_confirmation', 'Confirmar Contraseña') !!}
    {!! Form::password('password_confirmation', [
        'class' => 'form-control',
        'placeholder' => 'Confirme la contraseña',
        // Solo aplica 'required' en modo creación
        'required' => Route::currentRouteName() === 'admin.users.create' ? 'required' : null
    ]) !!}
</div>