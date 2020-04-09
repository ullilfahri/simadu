<?php
include '../../../sysconfig.php';
$lokasi=$conn->query("select * from lokasi");
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Custom Legend</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
      }
      #map {
        /* height: 400px; */
		height: 100%;
        width: 100%;
      }
      #legend {
        font-family: Arial, sans-serif;
        background: #fff;
        padding: 10px;
        margin: 10px;
        border: 3px solid #000;
      }
      #legend h3 {
        margin-top: 0;
      }
      #legend img {
        vertical-align: middle;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <div id="legend"><h3>Keterangan : </h3></div>
    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          //center: new google.maps.LatLng(-33.91722, 151.23064),
		  // the old one is in UNSW, Australia
		  // change it into UIN Suska: 101.35475,0.46559
          center: new google.maps.LatLng(-1.828525, 109.978177),
          mapTypeId: 'roadmap'
        });
        
		var iconBase = 'http://maps.google.com/mapfiles/kml/pal3/';
		var icons = {
          3: {
            name: 'Toko',
            icon: iconBase + 'icon18.png'
          },
          6: {
            name: 'Toko Sekaligus Gudang',
            icon: iconBase + 'icon31.png'
          },
          0: {
            name: 'Tower Pusat',
            icon: iconBase + 'icon44.png'
          },
          1: {
            name: 'Base Station',
            icon: iconBase + 'icon40.png'
          },
          4: {
            name: 'Gudang',
            icon: iconBase + 'icon48.png'
          }
        };
        function addMarker(feature) {
          var marker = new google.maps.Marker({
            position: feature.position,
            icon: icons[feature.type].icon,
            map: map
          });
		  
		  // since not every feature has content, only add infoWindow when content exist
		  if(feature.content){
			  var marker_infoWindow = new google.maps.InfoWindow({
				content: feature.content
			  });
			  marker.addListener('click', function() {
				marker_infoWindow.open(map, marker);
			  });
			  
			  
		  }
        }
        var features = [
		  <?php 
		  while ($x=$lokasi->fetch_array()) :
		  ?>
		  {
            position: new google.maps.LatLng(<?=$x['lat']?>, <?=$x['lng']?>),
			content: '<?=$x['nama'].', Alamat '.$x['alamat']?>',
            type: '<?=$x['id_level']?>'
          }, <?php endwhile;?> {
            position: new google.maps.LatLng(-1.838480, 109.968069),
            type: '0',
			content: 'Hotel Asana Nevada'
          },					{
            position: new google.maps.LatLng(-1.833609, 109.969597),
            type: '1',
			content: 'Base Station'
          }
        ];
        for (var i = 0, feature; feature = features[i]; i++) {
          addMarker(feature);
        }
        var legend = document.getElementById('legend');
        for (var key in icons) {
          var type = icons[key];
          var name = type.name;
          var icon = type.icon;
          var div = document.createElement('div');
          div.innerHTML = '<img src="' + icon + '"> ' + name;
          legend.appendChild(div);
        }
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfswesJkjAcixCfuhU42Ss6dHlFCG5JAk&callback=initMap">
    </script>
  </body>
</html>