<?php
include('db.inc.php');
include('base_helper.php');

// Mostramos errores
/*ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
*/

/*
 Inicio funciones App Android - Usuario
 */

 function createUsuarioApp($nombre, $apellido, $fechaNac, $email, $uuid) {
 	global $link;

 	$query = 'SELECT id, nombres, apellidos, email, fechaNacimiento, ultimoAcceso, hashValidacion
 				FROM Usuario 
 				WHERE hashValidacion like "'.$uuid.'"';
 	$resultado = mysql_query($query, $link);
 	
 	if(mysql_num_rows($resultado) > 0) {
 		$query = 'UPDATE Usuario SET 
 						nombres = "'.$nombre.'",
 						apellidos = "'.$apellido.'",
 						email = "'.$email.'",
 						fechaNacimiento = STR_TO_DATE("'.$fechaNac.'","%Y-%m-%d"),
 						ultimoAcceso = now()
 					WHERE
 						hashValidacion = "'.$uuid.'"';
 		$resultado = mysql_query($query, $link);

 		return '{"resultado":"update_ok"}';
 	}
 	else
 	{
 		$query = 'INSERT INTO Usuario 
 					(nombres, apellidos, email, fechaNacimiento, Comuna_id, hashValidacion, fechaRegistro) 
 				VALUES 
 					("'.$nombre.'","'.$apellido.'","'.$email.'",STR_TO_DATE("'.$fechaNac.'","%Y-%m-%d"),70,"'.$uuid.'",now())';
 		$resultado = mysql_query($query, $link);

 		//echo $query;
 		return '{"resultado":"insert_ok"}';
 	}
 	
 }

// Al estar insertado este registro no se vuelve a enviar dicha campaña (valoracion es el codigo aleatorio generado por la app)

 function InsCampanaUsuario($idCampana, $uuid, $valoracion) {
 	global $link;

 	$query = 'SELECT 
 				id, nombres, apellidos, email, fechaNacimiento, hashValidacion
 				FROM Usuario 
 				WHERE hashValidacion like "'.$uuid.'"';
 	$resultado = mysql_query($query, $link);
 	$row = mysql_fetch_assoc($resultado);
 	
 	$query = 'INSERT INTO UsuarioCampana
 				(Usuario_id, Campana_id, fechaUso, valoracion) 
 				VALUES 
 				('.$row['id'].','.$idCampana.',now(), "'.$valoracion.'")';
 	$resultado = mysql_query($query, $link);
 	
 	return '{"resultado":"ok"}';

 }

/* Inicio funciones cyanez*/
function createEmpresa($datoJSON) {

	/* Como funcion adicional, el resultado debe entregar el ID del usuario que creó
	 * para esto, debemos definir un ID único (podría ser el email) con el cual
	 * verificar cual es el ID del usuario recién creado
	 *
	 * update 14/12/2014: usar mysql_insert_id(); para obtener ultimo id incremental
	 */

	global $link;
	$arr = json_decode($datoJSON, true);
	
	$nombre = $arr['nombre'];
	$nombreFantasia = $arr['nombreFantasia'];
	$rut = $arr['rut'];
	$direccionCasaCentral = $arr['direccionCasaCentral'];
	$telefoFijo = $arr['telefoFijo'];
	$representanteLegal = $arr['representanteLegal'];
	$emailContacto = $arr['emailContacto'];
	$fechaIngreso = "now()";
	$password = $arr['password'];

	$query = 'INSERT INTO Empresa 
	(nombre, nombreFantasia, rut, direccionCasaCentral, telefoFijo, representanteLegal, emailContacto, fechaIngreso, password) 
	VALUES 
	("'.$nombre.'","'.$nombreFantasia.'","'.$rut.'","'.$direccionCasaCentral.'",
		'.$telefoFijo.',"'.$representanteLegal.'","'.$emailContacto.'",'.$fechaIngreso.',"'.$password.'")';

	$resultado = mysql_query($query,$link);
	return '{"resultado":"ok"}';

}

