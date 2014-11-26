<?php
include('db.inc.php');

/* Inicio CRUD Campana */

function readCampana() {
	$link = mycon();

	// La query debe mostrar la campanaña y las sucursales asociadas, sin embargo debe existir cierta logica para
	// saber cual campaña se debe seleccionar (deben existir mas de una activa y quizás chocan con los criterios
	$query = 'SELECT
				id, Empresa_id, nombre, descripcion, fechaIngreso, distanciaCampana, fechaInicio, fechaFin, Estado_id
			  FROM Campana
			  WHERE Estado_id = 1';
	$resultado = mysql_query($query,$link);
	$row = mysql_fetch_assoc($resultado);
	
	$a = array_merge($row,array('Sucursales' => readCampanaSucursal()));
	
	return json_encode($a);
	mysql_close($link);
}

function readCampanaSucursal() {
	$link = mycon();
	
	$query = 'SELECT a.id, a.Sucursal_id, b.nombre, a.Campana_id
			FROM CampanaSucursal a, Sucursal b
			WHERE a.Campana_id = 1';
	$resultado = mysql_query($query,$link);
	//$row = mysql_fetch_assoc($resultado);
	
	$arr = array();
	
	while($row = mysql_fetch_assoc($resultado)) { 
		$arr[] = $row;
	}
	return $arr;
}

function createCampana() {
// no se requiere
}

function updateCampana() {
// no se requiere
}

function deleteCampana() {
// no se requiere
}

/* Fin CRUD Campana */


/* Inicio CRUD Usuarios */

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

function readCategoria() {
	
	$link = mycon();
	
	$query = 'SELECT 
				id, nombre, descripcion
			  FROM Categoria ';
	
	$resultado = mysql_query($query,$link);
	$arr = array();
	
	while($row = mysql_fetch_assoc($resultado)) { 
		$arr[] = $row;
	}
	return json_encode($arr);
	
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

function readSucursal($idEmpresa) {
	$link = mycon();
	$query = "SELECT id, nombre FROM Sucursal WHERE idEmpresa = ".$idEmpresa."";
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
