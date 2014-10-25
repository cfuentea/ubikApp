<?php
// Librarys to include
include('errors.php');

// Show errors
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
header('Content-Type: application/json');

class RedeemAPI { 
        private $db;
	// Constructor - open DB connection
        function __construct() {
                $this->db = new mysqli('localhost', 'root', '', 'ubikApp');
                $this->db->autocommit(FALSE); 
        }   
        // Destructor - close DB connection
        function __destruct() {
        	$this->db->close();
        }   
// Main method to redeem a code
function redeem() {
// Check for required parameters
if(isset($_POST["id"])) {
    // Variables que vendran en metodo $_POST
    $userId = $_POST["id"];       
    // Look up code in database
    $stmt = $this->db->prepare('SELECT id, nombres, apellidos,email,fechaNacimiento FROM Usuario WHERE id = ?');
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($id, $nombres, $apellidos,$email,$fechaNacimiento);
    if($stmt->fetch()) {
	$resultado = array(
		"id" => $id,
		"nombre" => $nombres,
		"apellidos" => $apellidos,
		"otros" => $email,$fechaNacimiento,
	);
	sendResponse(200, json_encode($resultado));
	return true;
    } else {
	sendResponse(400, 'Invalid request'); 
	return false;
    }
    $stmt->close();
  }
}
}

$app = new RedeemAPI;
$app->redeem();

?>
