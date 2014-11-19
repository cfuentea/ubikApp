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
	
	/* Como funcion adicional, el resultado debe entregar el ID del usuario que creó
	 * para esto, debemos definir un ID único (podría ser el email) con el cual
	 * verificar cual es el ID del usuario recién creado
	 */
	 
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

function readCliente($rut) {
	
	$link = mycon();
	$query = 'SELECT nombreFantasia FROM Empresa WHERE rut = "'.$rut.'"';
	$resultado = mysql_query($query,$link);
	$row = mysql_fetch_assoc($resultado);
	
	return $row['nombreFantasia']; 

	mysql_close($link);
}

function loginClientes($rut,$pwd) {
	$link = mycon();
	$query = 'SELECT count(*) as cant, rut FROM Empresa WHERE rut = "'.$rut.'" AND password = "'.$pwd.'"';
	$resultado = mysql_query($query,$link);
	$a = mysql_fetch_assoc($resultado);
	
	return $a['rut'];
	
	mysql_close($link);
}

function sitioActual() {
	return $_SESSION['pagina'];
}

function sitioActualBold($sesion) {
	if($sesion == $_SESSION['pagina']) {
		return ' style="font-weight: bold" >&raquo; ';
	} else {
		return ' >';
	}
}

function readCategorias() {
	$link = mycon();
	$query = "SELECT id, nombre FROM Categoria";
	$resultado = mysql_query($query,$link);
	
	while($row = mysql_fetch_assoc($resultado)) {
		echo '
			<div class="checkbox">
			<label>
               	<input type="checkbox" value="'.$row['id'].'" name="'.$row['nombre'].'">'.$row['nombre'].'
           	</label>
           	</div>
           	';
	}
	
	mysql_close($link);
}

?>
