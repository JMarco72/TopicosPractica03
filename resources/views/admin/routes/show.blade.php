@extends('adminlte::page')

@section('title', 'ReciclaUSAT')

@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">
            <button class="btn btn-success float-right" id="btnNuevo" data-id="{{ $route['id'] }}">
                <i class="fas fa-plus"></i> Agregar zona
            </button>
            <h3>Descripción de la Ruta</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Detalles de la Ruta -->
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <label>Ruta:</label>
                            <p>{{ $route['name'] }}</p>
                            <label>Latitud y Longitud Inicial:</label>
                            <p>{{ $route['lat_start'] }}, {{ $route['lng_start'] }}</p>
                            <label>Latitud y Longitud Final:</label>
                            <p>{{ $route['lat_end'] }}, {{ $route['lng_end'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Zonas Relacionadas -->
                <div class="col-9">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Zona</th>
                                        <th>Área</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($routezones as $zone)
                                        <tr>
                                            <td>{{ $zone->zona }}</td>
                                            <td>{{ $zone->area }}</td>
                                            <td>
                                                <!-- Botón de acciones -->
                                                <button class="btn btn-danger btn-sm btnEliminar"
                                                    data-id="{{ $zone->zone_id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.routes.index') }}" class="btn btn-danger float-right">
                <i class="fas fa-chevron-left"></i> Retornar
            </a>
        </div>
    </div>

    <!-- Modal para Agregar Zonas -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Zona</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar zonas (cargar dinámicamente) -->
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

    <script>
        // Evento para abrir el modal y cargar contenido dinámico
        $("#btnNuevo").click(function() {
            var routeId = $(this).data('id');
            $.ajax({
                url: "{{ route('admin.routezones.create') }}", // Ruta que carga el formulario
                type: "GET",
                data: {
                    route_id: routeId
                },
                success: function(response) {
                    $("#formModal .modal-body").html(response);
                    $("#formModal").modal("show");
                }
            });
        });

        // Evento para eliminar una zona
        $(".btnEliminar").click(function() {
            var zoneId = $(this).data('id');
            Swal.fire({
                title: "¿Está seguro de eliminar esta zona?",
                text: "Esta acción no se puede revertir",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.zones.destroy', '_id') }}".replace('_id', zoneId),
                        type: "DELETE",
                        success: function(response) {
                            Swal.fire("Eliminado", "Zona eliminada correctamente", "success");
                            location.reload(); // Recargar la página
                        },
                        error: function() {
                            Swal.fire("Error", "No se pudo eliminar la zona", "error");
                        }
                    });
                }
            });
        });
    </script>
@endsection
