<div id="map" class="card" style="width: 100%; height:400px;"></div>

<script>
    // Datos de las rutas (puntos de inicio y fin)
    var routes = @json($points);

    function initMap() {
        
        // Configuración inicial del mapa
        var mapOptions = {
            center: { lat: 0, lng: 0 }, // Centro temporal
            zoom: 14
        };

        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var bounds = new google.maps.LatLngBounds(); // Para ajustar el mapa a las rutas

        if (routes.length > 0) {
            // Dibuja líneas rectas para cada ruta
            routes.forEach(function (route) {
                var startPoint = new google.maps.LatLng(route.start.lat, route.start.lng);
                var endPoint = new google.maps.LatLng(route.end.lat, route.end.lng);

                // Crear una línea recta entre los puntos
                var routeLine = new google.maps.Polyline({
                    path: [startPoint, endPoint],
                    geodesic: true,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 3,
                    map: map
                });

                // Agregar marcadores de inicio y fin
                new google.maps.Marker({
                    position: startPoint,
                    map: map,
                    title: 'Inicio: ' + route.name
                });

                new google.maps.Marker({
                    position: endPoint,
                    map: map,
                    title: 'Fin: ' + route.name
                });

                // Ajustar los límites del mapa
                bounds.extend(startPoint);
                bounds.extend(endPoint);
            });

            // Ajustar el mapa para incluir todas las rutas
            map.fitBounds(bounds);
        } else {
            console.warn('No hay rutas para mostrar.');
            map.setZoom(14); // Zoom predeterminado si no hay rutas
        }

        // Código comentado para rutas calculadas con Directions API:
        /*
        var directionsService = new google.maps.DirectionsService();

        routes.forEach(function (route) {
            var startPoint = { lat: route.start.lat, lng: route.start.lng };
            var endPoint = { lat: route.end.lat, lng: route.end.lng };

            var directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: true // Evitar duplicar marcadores
            });

            var request = {
                origin: startPoint,
                destination: endPoint,
                travelMode: 'DRIVING' // Modos: DRIVING, WALKING, etc.
            };

            directionsService.route(request, function (result, status) {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result); // Dibujar la ruta en el mapa
                } else {
                    console.error('Error al calcular la ruta:', status);
                }
            });
        });
        */
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
