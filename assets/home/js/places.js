'use strict';

function getPlaceByLocation(location, places, myRange) {
    let address = document.getElementById(location);
    let range = document.getElementById(myRange);
   

    if (address.value) { 
        let url = "Ajaxdorian/getPlaceByLocation";
        let post = {
            'location' : address.value,
            'range' : range.value
        }

        
        address.style.border = '1px solid #ced4da';        

        $.ajax({
            url: url,
            data: post,
            type: 'POST',
            success: function (response) {
                $("#places").empty();
                $("#places").append(response);
                $('#places .places').sort(function(a, b) {
                    return $(a).data('distance') - $(b).data('distance');
                }).appendTo('#places');
                $(".places").removeClass("fade");
                
            },
            error: function (err) {
                console.dir(err);
            }
        });

    } else {
        address.style.border = (!address.value) ? '1px solid #f00' : '1px solid #ced4da';
        alertify.error('City and address are required');
    }
}

/*
function getLocation(addressId, places, myRange) {
    let address = document.getElementById(addressId);
    let range = document.getElementById(myRange);

    if (city.value && address.value) { 
        let url = globalVariables.ajax + 'getLocation';
        let post = {
            'address' : address.value,
        }
        console.log(globalVariables.ajax);

        
        address.style.border = '1px solid #ced4da';        

        let params = [range.value,places];
        sendAjaxPostRequest(post, url, 'getLocation', calculateDistance, [params]);
        //, callFunction = null, functionArg = []
    } else {
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
        sendAjaxPostRequest(post, url, 'calculateDistance', showResult, [params]);
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

function showResult(params, distance) {
    let place = params[0];
    let range = params[1];
    if(distance>range){
        place.style.display = "none";
    } else {
        place.style.display = "";
    }
    
    
}
*/
