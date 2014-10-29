<?php

/* Libreria de conexion MySQL
 * Modificar una vez cambiado de sistema
 * Carlos Fuentealba F. - carlos@dev.cl
 */
$HostDB = "localhost";
$UserDB = "ubikapp_user"; 
$PassDB = "1q2w3e4r"; 
$NameDB = "ubikapp_main"; 

function mycon() 
{ 
        global $HostDB, $UserDB, $PassDB, $NameDB;
        $link = @mysql_connect ($HostDB, $UserDB, $PassDB) or die ("Error en la conexi&oacute;n") ;
        @mysql_select_db ($NameDB, $link) or die ("Error al seleccionar la Base de Datos!!") ;
        return $link;  
} 
?>
