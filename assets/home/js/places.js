'use strict';
 
function getLocation(cityId, addressId, places, myRange) {
    let city = document.getElementById(cityId);
    let address = document.getElementById(addressId);
    let range = document.getElementById(myRange);

    if (city.value && address.value) {
        let url = globalVariables.ajax + 'getLocation';
        let post = {
            'city' : city.value,
            'address' : address.value,
            'myRange' : range.value
        }

        city.style.border = '1px solid #ced4da';
        address.style.border = '1px solid #ced4da';        

        let params = [range.value,places];
        sendAjaxPostRequest(post, url, 'getLocation', calculateDistance, [params]);
        //, callFunction = null, functionArg = []
    } else {
        city.style.border = (!city.value) ? '1px solid #f00' : '1px solid #ced4da';
        address.style.border = (!address.value) ? '1px solid #f00' : '1px solid #ced4da';
        alertify.error('City and address are required');
    }
}

function calculateDistance(params,center) {
    if (center['status'] && center['status'] === '0') {
        alertify.error(center['message']);
        return;
    }
    let range = params[0];
    let placesClass = params[1];

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
        place.style.display = "none";
        let params = [place,range];
        sendAjaxPostRequest(post, url, 'calculateDistance', showDistance, [params]);
    }
}

function showDistance(params, distance) {
    let place = params[0];
    let range = params[1];
    if(distance>range){
        place.style.display = "none";
    } else {
        place.style.display = "";
    }
    place.getElementsByClassName('distance')[0].innerHTML = distance + ' km';
    place.setAttribute('data-distance', distance);
    
    
}
