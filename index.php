<?php
// Librerias externas
include('lib/error.inc.php');
include('lib/funciones.inc.php');

// Mostramos errores

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
header('Content-Type: application/json');


// Verificar que existan los parametros requeridos

if(!isset($_GET)) {
	sendResponse(400,'Invalid request');
	return false;
} else {
	switch($_GET['metodo']) {

		case "readUsuario":
			echo readUsuario($_GET['id']);
			break;
		
		case "createUsuario":
			echo createUsuario($_GET['datos']);
			break;
		
		case "updateUsuario":
			echo updateUsuario($_GET['id'],$_GET['datos']);
			break;
	
		case "deleteUsuario":
			echo deleteUsuario($_GET['id']);
			break;
	
		case "readCampana":
			echo readCampana();
			break;
	
		case "createCategoria":
			echo createCategoria($_GET['datos']);
			break;
			
		case "updateCategoria":
			echo updateCategoria($_GET['datos']);
			break;

		case "readCategoria":
			echo readCategoria();
			break;

		case "ubikMe":
			echo ubikMe($_GET['id'],$_GET['pos'],$_GET['cat']);
			break;
		
		case "createUsuarioApp":
			echo createUsuarioApp($_GET['nombre'], $_GET['apellido'], $_GET['fechaNac'], $_GET['email'], $_GET['uuid']);
			break;

		case "InsCampanaUsuario":
			echo InsCampanaUsuario($_GET['idCampana'], $_GET['uuid'], $_GET['valoracion']);
			break;
						
		/*	
			case "readCategoria":
			echo readCategoria();
			break;
		*/
	}
}

?>
