<?php
include('db.inc.php');
include('base_helper.php');

// Mostramos errores
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

/*
 Inicio funciones App Android - Usuario
 */
 
 function createUsuarioApp($nombre, $apellido, $fechaNac, $email, $uuid) {
 	$query = 'SELECT 
 	id, nombres, apellidos, email, fechaNacimiento, hashValidacion
 	FROM Usuario 
 	WHERE hashValidacion = '.$uuid.'';
 	$resultado = mysql_query($query, $link);
 	if( mysql_num_rows($resultado) > 0) {
 		$query = 'UPDATE Usuario SET 
 		nombres = "'.$nombre.'",
 		apellidos = "'.$apellido.'",
 		email = "'.$email.'",
 		fechaNacimiento = "'.$fechaNac.'"
 		WHERE
 		hashValidacion = "'.$uuid.'"';
 		$resultado = mysql_query($query, $link);
 	}
 	else
 	{
 		$query = 'INSERT INTO Usuario 
 		(nombres, apellidos, email, fechaNacimiento, hashValidacion) 
 		VALUES 
 		("'.$nombre.'","'.$apellido.'","'.$email.'","'.$fechaNac.'","'.$uuid.'")';
 		$resultado = mysql_query($query, $link);
 	}
 	return '{"resultado":"ok"}';
 }

// Al estar insertado este registro no se vuelve a enviar dicha campaña (valoracion es el codigo aleatorio generado por la app)
 function InsCampanaUsuario($idCampana, $uuid, $valoracion){
 	$query = 'SELECT 
 	id, nombres, apellidos, email, fechaNacimiento, hashValidacion
 	FROM Usuario 
 	WHERE hashValidacion = '.$uuid.'';
 	$resultado = mysql_query($query, $link);
 	$row = mysql_fetch_assoc($resultado);
 	$query = 'INSERT INTO Usuario 
 	(Usuario_id, Campana_id, valoracion) 
 	VALUES 
 	('.$row['id'].','.$idCampana.',"'.$valoracion.'")';
 	$resultado = mysql_query($query, $link);
 	return '{"resultado":"ok"}';

 }

/*
 Inicio CRUD Campana 
 */

 function readCampana() {
 	global $link;

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
 	
 }

 function readCampanaSucursal() {
 	global $link;
 	
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
 	
 	global $link;
 	$query = 'SELECT 
 	id, nombre, descripcion
 	FROM Categoria ';
 	
 	$resultado = mysql_query($query,$link);
 	$arr = array();
 	
 	while($row = mysql_fetch_assoc($resultado)) { 
 		$arr[] = $row;
 	}
 	return json_encode($arr);
 	
 	
 }

 function createCategoria($datoJSON) {
 	global $link;
 	$arr = json_decode($datoJSON, true);
 	
 	$nombre = $arr['nombre'];
 	$descripcion = $arr['descripcion'];
 	
 	$query = 'INSERT INTO Categoria (nombre, descripcion, ownerIngreso, fechaIngreso)
 	VALUES ("'.$nombre.'","'.$descripcion.'","WS-user",now())';

 	$resultado = mysql_query($query,$link);
 	return '{"resultado":"ok"}';
 	
 	
 }

 function updateCategoria($datoJSON) {
 	global $link;
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
 	
 	
 }

 function deleteCategoria($id) {
 	global $link;
 	$query = 'DELETE FROM Categoria WHERE id = '.$id.'';
 	$resultado = mysql_query($query,$link);
 	return '{"resultado":"ok"}';
 	
 }

/*
 Fin CRUD Categorias 
 */

/*
 Inicio CRUD Usuarios 
 */

 function readUsuario($idUsuario) {
 	global $link;
 	
 	$query = 'SELECT 
 	id, nombres, apellidos,email,fechaNacimiento, Comuna_id, password, fechaRegistro
 	FROM Usuario 
 	WHERE id = '.$idUsuario.'';
 	
 	$resultado = mysql_query($query,$link);
 	$row = mysql_fetch_assoc($resultado); 
 	return json_encode($row);
 	
 }



 function createUsuario($datoJSON) {
 	
	/* Como funcion adicional, el resultado debe entregar el ID del usuario que creó
	 * para esto, debemos definir un ID único (podría ser el email) con el cual
	 * verificar cual es el ID del usuario recién creado
	 *
	 * update 14/12/2014: usar mysql_insert_id(); para obtener ultimo id incremental
	 */
	
	global $link;
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

}

function updateUsuario($idUsuario,$datoJSON) {

	global $link;
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
	

}

function deleteUsuario($idUsuario) {
	global $link;

	$query = 'DELETE FROM Usuario WHERE id = '.$idUsuario.'';
	$resultado = mysql_query($query,$link);
	return '{"resultado":"ok"}';
}

