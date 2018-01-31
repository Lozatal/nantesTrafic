<?php

$opts = array('http' => array
	(
	'proxy'=> 'tcp://www-cache.iutnc.univ-lorraine.fr:3128',
	'request_fulluri'=> true
	)
);

$context = stream_context_create($opts);

$str =
	file_get_contents(
		'http://api.loire-atlantique.fr/opendata/1.0/traficevents?filter=Tous',
		NULL,
		$context
	);


$xml = json_decode($str);
var_dump($xml);
