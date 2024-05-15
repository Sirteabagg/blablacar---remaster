<!DOCTYPE html>
<html lang="en">
<!-- AIzaSyCW8yT2aQ3h2AgHcRWYtti3FZt5_7lpVNo -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCW8yT2aQ3h2AgHcRWYtti3FZt5_7lpVNo&callback=initMap"></script>
    <title>Document</title>
</head>

<body onload="initMap()">
    <h1> Directions Route Finder</h1>
    <br><br>
    <div class="container">
        <div class="form-group">
            <input id="source" class="form-control" type="text" placeholder="source">
        </div>
        <div class="form-group">
            <input id="destination" class="form-control" type="text" placeholder="destination">
        </div>
        <button> Get direction</button>
        <div id="map" style="height: 500px; width:100%;"></div>
    </div>
</body>

<script>
    let map, directionsServices, directionsRenderer
    let sourcesAutocomplete, destAutocomplete

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: 37.7749,
                lng: -122.4194,
            },
            zoom: 13,
        });
        directionsServices = new google.maps.DirectionsService()
        directionsRenderer = new google.maps.DirectionsRenderer()
        directionsRenderer.setMap(map)
    }

    function calcRoute() {

    }
</script>

</html>