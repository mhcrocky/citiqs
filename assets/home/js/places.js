'use strict';

function getLocation(cityId, addressId, places) {
    let city = document.getElementById(cityId);
    let address = document.getElementById(addressId);

    if (city.value && address.value) {
        let url = globalVariables.ajax + 'getLocation';
        let post = {
            'city' : city.value,
            'address' : address.value
        }

        city.style.border = '1px solid #ced4da';
        address.style.border = '1px solid #ced4da';        

        sendAjaxPostRequest(post, url, 'getLocation', calculateDistance, [places]);
        //, callFunction = null, functionArg = []
    } else {
        city.style.border = (!city.value) ? '1px solid #f00' : '1px solid #ced4da';
        address.style.border = (!address.value) ? '1px solid #f00' : '1px solid #ced4da';
        alertify.error('City and address are required');
    }
}

function calculateDistance(placesClass, center) {
    if (center['status'] && center['status'] === '0') {
        alertify.error(center['message']);
        return;
    }

    let places = document.getElementsByClassName(placesClass);
    let placesLength = places.length;
    let i;
    for (i = 0; i < placesLength; i++) {
        let url = globalVariables.ajax + 'calculateDistance';
        let place = places[i];
        let post = {
            'latOne' : center['lat'],
            'lngOne' : center['long'],
            'latTwo' : place.dataset['lat'],
            'lngTwo' : place.dataset['lng'],
        }
        sendAjaxPostRequest(post, url, 'calculateDistance', showDistance, [place]);
    }
}

function showDistance(place, distance) {
    place.getElementsByClassName('distance')[0].innerHTML = distance + ' km';
    place.setAttribute('data-distance', distance);
}
