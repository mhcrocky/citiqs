function myFunction(str) {
    $(document).ready(function() {
        var usersAjax = getUsersAjax();
        $.get(usersAjax + encodeURIComponent(str), function(data) {
            var result = JSON.parse(data);
            // var result1 = JSON.parse(data);
            // var myJSON = JSON.stringify(data);
            // document.write(result);
            // document.write(result1);
            // document.write(myJSON);
            // document.write(result.username);
            //$.each(result, function (i, item) {
            $('#myTable tbody').append('<tr><td>' + result.username + '</td><td>' + result.email + '</td></tr>');
            if (result.username == true) {
                document.getElementById("UnkownAddressText1").style.display = "block";
                document.getElementById("UnkownAddressText2").style.display = "block";
                document.getElementById("name").style.display = "block";
                document.getElementById("address").style.display = "block";
                document.getElementById("addressa").style.display = "block";
                document.getElementById("zipcode").style.display = "block";
                document.getElementById("city").style.display = "block";
                document.getElementById("country").style.display = "block";
                document.getElementById("country1").style.display = "block";
            }
        });
    });
}

function myFunctionBrand(str) {
    $(document).ready(function() {
        var usersAjax = getUsersAjax();
        $.get(usersAjax + encodeURIComponent(str), function(data) {
            var result = JSON.parse(data);
            // var result1 = JSON.parse(data);
            // var myJSON = JSON.stringify(data);
            // document.write(result);
            // document.write(result1);
            // document.write(myJSON);
            // document.write(result.username);
            //$.each(result, function (i, item) {
            $('#myTable tbody').append('<tr><td>' + result.username + '</td><td>' + result.email + '</td></tr>');
            if (result.username == true) {
                document.getElementById("brandUnkownAddressText").style.display = "block";
                document.getElementById("brandname").style.display = "block";
                document.getElementById("brandaddress").style.display = "block";
                document.getElementById("brandaddressa").style.display = "block";
                document.getElementById("brandzipcode").style.display = "block";
                document.getElementById("brandcity").style.display = "block";
                document.getElementById("brandcountry").style.display = "block";
                document.getElementById("brandcountry1").style.display = "block";
            }
        });
    });
}