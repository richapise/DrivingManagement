<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Location Tracking</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_AdvL3PdWFTblURaGndSfTeazWyjnT88""></script>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>

<h2>Live Location Tracking</h2>
<div id="map"></div>
<div id="location"></div>

<script>
    let map, marker;

    function initMap() {
        // Initialize map
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 0, lng: 0 },
            zoom: 2,
        });

        marker = new google.maps.Marker({
            position: { lat: 0, lng: 0 },
            map: map,
            title: 'Your Location',
        });

        // Start tracking the location
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(showPosition, showError);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;

        // Update marker position on the map
        const newLocation = { lat: latitude, lng: longitude };
        marker.setPosition(newLocation);
        map.setCenter(newLocation);

        document.getElementById("location").innerHTML =
            "Latitude: " + latitude + "<br>Longitude: " + longitude;

        // Send the location to the server
        sendLocation(latitude, longitude);
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                alert("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                alert("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                alert("An unknown error occurred.");
                break;
        }
    }

    function sendLocation(latitude, longitude) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "track_location.php", true); // Ensure the URL is correct
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log("Response from server: ", xhr.responseText);
                } else {
                    console.error("Error: ", xhr.statusText);
                }
            }
        };
        xhr.send("latitude=" + latitude + "&longitude=" + longitude);
    }

    // Initialize the map when the window loads
    window.onload = initMap;
</script>

</body>
</html>
