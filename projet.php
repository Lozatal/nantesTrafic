<?php

//LE PROXY
$opts = array('http' => array('proxy'=> 'tcp://www-cache.iutnc.univ-lorraine.fr:3128', 'request_fulluri'=> true));
$context = stream_context_create($opts);


$url = "http://api.loire-atlantique.fr:80/opendata/1.0/traficevents?filter=Tous";

$content = file_get_contents($url, NULL, $context);
$t = json_decode($content);

//var_dump($t);

//$gps = ["$xml->lat", "$xml->lon"];
//$gps = [(string) $xml->lat, (string) $xml->lon];




/*POUR LA CARTE
$xsl = new DOMDocument;
$xsl->load('carte.xsl');

$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl);

$carte = $proc->transformToXml($xml);*/



echo <<<END
<!DOCTYPE html>
	<html>
		<head>
			
			<title>Carte</title>

			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			
			<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />
		    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
		    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>

		</head>

		<body>

		<div id="mapid" style="width: 600px; height: 400px;"></div>
		<script>

			var mymap = L.map('mapid').setView([-1.3822205057221049, 47.60050024500212], 13);

			L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
				maxZoom: 18,
				attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
					'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
					'Imagery © <a href="http://mapbox.com">Mapbox</a>',
				id: 'mapbox.streets'
			}).addTo(mymap);

			L.marker([-1.38, 47.60]).addTo(mymap)
				.bindPopup("<b>Hello world!</b><br />I am a popup.").openPopup();

			L.circle([51.508, -0.11], 500, {
				color: 'red',
				fillColor: '#f03',
				fillOpacity: 0.5
			}).addTo(mymap).bindPopup("I am a circle.");

			L.polygon([
				[51.509, -0.08],
				[51.503, -0.06],
				[51.51, -0.047]
			]).addTo(mymap).bindPopup("I am a polygon.");


			var popup = L.popup();

			function onMapClick(e) {
				popup
					.setLatLng(e.latlng)
					.setContent("You clicked the map at " + e.latlng.toString())
					.openOn(mymap);
			}

			mymap.on('click', onMapClick);

		</script>
		</body>
	</html>
END;




