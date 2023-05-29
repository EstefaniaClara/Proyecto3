<!DOCTYPE html>
<html>
<head>
    
    <title>Mapa con Leaflet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Prueba tecnica</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        <a class="nav-link" href="consulta.php">Ver registros</a>
      </div>
    </div>
  </div>
</nav>
  
    <div id="map" style="height: 400px;"></div>

    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(map);

        // Función para manejar el clic en el mapa
        function onMapClick(e) {
            var latlng = e.latlng;

            // Consultar la humedad a OpenWeatherMap
            axios.get('https://api.openweathermap.org/data/2.5/weather', {
                params: {
                    lat: latlng.lat,
                    lon: latlng.lng,
                    appid: '28c5ba8ae52b870b28f6be3926faa0b7',
                    units: 'metric'
                }
            })
            .then(function (response) {
                var humidity = response.data.main.humidity;
                var city = response.data.name;

                // Crear marcador con la humedad
                L.marker(latlng).addTo(map)
                    .bindPopup("Humedad: " + humidity + "% " + city)
                    .openPopup();

                // Enviar datos por AJAX
                guardarDatos(city, humidity);
            })
            .catch(function (error) {
                console.log(error);
            });
        }

        // Función para enviar datos por AJAX
        function guardarDatos(city, humidity) {
            $.ajax({
                url: 'guardar_datos.php',
                type: 'POST',
                data: { city: city, humidity: humidity },
                success: function(response) {
                    // La respuesta del servidor
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Agregar el evento de clic al mapa
        map.on('click', onMapClick);
    </script>
</body>
</html>
