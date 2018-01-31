<?php

$opts = array('http' => array
	(
	'proxy'=> 'tcp://www-cache.iutnc.univ-lorraine.fr:3128',
	'request_fulluri'=> true
	)
);

$context = stream_context_create($opts);

if(isset($_GET['filtre'])){
	$get=$_GET['filtre'];
	if($get=='Pont'){
		$get='Pont%20de%20Saint-Nazaire';
	}elseif($get=='indret'){
		$get='Bac%20de%20Loire%20Basse-Indre%20-%20Indret';
	}elseif($get=='pellerin'){
		$get='Bac%20de%20Loire%20Coueron%20-%20Le%20Pellerin';
	}else{
		$get='Tous';
	}
}else{
	$get='Tous';
}

$str =
	file_get_contents(
		'http://api.loire-atlantique.fr/opendata/1.0/traficevents?filter='.$get,
		NULL,
		$context
	);

?>

<!doctype html>
<html>

<head>
  <meta charset="utf-8"/>
  <title>Info Trafic Loire Atlantique</title>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
	integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
	crossorigin=""/>
	<!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
   integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
   crossorigin=""></script>
</head>

<body style="width: 100%; display: flex; flex-wrap: wrap;">
    <article style="width: 50%;">
			<div id="mapid" style="width: 600px; height: 400px; margin: auto;"></div>
			<script>
				let json = <?php echo $str; ?>;
				var mymap = L.map('mapid').setView([47.217236, -1.553879], 8);
				L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
					maxZoom: 18,
					attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
						'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
						'Imagery © <a href="http://mapbox.com">Mapbox</a>',
					id: 'mapbox.streets'
				}).addTo(mymap);

				json.forEach((activite)=>{
					let long = activite.longitude;
					let lat = activite.latitude;
					let date = activite.datePublication;
					let rattachement = activite.rattachement;
					let nature = activite.nature;
					let type = activite.type;
					let statut = activite.statut;

					let ligne1 = activite.ligne1;

					let texte='Date: '+date+'<br>Rattachement: '+rattachement+'<br>Nature: '+nature+'<br>Type: '+type+'<br>Statut: '+statut+'<br>ligne1: '+ligne1;

					if(activite.ligne2 != null){
						let ligne2 = activite.ligne2;
						texte+='<br>ligne2: '+ligne2;
					}
					if(activite.ligne3 != null){
						let ligne3 = activite.ligne3;
						texte+='<br>ligne3: '+ligne3;
					}
					if(activite.ligne4 != null){
						let ligne4 = activite.ligne4;
						texte+='<br>ligne4: '+ligne4;
					}
					if(activite.ligne5 != null){
						let ligne5 = activite.ligne5;
						texte+='<br>ligne5: '+ligne5;
					}
					if(activite.ligne6 != null){
						let ligne6 = activite.ligne6;
						texte+='<br>ligne6: '+ligne6;
					}


					L.marker([lat, long]).addTo(mymap)
						.bindPopup(texte).openPopup();
				});

				var popup = L.popup();

				function onMapClick(e) {
					popup
						.setLatLng(e.latlng)
						.setContent("You clicked the map at " + e.latlng.toString())
						.openOn(mymap);
				}

				mymap.on('click', onMapClick);
			</script>
    </article>
    <article style="width: 50%;">
			<p>Options de filtrage</p>
			<ul>
			<li><a href="?filtre=tous">Tous</a></li>
			<li><a href="?filtre=pont">Pont de Saint-Nazaire</a></li>
			<li><a href="?filtre=indret">Bac de Loire Basse-Indre - Indret</a></li>
			<li><a href="?filtre=pellerin">Bac de Loire Coueron - Le Pellerin</a></li>
			</ul>
    </article>
</body>
</html>
