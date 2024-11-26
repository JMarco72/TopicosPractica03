@extends('adminlte::page')

@section('title', 'Perímetro de zona')

@section('content')
<div class="p-3"></div>
<div class="card">
    <div class="card-header">
        <button class="btn btn-success float-right" id="btnNuevo" data-id={{ $route->id }}>
            <i class="fas fa-plus"></i> Agregar Zona a Ruta
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Información de la ruta -->
            <div class="col-3 card" style="min-height: 50px">
                <br>
                <div class="card-body">
                    <label for="">Nombre de la Ruta:</label><br>
                    {{ $route->name }} <br><br>
                    <label for="">Latitud y Longitud Inicial:</label><br>
                    {{ $route->latitudestart }} {{ $route->longitudestart }}<br><br>
                    <label for="">Latitud y Longitud Final:</label><br>
                    {{ $route->latitudefinal }} {{ $route->longitudefinal }}<br><br>
                </div>
            </div>

            <!-- Tabla de zonas -->
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" id="datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ZONAS</th>
                                    <th>AREA</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($routezones as $zone)
                                    <tr>
                                        <td>{{ $zone->id }}</td>
                                        <td>{{ $zone->name }}</td>
                                        <td>{{ $zone->area }}</td>
                                        <td>
                                            <form action="{{ route('admin.routezones.destroy', $zone->id) }}" method="POST" class="fmrEliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
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
</div>

<!-- Mapa -->
<div class="card">
    <div class="card-header">Mapa de la ruta</div>
    <div class="card-body">
        <div id="map" style="height:400px"></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de Zonas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí se cargará el formulario -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveZoneBtn">Guardar</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<!-- Estilos adicionales -->
@stop

@section('js')
<script>
    // Inicializar DataTable
    $('#datatable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }
    });

    // Variables con datos desde el backend
    var perimeters = @json($perimeter);
    var route = {
        start: {
            lat: {{ $route->latitudestart }},
            lng: {{ $route->longitudestart }}
        },
        end: {
            lat: {{ $route->latitudefinal }},
            lng: {{ $route->longitudefinal }}
        }
    };

    // Inicializar el mapa
    function initMap() {
        var mapOptions = {
            center: { lat: route.start.lat, lng: route.start.lng },
            zoom: 15
        };

        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        // Dibujar perímetros
        perimeters.forEach(function(perimeter) {
            if (!perimeter.coords || perimeter.coords.length === 0) {
                console.warn("Perímetro sin coordenadas:", perimeter);
                return;
            }

            var perimeterPolygon = new google.maps.Polygon({
                paths: perimeter.coords.map(coord => ({ lat: coord.lat, lng: coord.lng })),
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map
            });
        });

        // Dibujar la ruta
        var routePath = new google.maps.Polyline({
            path: [route.start, route.end],
            geodesic: true,
            strokeColor: '#0000FF',
            strokeOpacity: 1.0,
            strokeWeight: 2,
            map: map
        });

        // Marcadores
        new google.maps.Marker({
            position: route.start,
            map: map,
            title: 'Inicio de la Ruta'
        });

        new google.maps.Marker({
            position: route.end,
            map: map,
            title: 'Final de la Ruta'
        });
    }

    // Inicializar el mapa
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
</script>
@stop