function updateEmpresa($idUsuario,$datoJSON) {

	global $link;
	$arr = json_decode($datoJSON, true);
	
	$nombre = $arr['nombre'];
	$nombreFantasia = $arr['nombreFantasia'];
	$rut = $arr['rut'];
	$direccionCasaCentral = $arr['direccionCasaCentral'];
	$telefonoFijo = $arr['telefonoFijo'];
	$representanteLegal = $arr['representanteLegal'];
	$emailContacto = $arr['emailContacto'];
	$fechaIngreso = "now()"; 
	$password = $arr['password'];
	
	$query = 'UPDATE Empresa SET 
	nombre = "'.$nombre.'",
	nombreFantasia = "'.$nombreFantasia.'",
	rut = "'.$rut.'",
	direccionCasaCentral = "'.$direccionCasaCentral.'",
	telefonoFijo = "'.$telefonoFijo.'",
	representanteLegal = "'.$representanteLegal.'",
	emailContacto = "'.$emailContacto.'",
	fechaIngreso = '.$fechaIngreso.',
	password = "'.$password.'"
	WHERE
	id = '.$idUsuario.'';

	//return $query;
	$resultado = mysql_query($query,$link);
	//return '{"resultado":"ok"}';


}

/* Fin funciones cyanez*/

/*
 Inicio CRUD Campana 
 */
function readCampanaSola($id) {
	global $link;

	$query = "SELECT
 				a.id, 
 				a.Empresa_id, 
 				a.nombre, 
 				a.descripcion, 
 				a.fechaIngreso, 
 				a.distanciaCampana, 
 				a.fechaInicio, 
 				a.fechaFin,
 				c.latitud,
 				c.longitud, 
 				a.Estado_id
 	FROM Campana a, CampanaSucursal b, Sucursal c
 	WHERE a.id = ".$id."
 	AND a.id = b.Campana_id
 	AND b.Sucursal_id = c.id";
 	$resultado = mysql_query($query,$link);
 	$row = mysql_fetch_assoc($resultado);

 	return json_encode($row);
}

function readCampana() {
 	global $link;

	// La query debe mostrar la campanaña y las sucursales asociadas, sin embargo debe existir cierta logica para
	// saber cual campaña se debe seleccionar (deben existir mas de una activa y quizás chocan con los criterios
 	$query = 'SELECT
 	id, Empresa_id, nombre, descripcion, fechaIngreso, distanciaCampana, fechaInicio, fechaFin, Estado_id
 	FROM Campana
 	WHERE id = 9';
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
		<td><a href="editCampanaIndividual.php?idCampana='.$row['id'].'"><button type="button">Editar</button></a></td>
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
	<td></td>
	<td></td>
	</tr>';

	while($row = mysql_fetch_assoc($resultado)) {
		echo '<tr style="text-align:center;">
		<td>'.$row['id'].'</td>
		<td>'.$row['nombre'].'</td>
		<td>'.$row['direccion'].'</td>
		<td>'.$row['tipoSucursal'].'</td>
		<td></td>
		<td><a href="?id='.$row['id'].'&op=del"><button type="button" style="background-color: red; color:white;">Eliminar</button></a></td>			
		</tr>';
	}
	echo '</table>';
}

function eliminarSucursal($id) {
	global $link;

	$queryA = "DELETE FROM CampanaSucursal WHERE Sucursal_id = ".$id."";
	$queryB = "DELETE FROM Sucursal WHERE id = ".$id."";
	$resultadoA = mysql_query($queryA,$link);
	$resultadoB = mysql_query($queryB,$link);

	echo $query;
}

function editarCampana($idCampana) {
	global $link;

	$query = 'SELECT a.id, a.Empresa_id, a.nombre, a.descripcion, a.fechaInicio, a.fechaFin, a.Estado_id
				FROM Campana a, CampanaCategoria b, CampanaSucursal c
				WHERE a.id = '.$idCampana.' ';
	
	// funcion pendiente
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
	return mysql_query($query,$link) ? true : false;

}

