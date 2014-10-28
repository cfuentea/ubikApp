<?php
include('errors.php'); /* Include librerias con códigos de errores */
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
header('Content-Type: application/json');

function __autoload($className) {
	include("$className.php");
}
	$datos = new Funciones("localhost","root","","UbikApp");

function mostrar() {

	if(!isset($_POST['method'])) {
		sendResponse(400, 'Invalid request'); 
		return false;
	} 
		else 
	{
		switch($_POST['method']) {
			case 'getUsers':
				print $users->getUsers();		
			break;
		}
		/*
		$stmt = $this->db->prepare('SELECT id, nombres, apellidos,email,fechaNacimiento FROM Usuario WHERE id = ?');
		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$stmt->bind_result($id, $nombres, $apellidos,$email,$fechaNacimiento);
		if($stmt->fetch()) {
			$resultado = array(
				"id" => $id,
				"nombre" => $nombres,
				"apellidos" => $apellidos,
				"email" => $email,
				"fechaNacimiento" => $fechaNacimiento,
			);
			
			// 	Muestro el resultado según codigo HTML 200 OK, 
			//	Adicionalmente se codifica a JSON y se le cambia el Header Type a formato XML
					
			sendResponse(200, json_encode($resultado));
			return true;
		} 
		*/
		$stmt->close();
	
	}

// Modificado debido a cambio en forma en que se realizan consultas

// $app = new Resultado;
// $app->mostrar();

?>
