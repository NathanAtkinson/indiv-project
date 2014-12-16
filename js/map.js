


var map;
var infoWindow;
var service;

//creates map, centers it on Long/Lat of address 1601 Fountainhead Pkwy
function initialize() {
    map = new google.maps.Map(document.getElementById('map-canvas'), {
    center: new google.maps.LatLng(33.403480, -111.964403),
    zoom: 12,
    mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    infoWindow = new google.maps.InfoWindow();
    service = new google.maps.places.PlacesService(map);

    google.maps.event.addListenerOnce(map, 'bounds_changed', performSearch);
}


//gets users current location and centers the map on them.
//TODO implement searching on location
/*if (navigator.geolocation) {
     navigator.geolocation.getCurrentPosition(function (position) {
         initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
         map.setCenter(initialLocation);
     });
 }*/


//searches based on location, a radius, and the query of pizza
function performSearch() {
    var request = {
    	location: new google.maps.LatLng(33.403480, -111.964403),
    // bounds: map.getBounds(),
    radius: '9000',
    query: 'pizza'
    };

    //provides data in results that can be accessed below for address, name, etc.
    service.textSearch(request, callback);
}


//If not results generated or there's another issue, alert user to the problem. Otherwise create markers
function callback(results, status) {
    if (status != google.maps.places.PlacesServiceStatus.OK) {
    alert(status);
    return;
    }
    for (var i = 0, result; result = results[i]; i++) {
    createMarker(result);
    }
}

//creates markers on the map, using custom icon.  Also adds listener, so when icon is
//clicked, shows details (rating, website, address, phone number)
function createMarker(place) {
    var marker = new google.maps.Marker({
    map: map,
    position: place.geometry.location,
    icon: '/app/images/pizzaria.png'
    });

    //when a marker is click, get the details
    google.maps.event.addListener(marker, 'click', function() {
    service.getDetails(place, function(result, status) {
      if (status != google.maps.places.PlacesServiceStatus.OK) {
        alert(status);
        return;
      }

      //when a marker is clicked, this is the info shown.
      infoWindow.setContent(result.name + "&nbsp " + result.rating 
      	+ "/5 stars<br> <a href='" + result.website + "'>" + result.website 
      	+ "</a><br>" + result.formatted_address 
      	+ "<br> Phone: " + result.formatted_phone_number);
      infoWindow.open(map, marker);
    });
    });

}

//intitializes the map after page is loaded.
google.maps.event.addDomListener(window, 'load', initialize);
