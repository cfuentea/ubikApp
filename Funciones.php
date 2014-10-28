<?php
include('errors.php'); /* Include librerias con códigos de errores */
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
header('Content-Type: application/json');

class Funciones {
	
	private $db;
		
	function __construct() {
			/* Comentado para crear usar PDO
			$this->db = new mysqli('localhost', 'root', '', 'ubikApp');
			$this->db->autocommit(FALSE);*/ 
			$this->db = new PDO("mysql:host=".$host.";dbname=".$db,$user,$pass);
	}   
	
	function __destruct() {
		$this->db->close();
	}   
		
	public function getUsers($userId){				
		$sth = $this->db->prepare("SELECT id, nombres, apellidos,email,fechaNacimiento FROM Usuario WHERE id = ?");
		$sth->bind_param("i", $userId);
		$sth->execute();
		//return json_encode($sth->fetchAll());
		return sendResponse(200, json_encode($resultado));
		return true;
	}
	
	$stmt->close();
	
}

?>