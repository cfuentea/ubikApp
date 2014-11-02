<?php
include('db.inc.php');

function getUsuario($idUsuario) {
	$link = mycon();
	$query = 'SELECT 
				id, nombres, apellidos,email,fechaNacimiento, Comuna_id, fechaRegistro 
			  FROM Usuario 
			  	WHERE id = '.$idUsuario.'';
	$resultado = mysql_query($query,$link);
	$row = mysql_fetch_assoc($resultado); 
	return json_encode($row);
	mysql_close($link);
}

function addUsuario($datoJSON) {
/* Ejemplo formato
	{"nombre":"Lorena","apellido":"Dupuy","email":"ldupuy@email.com",
	 "fechaNacimiento":"2008-10-01 00:00:00","idComuna":"1","password":"prueba1234"}
*/
	$link = mycon();
	$arr = json_decode($datoJSON, true);
	
	$nombre = $arr['nombre'];
	$apellido = $arr['apellido'];
	$email = $arr['email'];
	$fechaNacimiento = $arr['fechaNacimiento'];
	$idComuna = $arr['idComuna'];
	$password = $arr['password'];
	$fechaRegistro = "now()";
		
    $query = 'INSERT INTO Usuario (nombres, apellidos, email, fechaNacimiento, Comuna_id, password, fechaRegistro) 
				VALUES 
			("'.$nombre.'","'.$apellido.'","'.$email.'",'.$fechaNacimiento.','.$idComuna.','.$password.','.$fechaRegistro.')';
			
        $resultado = mysql_query($query,$link);
        return '{"resultado":"ok"}';
        mysql_close($link);
}

?>
