@extends('template.headerblanklight')
@section('content')
<style>

    #map{
        width:100%;
        height:100%;
    }
</style>

<!--Content Title -->
<div id="content-header">
    <div id="breadcrumb">
        <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#" class="current">Wallboard</a>
    </div>
</div>
<!-- End Content Title -->

<!-- Start Content -->
<div id="map" style="width:100%; height:600px";></div>
    <script>
      
      var map, infoWindow;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 6
        });
        infoWindow = new google.maps.InfoWindow;

        var pos = {
            lat: {{ $lat }},
            lng: {{ $lon }}
        };

        infoWindow.setPosition(pos);
        infoWindow.setContent('<strong>Street:</strong>{{ $shippingAddress->street }}<br><strong>Suburb:</strong>{{ $shippingAddress->suburb}}<br>{{ $shippingAddress->state}} {{ $shippingAddress->postcode}}');
        infoWindow.open(map);
        map.setCenter(pos);
        /*
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
                };

                infoWindow.setPosition(pos);
                infoWindow.setContent('Location found.');
                infoWindow.open(map);
                map.setCenter(pos);
            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        }
        else {
          handleLocationError(false, infoWindow, map.getCenter());
        }
        */
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
    </script>
      <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBndZ6dcgB5okrA7U2CmaRhUmNvsYRgbOo&callback=initMap"
  type="text/javascript"></script>
@endsection