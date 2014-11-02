<?php
include('db.inc.php');

function readUsuario($idUsuario) {
	$link = mycon();
	
	$query = 'SELECT 
				id, nombres, apellidos,email,fechaNacimiento, Comuna_id, password, fechaRegistro
			  FROM Usuario 
			  	WHERE id = '.$idUsuario.'';
	
	$resultado = mysql_query($query,$link);
	$row = mysql_fetch_assoc($resultado); 
	return json_encode($row);
	mysql_close($link);
}

function createUsuario($datoJSON) {

	$link = mycon();
	$arr = json_decode($datoJSON, true);
	
	$nombre = $arr['nombre'];
	$apellido = $arr['apellido'];
	$email = $arr['email'];
	$fechaNacimiento = $arr['fechaNacimiento'];
	$Comuna_id = $arr['Comuna_id'];
	$password = $arr['password'];
	$fechaRegistro = "now()";
		
    $query = 'INSERT INTO Usuario 
    		(nombres, apellidos, email, fechaNacimiento, Comuna_id, password, fechaRegistro) 
				VALUES 
			("'.$nombre.'","'.$apellido.'","'.$email.'","'.$fechaNacimiento.'",
			  '.$Comuna_id.',"'.$password.'",'.$fechaRegistro.')';
			
    $resultado = mysql_query($query,$link);
    return '{"resultado":"ok"}';
    mysql_close($link);
}

function updateUsuario($idUsuario,$datoJSON) {

	$link = mycon();
	$arr = json_decode($datoJSON, true);
	
	$nombre = $arr['nombre'];
	$apellido = $arr['apellido'];
	$email = $arr['email'];
	$fechaNacimiento = $arr['fechaNacimiento'];
	$Comuna_id = $arr['Comuna_id'];
	$password = $arr['password'];
	
	$query = 'UPDATE Usuario SET 
				nombres = "'.$nombre.'",
				apellidos = "'.$apellido.'",
				email = "'.$email.'",
				fechaNacimiento = "'.$fechaNacimiento.'",
				Comuna_id = '.$Comuna_id.',
				password = "'.$password.'"
			WHERE
				id = '.$idUsuario.'';

	$resultado = mysql_query($query,$link);
    return '{"resultado":"ok"}';
    mysql_close($link);

}

function deleteUsuario($idUsuario) {

	$link = mycon();
	$query = 'DELETE FROM Usuario WHERE id = '.$idUsuario.'';
	$resultado = mysql_query($query,$link);
	return '{"resultado":"ok"}';
    mysql_close($link);

}

?>
