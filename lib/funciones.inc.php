<?php
include('db.inc.php');

function obtenerUsuario($idUsuario) {
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
    $query = 'INSERT INTO Usuario (nombres, apellidos, email, Comuna_id) 
				VALUES 
			("'.$dato["nombre"].'","'.$dato["apellido"].'","'.$dato["email"].'",'.$dato["idComuna"].')';
        $resultado = mysql_query($query,$link);
        return '{"resultado":"ok"}';
        mysql_close($link);
}

?>
