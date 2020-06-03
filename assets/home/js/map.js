var globals = getGloablsMapVariablse();
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, worldMap);
    } else {
        let message = 'Geolocation is not supported by this browser.';
        alertify.alert(message);
    }
}

function worldMap() {
    new google.maps.Map(document.getElementById('map'), {
        center: {lat: 0, lng: 0},
        zoom: 3
    });
}

function showPosition(position) {
    var hotels = globals.hotels;
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    //Save position in DB
    $.ajax({
        type: "POST",
        url: globals.saveLocationUrl,
        data: {
            id: globals.id,
            lat: latitude,
            lng: longitude
        },
        success: function () {
        },
        error: function () {
        }
    });
    // Create map
    var directionsService = new google.maps.DirectionsService();
    var directionsRenderer = new google.maps.DirectionsRenderer();
    var map = new google.maps.Map(document.getElementById('map'), {


        center: {lat: latitude, lng: longitude},
        zoom: 12
    });
    // Create marker
    var marker = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng(latitude, longitude),
        // title: 'Your location',
        // icon: {
        //     url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
        // }
    });

    // Add circle overlay and bind to marker
    var circle = new google.maps.Circle({
        map: map,
        radius: 20000,
        strokeColor: "#FF0000",
        strokeOpacity: 0.1,
        strokeWeight: 1,
        fillColor: "#FF0000",
        fillOpacity: 0.1
    });

    circle.bindTo('center', marker, 'position');

    //Add Hotels as markers
    var icon = {
        url: globals.markerSrc,
        scaledSize: new google.maps.Size(40, 40)
    };

    var infowindow = new google.maps.InfoWindow();

    var hotelMarker, i;
    var markers = new Array();

    for (var i = 0; i < hotels.length; i++) {
            hotelMarker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(hotels[i].lat, hotels[i].lng),
            title: "Name: " + hotels[i].username + "\nItem lost and found: " + hotels[i].lostfounditems,
            url: globals.url + 'location/' + hotels[i].id,
            icon: icon
        });

        markers.push(marker);

        google.maps.event.addListener(hotelMarker, 'click', (function(hotelMarker, i) {
            return function() {
                // infowindow.setContent(hotels[i][0]);
                // infowindow.open(map, hotelMarker);
                window.location.href = hotelMarker.url;
            }
        })(hotelMarker, i));
        hotelMarker.setMap(map);
    }
}