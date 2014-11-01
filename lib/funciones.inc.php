<?php
include('db.inc.php');

function getUsuario($idUsuario) {
	$link = mycon();
	$query = 'SELECT id, nombres, apellidos,email,fechaNacimiento FROM Usuario WHERE id = '.$idUsuario.'';
	$resultado = mysql_query($query,$link);
	$row = mysql_fetch_assoc($resultado); 
	return json_encode($row);
	mysql_close($link);
}

function addUsuario($datoJSON) {
	$link = mycon();
	$dato = json_decode($datoJSON, true);
	
	$nombre = $dato['nombre'];
	$apellido = $dato['apellido'];
	$email = $dato['email'];
	$idComuna = $dato['idComuna'];
	
    $query = 'INSERT INTO Usuario (nombres, apellidos, email, Comuna_id) 
				VALUES 
			("'.$nombre.'","'.$apellido.'","'.$email.'",'.$idComuna.')';
			
        $resultado = mysql_query($query,$link);
        return '{"resultado":"ok"}';
        mysql_close($link);
}

?>
