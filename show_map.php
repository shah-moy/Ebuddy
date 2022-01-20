<?php
include_once 'mapheader.php';
include 'locations_model.php';
//get_unconfirmed_locations();exit;
?>

<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD47vDVU1O7FPsOynGzXuFdtvbYGIjSvZA">
</script>


    <div style="height:500px; width:100%; ">
         <div id="map"></div>
    </div>

    <script>
    var map;
    var marker;
    var infowindow;
    var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
    var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
    var green_icon= 'http://maps.google.com/mapfiles/ms/icons/green-dot.png' ;
    var locations = <?php get_all_locations() ?>;

  /*  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (p) {
        var LatLng = new google.maps.LatLng(p.coords.latitude, p.coords.longitude);
        var mapOptions = {
            center: LatLng,
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);
        var marker = new google.maps.Marker({
            position: LatLng,
            map: map
        });
        google.maps.event.addListener(marker, "click", function (e) {
            var infoWindow = new google.maps.InfoWindow();
            infoWindow.open(map, marker);
        });
    });
}
*/






    function initMap() {
        var bangladesh = {lat: 23.777176, lng: 90.399452};
        infowindow = new google.maps.InfoWindow();
        map = new google.maps.Map(document.getElementById('map'), {
            center: bangladesh,
            zoom: 7
        });
        if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (p) {
        var mapOptions = {
            center: LatLng,
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }; 
         var LatLng = new google.maps.LatLng(p.coords.latitude, p.coords.longitude);
        map = new google.maps.Map(document.getElementById('map'), {
            center: LatLng,
            zoom: 17,
            
        });

      
    var i ; 
        for (i = 0; i < locations.length; i++) {
            if(i==0){

                marker = new google.maps.Marker({
                position: LatLng,
                map: map,
                icon :   green_icon,
                
            });

            }else{

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][2], locations[i][3]),
                map: map,
                icon :   locations[i][6] === '1' ?  red_icon  : purple_icon,
                html: document.getElementById('form')
            });
            
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    $("#id").val(locations[i][0]);
                    $("#shop_name").val(locations[i][1]);
                    $("#hour").val(locations[i][4]);
                    $("#description").val(locations[i][5]);
                    $("#form").show();
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
            
            
            }

         
        }

    });
}


    } 

    function saveData() {
        downloadUrl(url, function(data, responseCode) {
            if (responseCode === 200  && data.length > 1) {
                infowindow.close();
                window.location.reload(true);
            }else{
                infowindow.setContent("<div style='color: purple; font-size: 25px;'>Inserting Errors</div>");
            }
        });
    }


    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                callback(request.responseText, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }


</script>

<div style="display: none" id="form">
    <table class="map1">
        <tr>
            <input name="id" type='hidden' id='id'/>
            <td><a>Shop:</a></td>
            <td><input type='text' disabled id='shop_name' placeholder='Name'></input></td>
        </tr>
        <tr>
            <input name="id" type='hidden' id='id'/>
            <td><a>Open/Closing Hour:</a></td>
            <td><textarea disabled id='hour' placeholder='Open/Closing Hour'></textarea></td>
        </tr>
        <tr>
            <input name="id" type='hidden' id='id'/>
            <td><a>Description:</a></td>
            <td><textarea disabled id='description' placeholder='Description'></textarea></td>
        </tr>
    </table>
</div>

<script async defer 
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD47vDVU1O7FPsOynGzXuFdtvbYGIjSvZA&callback=initMap">
</script>

<?php
include_once 'mapfooter.php';

?>