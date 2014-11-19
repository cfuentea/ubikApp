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

if(!isset($_POST)) {
	sendResponse(400,'Invalid request');
	return false;
} else {
	switch($_POST['metodo']) {

		case "readUsuario":
			echo readUsuario($_POST['id']);
			break;
		
		case "createUsuario":
			echo createUsuario($_POST['datos']);
			break;
		
		case "updateUsuario":
			echo updateUsuario($_POST['id'],$_POST['datos']);
			break;
		case "deleteUsuario":
			echo deleteUsuario($_POST['id']);
			break;
		case "readCategoria":
			echo readCategoria();
			break;
	}
}

?>
