{!! Form::open(['route' => 'admin.vehiclecolors.store', 'files' => true]) !!}
@include('admin.vehiclecolors.template.form')
<button type="submit" class="btn btn-success">
    <i class="fas fa-save"></i> Registrar
    <span class="spinner-border spinner-border-sm d-none" id="loading"></span>
</button>
<button type="button" class="btn btn-danger" data-dismiss="modal">
    <i class="fas fa-arrow-alt-circle-left"></i> Cerrar
</button>
{!! Form::close() !!}

<script>
    // Mostrar spinner al enviar el formulario
    document.querySelector('form').addEventListener('submit', function() {
        document.getElementById('loading').classList.remove('d-none');
    });
</script>
