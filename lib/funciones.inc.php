<?php
include('db.inc.php');

// Mostramos errores

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


/*
 Inicio CRUD Campana 
 */

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

/*
 Fin CRUD Campana 
 */

/*
 Inicio CRUD Categorias 
 */

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

function createCategoria($datoJSON) {
	$link = mycon();
	$arr = json_decode($datoJSON, true);
	
	$nombre = $arr['nombre'];
	$descripcion = $arr['descripcion'];
	
	$query = 'INSERT INTO Categoria (nombre, descripcion, ownerIngreso, fechaIngreso)
	VALUES ("'.$nombre.'","'.$descripcion.'","WS-user",now())';

	$resultado = mysql_query($query,$link);
    return '{"resultado":"ok"}';
    mysql_close($link);
	
}

function updateCategoria($datoJSON) {
	$link = mycon();
	$arr = json_decode($datoJSON, true);
	
	$id = $arr['id'];
	$nombre = $arr['nombre'];
	$apellido = $arr['descripcion'];
	
	$query = 'UPDATE Categoria SET 
				nombre = "'.$nombre.'",
				descripcion = "'.$apellido.'",
				ownerEdicion = "WS-user",
				fechaEdicion = now()
			WHERE
				id = '.$id.'';

	$resultado = mysql_query($query,$link);
    return '{"resultado":"ok"}';
    mysql_close($link);
	
}

function deleteCategoria($id) {
	$link = mycon();
	$query = 'DELETE FROM Categoria WHERE id = '.$id.'';
	$resultado = mysql_query($query,$link);
	return '{"resultado":"ok"}';
    mysql_close($link);
}

/*
 Fin CRUD Categorias 
 */

/*
 Inicio CRUD Usuarios 
 */

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
               	<input type="checkbox" value="'.$row['id'].'-'.$row['nombre'].'" name="categoria_'.$row['id'].'">'.$row['nombre'].'
           	</label>
           	</div>
           	';
	}
	
	mysql_close($link);
}

function createSucursal($userId, $arreglo) {
	
	$link = mycon();
	
	$nombre = $arreglo['nombre'];
	$descripcion = $arreglo['descripcion'];
	$fechaInicio = $arreglo['fechaInicio'];
	$fechaFin = $arreglo['fechaFin'];
	
	
	$query = 'INSERT INTO Campana 
				(idEmpresa, nombre, direccion, Comuna_id, tipoSucursal, fechaIngreso, ownerIngreso)
			  VALUES
				('.$userId.', "'.$nombre.'", "'.$descripcion.'", now(), 500, STR_TO_DATE("'.$fechaInicio.'","%Y-%m-%d"), STR_TO_DATE("'.$fechaFin.'","%Y-%m-%d"), 3)';
	$resultado = mysql_query($query,$link);
	
	$queryLastRecord = 'SELECT max(id) as id FROM Campana LIMIT 1';
	$resultadoLR = mysql_query($queryLastRecord,$link);
	
	$row = mysql_fetch_assoc($resultadoLR);
	
	return $row['id'];

}

function readSucursal($idEmpresa) {
	$link = mycon();
	$query = "SELECT id, nombre FROM Sucursal WHERE idEmpresa = ".$idEmpresa."";
	$resultado = mysql_query($query,$link);
	
	while($row = mysql_fetch_assoc($resultado)) {
		echo '
			<div class="checkbox">
			<label>
               	<input type="checkbox" value="'.$row['id'].'-'.$row['nombre'].'" name="sucursal_'.$row['id'].'">'.$row['nombre'].'
           	</label>
           	</div>
           	';
	}
	
	mysql_close($link);	
}

function getIdEmpresa($id) {

	$link = mycon();
	$query = "SELECT id FROM Empresa WHERE rut = ".$id."";
	$resultado = mysql_query($query,$link);
	
	$r = mysql_fetch_assoc($resultado);

	return $r['id'];
	
	mysql_close($link);
}

function createCampana($userId, $arreglo) {
	
	$link = mycon();
	
	$nombre = $arreglo['nombre'];
	$descripcion = $arreglo['descripcion'];
	$fechaInicio = $arreglo['fechaInicio'];
	$fechaFin = $arreglo['fechaFin'];
	
	
	$query = 'INSERT INTO Campana 
				(Empresa_id, nombre, descripcion, fechaIngreso, distanciaCampana, fechaInicio, fechaFin, Estado_id)
			  VALUES
				('.$userId.', "'.$nombre.'", "'.$descripcion.'", now(), 500, STR_TO_DATE("'.$fechaInicio.'","%Y-%m-%d"), STR_TO_DATE("'.$fechaFin.'","%Y-%m-%d"), 3)';
	$resultado = mysql_query($query,$link);
	
	$queryLastRecord = 'SELECT max(id) as id FROM Campana LIMIT 1';
	$resultadoLR = mysql_query($queryLastRecord,$link);
	
	$row = mysql_fetch_assoc($resultadoLR);
	
	return $row['id'];

}

function listarCampanaEditar($idEmpresa) {
	$link = mycon();
	$query = 'SELECT id, nombre, descripcion FROM Campana WHERE Empresa_id = '.$idEmpresa.'';
	$resultado = mysql_query($query,$link);
	
	echo '<table border="0" >
			<tr align="center" bgcolor="#ccc">
				<td>Nro</td><td>&nbsp;Nombre Campa&ntilde;a&nbsp;</td><td>Descripcion</td><td>Accion 1</td><td>Accion 2</td>
			</tr>';
			
	while($row = mysql_fetch_assoc($resultado)) {
		echo '<tr>
				<td>'.$row['id'].'</td><td>'.$row['nombre'].'</td><td>'.$row['descripcion'].'</td><td>[ Editar ]</td><td>[ Activar / Desactivar]</td>				
			  </tr>';
	}
	echo '</table>';
}

function listarSucursalEditar($idEmpresa) {
	$link = mycon();
	$query = 'SELECT id,idEmpresa, nombre, direccion, tipoSucursal, Comuna_id FROM Sucursal WHERE idEmpresa = '.$idEmpresa.'';
	$resultado = mysql_query($query,$link);
	
	echo '<table border="0" >
			<tr align="center" bgcolor="#ccc">
				<td>Nro</td><td>&nbsp;Nombre Sucursal&nbsp;</td><td>Direcci&oacute;n</td><td>Tipo de Sucursal</td><td>Comuna</td>
			</tr>';
			
	while($row = mysql_fetch_assoc($resultado)) {
		echo '<tr>
				<td>'.$row['id'].'</td><td>'.$row['nombre'].'</td><td>'.$row['direccion'].'</td><td>'.$row['tipoSucursal'].'</td><td>'.$row['Comuna_id'].'</td>				
			  </tr>';
	}
	echo '</table>';
}

function editarCampana($idCampana) {
	$link = mycon();
	$query = 'SELECT a.id, a.Empresa_id, a.nombre, a.descripcion, a.fechaInicio, a.fechaFin, a.Estado_id
				FROM Campana a, CampanaCategoria b, CampanaSucursal c
				WHERE a.id = '.$idCampana.' ';
	
	
	
}

function ubikMe($id,$posicionJSON) {
	
	// esta funcion debe ser capaz de recibir parametros y traducirlos en envío de campañas
	// adicionalmente debe dejar un registro de las campañas que se envían en un log (registro BBDD)
	
	
}

?>