function readCliente($rut) {
	global $link;

	$query = 'SELECT nombreFantasia FROM Empresa WHERE rut = "'.$rut.'"';
	$resultado = mysql_query($query,$link);
	$row = mysql_fetch_assoc($resultado);
	
	return $row['nombreFantasia']; 
}

function loginClientes($rut,$pwd) {
	global $link;
	
	$query = 'SELECT count(*) as cant, rut FROM Empresa WHERE rut = "'.$rut.'" AND password = "'.$pwd.'"';
	$resultado = mysql_query($query,$link);
	$a = mysql_fetch_assoc($resultado);
	
	return $a['rut'];
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
	global $link;
	$query = "SELECT id, nombre FROM Categoria";
	$resultado = mysql_query($query,$link);
	
	while($row = mysql_fetch_assoc($resultado)) {
		echo '
		<div class="checkbox">
		<label>
		<input type="checkbox" value="'.$row['id'].'" name="categoria['.$row['id'].']">'.$row['nombre'].'
		</label>
		</div>
		';
	}
	
	
}

function createSucursal($userId, $arreglo) {
	
	global $link;
	
	$nombre = $arreglo['nombre'];
	$direccion = $arreglo['formatted_address'];
	$tipoSucursal = $arreglo['tipoSucursal'];
	$localidad = getComuna($arreglo['locality']);

	
	$query = 'INSERT INTO Sucursal 
	(idEmpresa, nombre, direccion, Comuna_id, tipoSucursal, fechaIngreso, ownerIngreso, latitud, longitud)
	VALUES
	('.$userId.', "'.$nombre.'", "'.$direccion.'", '.$localidad.', "'.$tipoSucursal.'", now(), "Form_WEB", 
		'.$arreglo['lat'].','.$arreglo['lng'].')';

$resultado = mysql_query($query,$link);
$id = mysql_insert_id();

return $id;

}

function readSucursal($idEmpresa) {
	global $link;
	$query = "SELECT id, nombre FROM Sucursal WHERE idEmpresa = ".$idEmpresa."";
	$resultado = mysql_query($query,$link);
	
	while($row = mysql_fetch_assoc($resultado)) {
		echo '
		<div class="checkbox">
		<label>
		<input type="checkbox" value="'.$row['id'].'" name="sucursal['.$row['id'].']">'.$row['nombre'].'
		</label>
		</div>
		';
	}
	
	
}

function getIdEmpresa($id) {

	global $link;
	$query = "SELECT id FROM Empresa WHERE rut = ".$id."";
	$resultado = mysql_query($query,$link);
	
	$r = mysql_fetch_assoc($resultado);

	return $r['id'];
	
	
}

function createCampana($userId, $arreglo) {
	
	global $link;
	
	$nombre = $arreglo['nombre'];
	$descripcion = $arreglo['descripcion'];
	$fechaInicio = $arreglo['fechaInicio'];
	$fechaFin = $arreglo['fechaFin'];
	$categoria = $arreglo['categoria'];
	$sucursal = $arreglo['sucursal'];
	
	$query = 'INSERT INTO Campana 
	(Empresa_id, nombre, descripcion, fechaIngreso, distanciaCampana, fechaInicio, fechaFin, Estado_id)
	VALUES
	('.$userId.', "'.$nombre.'", "'.$descripcion.'", now(), 500, 
		STR_TO_DATE("'.$fechaInicio.'","%Y-%m-%d"), STR_TO_DATE("'.$fechaFin.'","%Y-%m-%d"), 3)';
$resultado = mysql_query($query,$link);

$id = mysql_insert_id();

foreach($categoria as $k => $v) {
	$sql = 'INSERT INTO CampanaCategoria (Categoria_id, Campana_id) 
	VALUES
	( '.$k.', '.$id.')'; 
	$result = mysql_query($sql,$link);
}

foreach($sucursal as $k => $v) {
	$sql = 'INSERT INTO CampanaSucursal (Sucursal_id, Campana_id) 
	VALUES
	( '.$k.', '.$id.')'; 
	$result = mysql_query($sql,$link);
}

}

function checkStatusCampana($id,$idCampana) {
	global $link;
	$query = "SELECT id, nombreEstado FROM Estado WHERE id = ".$id." ";
	$resultado = mysql_query($query,$link);
	$row = mysql_fetch_assoc($resultado);

	if($row['id'] == 1) {
		return "<a href='?id=".$idCampana."&op=deshab'><button style='background-color: red; color:white;' type='button'>Deshabilitar</button></a>";
	} else {
		return "<a href='?id=".$idCampana."&op=hab'><button style='background-color: green; color:white;' type='button'>Habilitar</button></a>";
	}
}