function ubikMe($uuid, $posicion) {
	
	/* 	esta funcion debe ser capaz de recibir parametros y traducirlos en envío de campañas
		adicionalmente debe dejar un registro de las campañas que se envían en un log (registro BBDD)
	*/
	global $link;
	
	$pos = json_decode($posicion,true);

	$latUser = $pos['lat'];
	$lngUser = $pos['lng'];

	if(existeCampanaActiva()) { // si existen campañas activas
		$query = "SELECT a.id as idCampana, a.Estado_id, b.Sucursal_id, c.id, c.latitud, c.longitud
					FROM Campana a, CampanaSucursal b, Sucursal c
					WHERE a.Estado_id = 1 AND a.id = b.Campana_id AND b.Sucursal_id = c.id";
		$resultado = mysql_query($query,$link);

		while($row = mysql_fetch_assoc($resultado)) {
		// ciclo que recorre Campañas activas y obtiene su Lat;Lng y Categorias
		// las compara y si hacen match, las envía
			if(floatval(distancia($row['latitud'],$row['longitud'],$latUser,$lngUser,"K")) < 0.5) {
			// si la distancia entre campaña 1 vs posicion usuario es menor a 0.5 Km
				echo readCampanaSola($row['idCampana']);
				break; 
			}
		}
	} else {
		return '{"resultado":"sin_match"}';
	}
}

/*
 Estadisticas
 */

function getEstado($estado) {
	global $link;

	$query = "SELECT nombreEstado
				FROM Estado
				WHERE id = ".$estado."";
	$resultado = mysql_query($query,$link);

	$row = mysql_fetch_assoc($resultado);

	return $row['nombreEstado'];
}

function estadisticaArea($idEmpresa) {
	global $link;

	$query = "SELECT count(*) as cant, a.fechaUso
				FROM UsuarioCampana a, Campana b
				WHERE 
					a.Campana_id = b.id AND b.Empresa_id = ".$idEmpresa."
				GROUP BY a.fechaUso";

	$resultado = mysql_query($query,$link);
	
	$rowC = mysql_num_rows($resultado);
	$i = 1;
	//echo "cantidad: ".$rowC;
	echo 'google.load("visualization", "1", {packages:["corechart"]});
      		google.setOnLoadCallback(drawChart);
      		function drawChart() {
        	var data = google.visualization.arrayToDataTable([
          		[\'Año\', \'Uso\'],'."\n";

	while($row = mysql_fetch_assoc($resultado)) {
		if($i < $rowC) {
			$coma = ",";
		} else {
			$coma = "";
		}
		//echo "i==>".$i."\n";
		echo "['".$row['fechaUso']."',".$row['cant']."]".$coma;
		$i++;
	}	

	echo "]);
			
			var options = {
          	title: 'Cantidad de uso de campañas',
          	curveType: 'function',
          	hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          	vAxis: {minValue: 0}
        	};

        	var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        	chart.draw(data, options);
      		}";
}

function estadisticaDona($idEmpresa) {
	global $link;

	$query = "SELECT count(*) as cant, Estado_id
				FROM Campana 
				WHERE Empresa_id = ".$idEmpresa."
				GROUP BY Estado_id";
	
	$resultado = mysql_query($query,$link);
	$rowC = mysql_num_rows($resultado);
	$i = 1;

	echo 'google.load("visualization", "1", {packages:["corechart"]});
      	google.setOnLoadCallback(drawChart);
      	function drawChart() {
        var data = google.visualization.arrayToDataTable([
          [\'Estado\', \'Q\'],'."\n";

    while($row = mysql_fetch_assoc($resultado)) {
		if($i < $rowC) {
			$coma = ",";
		} else {
			$coma = "";
		}
		//echo "i==>".$i."\n";
		echo "['".getEstado($row['Estado_id'])."',".$row['cant']."]".$coma;
		$i++;
	}

	echo "]);

        	var options = {
          		title: 'Estado de Campañas (Q Total)',
          		pieHole: 0.4,
        	};

        	var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        	chart.draw(data, options);
      	}";
}

?>
