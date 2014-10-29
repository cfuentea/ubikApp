<?php

/* Libreria de conexion MySQL
 * Modificar una vez cambiado de sistema
 * Carlos Fuentealba F. - carlos@dev.cl
 */
$HostDB = "127.0.0.1";
$UserDB = "root"; 
$PassDB = ""; 
$NameDB = "ubikApp"; 

function mycon() 
{ 
        global $HostDB, $UserDB, $PassDB, $NameDB;
        $link = @mysql_connect ($HostDB, $UserDB, $PassDB) or die ("Error en la conexi&oacute;n") ;
        @mysql_select_db ($NameDB, $link) or die ("Error al seleccionar la Base de Datos!!") ;
        return $link;  
} 
?>