function listarCampanaEditar($idEmpresa) {
	global $link;
	$query = 'SELECT id, nombre, descripcion,Estado_id FROM Campana WHERE Empresa_id = '.$idEmpresa.'';
	$resultado = mysql_query($query,$link);
	
	echo '<table border="0" width="100%">
	<tr align="center" bgcolor="#ccc">
	<td>Nro</td>
	<td>&nbsp;Nombre Campa&ntilde;a&nbsp;</td>
	<td>Descripcion</td>
	<td></td>
	<td></td>
	</tr>';
	
	while($row = mysql_fetch_assoc($resultado)) {
		echo '<tr>
		<td>'.$row['id'].'</td>
		<td>'.$row['nombre'].'</td>
		<td>'.$row['descripcion'].'</td>
		<td><a href="#"><button type="button">Editar</button></a></td>
		<td>'.checkStatusCampana($row['Estado_id'],$row['id']).'</td>				
		</tr>';
	}
	echo '</table>';
}

function updateEstado($id,$op) {
	global $link;
	
	if($op == "hab") {
		$op = 1;
	} elseif($op == "deshab") {
		$op = 3;
	}

	$query = "UPDATE Campana
	SET Estado_id = ".$op."
	WHERE id = ".$id."
	LIMIT 1";

	$resultado = mysql_query($query,$link);
}

function listarSucursalEditar($idEmpresa) {
	global $link;
	$query = 'SELECT id,idEmpresa, nombre, direccion, tipoSucursal, Comuna_id 
	FROM Sucursal WHERE idEmpresa = '.$idEmpresa.'';
	$resultado = mysql_query($query,$link);
	
	echo '<table border="0" width="100%">
	<tr align="center" bgcolor="#ccc">
	<td>Nro</td>
	<td>&nbsp;Nombre Sucursal&nbsp;</td>
	<td>Direcci&oacute;n</td>
	<td>Tipo de Sucursal</td>
	<td>Comuna</td>
	<td></td>
	<td></td>
	</tr>';
	
	while($row = mysql_fetch_assoc($resultado)) {
		echo '<tr>
		<td>'.$row['id'].'</td>
		<td>'.$row['nombre'].'</td>
		<td>'.$row['direccion'].'</td>
		<td>'.$row['tipoSucursal'].'</td>
		<td>'.$row['Comuna_id'].'</td>
		<td><a href="#"><button type="button">Editar</button></a></td>
		<td><a href="#"><button type="button" style="background-color: red; color:white;">Eliminar</button></a></td>			
		</tr>';
	}
	echo '</table>';
}

function editarCampana($idCampana) {
	global $link;
	$query = 'SELECT a.id, a.Empresa_id, a.nombre, a.descripcion, a.fechaInicio, a.fechaFin, a.Estado_id
	FROM Campana a, CampanaCategoria b, CampanaSucursal c
	WHERE a.id = '.$idCampana.' ';
	
	
}

function listarCiudad() {
	global $link;
	$query = "SELECT id, nombre FROM Ciudad";
	$resultado = mysql_query($query,$link);

	while($row = mysql_fetch_assoc($resultado)) {
		echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>\n';
	}

}


function getComuna($nombreComuna) {
	global $link;
	$query = "SELECT id from Comuna WHERE nombre like '%".$nombreComuna."%'";
	$resultado = mysql_query($query,$link);

	$row = mysql_fetch_assoc($resultado);

	return $row['id'];
}

/*************************************
 *	Métodos de UbikMe
 *************************************/

function existeCampanaActiva() {

	/*	Verifica si hay campañas activas */
	
	global $link;
	$query = "SELECT * FROM Campana
	WHERE Estado_id = 1";
	return mysql_query($query,$link) ? false : true;

}


function ubikMe($id,$categoriaJSON, $posicionJSON) {
	
	/* 	esta funcion debe ser capaz de recibir parametros y traducirlos en envío de campañas
		adicionalmente debe dejar un registro de las campañas que se envían en un log (registro BBDD)
	*/
		$posicion = json_decode($posicionJSON);

		if(existeCampanaActiva()) {
		// si existen campañas activas
			if(distancia($latA,$lngA,$latB,$lngB,"K")<0.5) {
			// si la distancia entre campaña 1 vs posicion usuario es menor a 0.5 Km

			}
		}
		return '{"resultado":"sin match"}';
		break;

		$campanaActiva = verificarCampanaActiva();
		
		if($campanaActiva) {
			$distanciaCampana = distancia($posicionJSON,distanciaCampanaActiva());

			/* distancia base para cercania entre punto A y B (en KM) */
			
			while($distanciaCampana < 0.5) {
				if(compararCategorias($categoriaJSON,$categoriaCampanaActiva)) {
					return enviaCampanaMatch();
					logTransaccion($id,idCampanaActiva());
				}
			}
		}
	}

	?>
