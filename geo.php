<?php
include('lib/funciones.inc.php');

// Latitud y longitud de local A
// Lira 140, Santiago => -33.444625,-70.640579
$lat1 = "-33.444000";
$lng1 ="-70.657520";

// Latitud y longitud de posicion usuario
// Portugal 48, Santiago => -33.44144,-70.639178
$lat2 = "-33.443951";
$lng2 = "-70.657524";

//echo distancia($lat1,$lng1,$lat2,$lng2,"K");

if(0.0054616116964508<0.5) {
	echo "Es menor";
} else {
	echo "Es mayor";
}
/* calcular funcion UbikMe();
	
	1. recibir parametros (lat,lng,categorias{json},id{usuario})
	2. verificar si hay campañas activas
		2.1 de las campañas activas (en un ciclo) obtener lat y lng
		2.2 comparar con lat y lng enviada por parametros por el usuario y verificar si cumple politica (<500mts)
			2.2.1 verificar si la campaña que calza con parametros, cuenta con categorias seleccionadas (en ciclo)
*/


?>