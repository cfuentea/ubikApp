<?php

function sanitize($string = '', $is_filename = FALSE) {
	$string = preg_replace('/[^\w\-'. ($is_filename ? '~_\.' : ''). ']+/u', '-', $string);
	if (function_exists("mb_strtolower"))
		$string = mb_strtolower(preg_replace('/--+/u', '-', $string), 'UTF-8');
	else
		$string = strtolower(preg_replace('/--+/u', '-', $string));
	$string = str_replace("ñ", "n", $string);
	$string = str_replace("á", "a", $string);
	$string = str_replace("é", "e", $string);
	$string = str_replace("í", "i", $string);
	$string = str_replace("ó", "o", $string);
	$string = str_replace("ú", "u", $string);
	$string = str_replace("ñ", "n", $string);
	return $string;
}

function get_valor ($tag) {
	$ci=& get_instance();
	$sql = "SELECT valor FROM opciones WHERE tag='$tag'  ";
	$rs = $ci->db->query($sql) or die(mysql_error());
	$rr = $rs->row();
	if ($rr)
		return $rr->valor;
	else
		return false;
}

function minutos($seconds, $simple="", $condec="")
{
	$mins = floor ($seconds / 60);
	if ($mins<10) $mins = "0".$mins;
	if ($mins == "0") $mins = "00";
	$seg = $seconds % 60;
	if ($seg<10) $seg = "0".$seg;
	if ($seg == "0") $seg = "00";
	if ($simple) {
		if ($condec)
			return number_format(($seconds/60), 2, ',', '');
		else
			return (int)$mins;
	}
	else {
		return "$mins:$seg";
	}

}


function get_tabla($tabla, $order="", $where = "") {
	$ci=& get_instance();
	if ($order) $suf = " ORDER BY $order "; else $suf = "";
	$sql = "SELECT * FROM $tabla $where $suf";
	$rs = $ci->db->query($sql) or die(mysql_error());
	return $rs->result();
}

function desde($original) {
	setlocale(LC_ALL, 'es_ES');
	$original = strtotime($original);
	$chunks = array(
		array(60 * 60 * 24 * 365 , 'a&ntilde;o'),
		array(60 * 60 * 24 * 30 , 'mes'),
		array(60 * 60 * 24 * 7, 'semana'),
		array(60 * 60 * 24 , 'dia'),
		array(60 * 60 , 'hora'),
		array(60 , 'minuto'),
	);
	$today = time();
	$since = $today - $original;
	if($since > 604800) {
		$print = strftime("%e de %b", $original);
		if($since > 31536000) {
			$print .= ", " . date("Y", $original);
		}
		return $print;
	}
	for ($i = 0, $j = count($chunks); $i < $j; $i++) {
		$seconds = $chunks[$i][0];
		$name = $chunks[$i][1];
		if (($count = floor($since / $seconds)) != 0) {
			// DEBUG print "<!-- It's $name -->\n";
			break;
		}
	}
	$print = ($count == 1) ? '1 '.$name : "$count {$name}s";
	return "hace ".$print;
}


// historial de propiedad
function historial($item=0, $accion, $descripcion, $inmobiliaria=0) {
	$ci=& get_instance();
	$session_data = $ci->session->userdata('logged_in');
	$sql = "INSERT INTO historial (fecha , item_id, inmobiliaria_id, usuario, accion, descripcion) VALUES (NOW(), $item,$inmobiliaria, '{$session_data["nombre"]}' , '$accion', '$descripcion') ";
	if ($ci->db->query($sql)) {
		return true;
	}
	else
		return false;
}


function parametros($tipo, $return="", $strpremarcados=""){
	$arrpremarcados = array();
	if ($strpremarcados) {
		$arrpremarcados = unserialize($strpremarcados);
	}
	$ci=& get_instance();
	$sql = "SELECT parametros_tipos.*
			FROM parametros_tipos, parametros_grupos
			WHERE parametros_tipos.parametro_id=parametros_grupos.parametro_id AND parametros_grupos.item_tipo_id='$tipo'
			ORDER BY parametros_tipos.nombre ";
	$res = $ci->db->query($sql);
	if ($res) {
		if ($return) {
			return $res->result();
		}
		$revisar = $presel  = $s = "";
		$re = $res->result();
		$html = "<table class='parametros' width='100%'>\n";
		foreach ($re as $item) {
			$nomcampo = "param_".$item->parametro_id;
			$html .= "<tr>
						<td nowrap><label for='$nomcampo'>$item->nombre</label></td>
						 ";
			if ($item->tipo == "sino") {
				$op1=""; $op2 = "";
				if (in_array($item->parametro_id, array_keys($arrpremarcados))) {
					if ($arrpremarcados[$item->parametro_id] == "1")
						$op1= "checked='checked' ";
					elseif  ($arrpremarcados[$item->parametro_id] == "0")
						$op2= "checked='checked' ";
					else { $op1=""; $op2 = "";}
				}
				$html .= "<td id='{$nomcampo}'><p><input type='radio' class='aware' name='$nomcampo' id='{$nomcampo}_opsi' value='1'  $op1 /> SI
				<input type='radio' name='$nomcampo' class='aware' id='{$nomcampo}_opno' value='0' $op2 /> NO</p>
				";
			}
			elseif ($item->tipo == "opciones"){
				if (in_array($item->parametro_id, array_keys($arrpremarcados))) {
					$presel = $arrpremarcados[$item->parametro_id];
					$revisar = true;
				}
				$ops = explode(",", $item->opciones);
				$html .= "<td><select class='aware w160' name='$nomcampo' id='{$nomcampo}' >
				<option value=''>&nbsp;</option>";
				foreach ($ops as $op) {
					$op = trim($op);
					if ($revisar) {  $s= ($op == $presel) ? "selected":""; }
					$html .= "<option $s>$op</option>\n";
				}
				$html .= "</select>\n";
			}
			elseif ($item->tipo == "texto"){
				if (in_array($item->parametro_id, array_keys($arrpremarcados))) {
					$valor = $arrpremarcados[$item->parametro_id];
				}
				else
					$valor = "";
				$html .= "<td><input type='text' name='$nomcampo' id='$nomcampo' class='text aware' value='$valor'/>";
			}
			$html .= "</td></tr>\n";
		}
		$html .=" </table>\n";
		return $html;
	} else {
		return "";
	}
}

function opciones(){
	$ci=& get_instance();
	$sql = "SELECT * FROM opciones";
	$res = $ci->db->query($sql);

	$re = $res->result();
	$html = "<table class='opciones' width='100%' border='0' cellspacing='0'>\n";
	foreach ($re as $item) {
		$nomcampo = "param_".$item->tag;
		$html .= "<tr>
					<td nowrap style='padding-right:20px' ><label for='$nomcampo'>$item->descripcion</label></td>
					 ";
		if ( $item->tipo == "sino" || $item->tipo == "check") {
			$op1=""; $op2 = "";
			if ($item->valor == "1")
				$op1= "checked='checked' ";
			elseif  ($item->valor == "0")
				$op2= "checked='checked' ";
			$html .= "<td align='left' id='{$nomcampo}'><p><input type='radio' class='aware' name='$nomcampo' id='{$nomcampo}_opsi' value='1'  $op1 /> SI
			<input type='radio' name='$nomcampo' class='aware' id='{$nomcampo}_opno' value='0' $op2 /> NO</p>
			";
		}
		elseif ($item->tipo == "select"){
			$ops = explode(",", $item->posibles);
			$html .= "<td align='left'><select class='aware w160' name='$nomcampo' id='{$nomcampo}' >
			<option value=''>&nbsp;</option>";
			foreach ($ops as $op) {
				$op = trim($op);
				$s= ($op == $item->valor) ? "selected":"";
				$html .= "<option $s>$op</option>\n";
			}
			$html .= "</select>\n";
		}
		elseif ($item->tipo == "texto"){
			$valor = $item->valor;
			$html .= "<td align='left'><input type='text' name='$nomcampo' id='$nomcampo' class='text aware' value='$valor'/>";
		}
		elseif ($item->tipo == "numero"){
			$valor = $item->valor;
			$html .= "<td align='left'><input type='text' name='$nomcampo' id='$nomcampo' class='text aware' value='$valor'/>";
		}
		$html .= "</td></tr>\n";
	}
	$html .=" </table>\n";
	return $html;
}

function echoparam($tipo, $valor) {
	$return = "";
	if ($tipo == "sino") {
		if ($valor == true ||$valor == "si" || $valor  == 1)
			$return = "SI";
		else
			$return = "NO";
	}
	else
		$return = trim($valor);
	return $return;
}

function random_gen($length) {
	$random= "";
	srand((double)microtime()*1000000);
	$char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$char_list .= "abcdefghijklmnopqrstuvwxyz";
	$char_list .= "1234567890";
	for($i = 0; $i < $length; $i++) {
		$random .= substr($char_list,(rand()%(strlen($char_list))), 1);
	}
	return $random;
}

function send_email($recipient, $sender, $subject, $message) {
	$ci =& get_instance();
	$body = $message;
	require_once("application/libraries/PHPMailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsMail();
	$mail->SetFrom('info@ocasas.com.uy', 'OCASAS');
	$mail->AddReplyTo('info@ocasa.com.uy', 'OCASAS');
	$mail->Subject = $subject;
	$mail->SMTPDebug = false;
	$mail->AltBody = strip_tags($message);
	$mail->MsgHTML($body);
	$mail->AddAddress($recipient);
	$mail->SMTPAuth   = false; // $ci->config->item('CORREO_SMTP_AUTH');
	$mail->Username   = $ci->config->item('CORREO_SMTP_USER');
	$mail->Password   =$ci->config->item(' CORREO_SMTP_PASS');
	$mail->Host       =  "127.0.0.1"; // $ci->config->item('CORREO_SMTP_HOST');
	$mail->Port       = 25; // $ci->config->item('CORREO_SMTP_PORT');

	if ( ! $mail->Send()) {
		return false;
	}
	else {
		return true;
	}
}

function msgok($msg, $return=false) {
	$html = "<span style='color:#00CE00'>$msg</span>";
	if ($return) return $html;
	else echo $html;
}

function msgerror($msg, $return=false) {
	$html = "<span style='color:red'>$msg</span>";
	if ($return) return $html;
	else echo $html;
}

// nombre_original = $_FILES["archivo"]["name"]
// nuevo_nombre = devuelve nombre convertido
// path_imagen = $_FILES["archivo"]["tmp_name"]
// path destino = directorio donde quedara imagen
// max_ancho = ancho maximo
// max_alto = alto maximo
// forcename = forzar a usar este nuevo nombre
// EJEMPLO (crearthumb($_FILES["archivo"]["name"],$nuevo_nombre,$_FILES["archivo"]["tmp_name"], "/Users/Edson/www/t/", "90", "100", ""))
function crearthumb($calidad, $nombre_original, &$nuevo_nombre, $path_imagen, $path_destino,  $max_ancho,$max_alto, $forcename="", $imagecrop="", $suf = ""){
	$debug = false;
	if ($debug){
		echo "nombre_original:$nombre_original<br />nuevo_nombre:$nuevo_nombre<br />forcename:$forcename,<br /> path_imagen:$path_imagen<br />path_destino:$path_destino,<br /> max_ancho: $max_ancho<br />max_alto:$max_alto<br />forcename:$forcename<br />imagecrop:$imagecrop<br />suf:$suf  <br />";
	}
	if (substr($path_destino, -1,1) != "/") $path_destino.="/";
	$nombre = strtolower($nombre_original);
	$extget = substr( strrchr($nombre_original, "."), 1);
	if ($forcename) {
		$nuevonombre = $forcename;
	}
	else {
		$nuevonombre = preg_replace("/[^a-z0-9._]/", "", str_replace (" ", "_", str_replace("%20", "_", qacentos(strtolower($nombre)))));
	}
	if ($suf) {
		$nuevonombre = "{$suf}$nuevonombre";
	}
	list($w, $h, $type) = getimagesize($path_imagen);
	if ($debug) echo "<b>w:</b> $w - <b>h:</b> $h <br> - <b>type:</b> $type <br>\n";
	if (!is_numeric($w) && !is_numeric($h)) {
		echo "IMAGEN INVALIDA";
		return false;
	}
	if ($type == 2) $extget = "jpg";
	elseif ($type == 3) $extget = "png";
	else $extget = "";
	//echo $extget."<br>";
	if ($extget == "jpg" || $extget == "jpeg") {
		if (!$im = imagecreatefromjpeg($path_imagen)) {
			echo "IMAGEN DAÑADA";
			return false;
		}
	}
	elseif ($extget == "png") {
		$im = imagecreatefrompng($path_imagen);
	}
	elseif ($extget == "gif") {
		$im = imagecreatefromgif($path_imagen);
	}
	else {
		echo "IMAGEN INVALIDA ($nuevo_nombre)";
		return false;
	}
	if ($imagecrop) {
		$ratio_orig = $w/$h;
		if ($debug) echo "$ratio_orig = intval($w/$h);<br>";
		if ($debug) echo "ratio: $ratio_orig<br>";
		if ($max_ancho/$max_alto > $ratio_orig) {
			$new_height = intval($max_ancho/$ratio_orig);
			$new_width = $max_ancho;
		} else {
			$new_width = $max_alto*$ratio_orig;
			$new_height = $max_alto;
		}
		$x_mid = intval($new_width/2);
		$y_mid = intval($new_height/2);
		$process = imagecreatetruecolor(round($new_width), round($new_height)) ;
		imagealphablending($process, false);
		imagesavealpha($process,true);
		$transparent = imagecolorallocatealpha($process, 255, 255, 255, 127);
		imagefilledrectangle($process, 0, 0, $new_width, $new_height, $transparent);
		imagecopyresampled($process, $im, 0, 0, 0, 0, $new_width, $new_height, $w, $h);
		$thumb = imagecreatetruecolor($max_ancho, $max_alto);
		imagealphablending($thumb, false);
		imagesavealpha($thumb,true);
		$transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
		imagefilledrectangle($thumb, 0, 0, $max_ancho, $max_alto, $transparent);
		imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($max_ancho/2)), ($y_mid-($max_alto/2)), $max_ancho, $max_alto, $max_ancho, $max_alto);
		imagedestroy($process);
		imagedestroy($im);
		if ($debug)  echo "imagejpeg ($thumb, $path_destino$nuevonombre, 5) ";
		if (!imagejpeg($thumb, $path_destino.$nuevonombre, $calidad)) {
			echo "Error al guardar imagen: $path_destino $nuevonombre";
			return false;
		}
		$nuevo_nombre = $nuevonombre;
		return true;
	}
	if ($w > $max_ancho || $h > $max_alto) {
		$largo = strlen($extget);
		$nuevo_alto = $max_alto;
		$nuevo_ancho = $max_ancho;
		if ($w > $max_ancho)	{
			$nuevo_alto =  intval($h  / ($w / $max_ancho));
			if ($nuevo_alto > $max_alto) {
				$nuevo_alto = $max_alto;
				$nuevo_ancho =  intval($w  / ($h / $max_alto));
			}
		}
		elseif ($h > $max_alto) {
			$nuevo_ancho =  intval($w  / ($h / $max_alto));
			if ($nuevo_ancho > $max_ancho) {
				$nuevo_ancho = $max_ancho;
				$nuevo_alto =  intval($h  / ($w / $max_ancho));
			}
		}
		$imagedef = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
		imagealphablending($imagedef, false);
		imagesavealpha($imagedef,true);
		$transparent = imagecolorallocatealpha($imagedef, 255, 255, 255, 127);
		imagefilledrectangle($imagedef, 0, 0, $nuevo_ancho, $nuevo_alto, $transparent);
		imagecopyresampled($imagedef, $im, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $w, $h);
		if (!imagejpeg($imagedef, $path_destino.$nuevonombre, $calidad) ) {
			echo "Error al guardar imagen: $path_destino $nuevonombre";
			return false;
		}
	}
	else {
		$new_width = $w;
		$new_height = $h;
		if ($debug) {
			echo "\$process = imagecreatetruecolor(intval($new_width), intval($new_height)) <br>";
		}
		$process = imagecreatetruecolor(intval($new_width), intval($new_height)) or die("problem1");
		imagecopyresampled($process, $im, 0, 0, 0, 0, $w, $h, $w, $h)  or die("problem2");
		if (!imagejpeg($process, $path_destino.$nuevonombre, $calidad) ) {
			echo "Error al guardar imagen: $path_destino $nuevonombre";
			return false;
		}
	}
	$nuevo_nombre = $nuevonombre;
	return true;
}

function wmimage ($image, $url, $calidad=90) {
	$debug = false;
	if ($debug) {
		echo "<fieldset style='border:1px solid red !important'><b>wmimage:</b> se recibe:<br> image: $image<br>url: $url<br>calidad:$calidad<br>";
	}
	$ci=& get_instance();
	$sql = "SELECT valor FROM opciones WHERE tag='MARCADEAGUA' ";
	$res = $ci->db->query($sql);
	$datos = $res->row();
	if (!$datos){
		return false;
	}
	$overlay = $ci->config->item("real_path")."/imagenes/".$datos->valor;
	$w_offset = 0;
	$h_offset = 0;
	$extension = strtolower(substr($image, strrpos($image, ".") + 1));
	switch ($extension) {
		 case 'jpg':
			  $background = imagecreatefromjpeg($image);
			  break;
		 case 'jpeg':
			  $background = imagecreatefromjpeg($image);
			  break;
		 case 'png':
			  $background = imagecreatefrompng($image);
			  break;
		 case 'gif':
			  $background = imagecreatefromgif($image);
			  break;
		 default:
			  return false;
	}
	$swidth = imagesx($background);
	$sheight = imagesy($background);
	if ($debug) {
		echo "<b>fondo: </b>
		ancho: $swidth<br>
		alto: $sheight<br>";
	}
	imagealphablending($background, true);
	$overlay = imagecreatefrompng($overlay);
	$ori_owidth = $owidth = imagesx($overlay);
	$ori_oheight = $oheight = imagesy($overlay);
	if ($debug) {
		echo "<b>marca: </b>
		ancho: $owidth<br>
		alto: $oheight<br>";
	}
	$tamano = 10;
	if ($swidth < 200) {
		$tamano = 9;
	}
	$mitad = round($swidth / 2);
	$answer= round(($oheight*$mitad)/$owidth);
	if ($debug) echo "answer= round(($oheight*$mitad)/$owidth) <br>";
	$nw = $owidth = $mitad;
	if ($debug) echo "nuevo ancho overlay: $nw<br>";
	$nh = $oheight = $answer;
	if ($debug) echo "nuevo alto overlay: $nh<br>";

	if ($debug) {
		echo "entonces:
		En una imagen de $swidth x $sheight<br>
		en las coordenadas (($swidth/2) - ($owidth/2) - $w_offset) x (($sheight/2) - ($oheight/2) - $h_offset) <br>
		en las coordenadas ".(($swidth/2) - ($owidth/2) - $w_offset)."x".(($sheight/2) - ($oheight/2) - $h_offset)."<br>
		pero una iamgen de $nw x $nh desde su  0x0<br>";
	}
	imagecopyresampled ($background, $overlay, round(($swidth/2) - ($owidth/2) - $w_offset),  round(($sheight/2) - ($oheight/2) - $h_offset), 0, 0, $owidth, $oheight, $ori_owidth, $ori_oheight);
	if ($swidth > 100) {
		$w = imagecolorallocate($background, 255, 255, 255);
		imagettftext ($background, $tamano, 0, 10,  $sheight - 10, $w, $ci->config->item("real_path")."/files/arial.ttf",  $url);
	}
	if (!imagejpeg($background, $image, $calidad)) {
		echo "No pude guardar imagen (wmimage): $image ";
		return false;
	}

	imagedestroy($background);
	imagedestroy($overlay);
	if ($debug) {
		echo "</fieldset>";
	}
	return true;
}

function setTransparency(&$new_image, &$image_source) {
	$transparencyIndex = @imagecolortransparent($image_source);
	if ($transparencyIndex)
	{
		$transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);
		if ($transparencyIndex >= 0) {
				$transparencyColor    = imagecolorsforindex($image_source, $transparencyIndex);
		}
		$transparencyIndex    = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
		imagefill($new_image, 0, 0, $transparencyIndex);
		imagecolortransparent($new_image, $transparencyIndex);
	}
}

function objfromdb($t) {
	$ci =& get_instance();
	$sql = "describe $t";
	$rs1 = $ci->db->query($sql);
	if ($rs1->num_rows() > 0) {
		$tabla = new stdClass();
		foreach ($rs1->result() as $item) {
			$v = $item->Field;
			$tabla->$v = $item->Default;
		}
		return $tabla;
	}
	else
		return false;
}

function uenc($string) {
	 $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
	 $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
	 return str_replace($entities, $replacements, urlencode($string));
}

function sino($ele) {
	if (in_array($ele, array(1, "yes", "si", true))) {
		return "SI";
	} else {
		return "NO";
	}
}


function qacentos($cadena){
	$p = array('á','é','í','ó','ú','Á','É','Í','Ó','Ú','ñ','Ñ');
	return str_replace($p, "", $cadena);
}

function distancia($lat1, $lon1, $lat2, $lon2, $unit="K") {
  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) *
	cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;

  $unit = strtoupper($unit);

  if ($unit == "K") {

	return ($miles * 1.609344);

  } else if ($unit == "N") {
	  return ($miles * 0.8684);
  } else {
		return $miles;
  }
}

function geocoding($direccion, $ensuciar=false) {
	$ci=& get_instance();
	$gmk = $ci->config->item("google_maps_key");
	$base_url = "http://maps.google.com/maps/geo?output=xml&key=" . $gmk;
	$request_url = $base_url . "&q=" . urlencode($direccion);
	//echo $request_url."<hr>";
	if ($xml = simplexml_load_file($request_url)) {
		$status = $xml->Response->Status->code;
		if (strcmp($status, "200") == 0) {
			$coordinates = $xml->Response->Placemark->Point->coordinates;
			$coordinatesSplit = explode(",", $coordinates);
			$lat = $coordinatesSplit[1];
			$lng = $coordinatesSplit[0];
			if ($ensuciar) {
				$slat = rand(100, 500);
				$slng = rand(100, 500);
				$lat = $lat + "0.00$slat";
				$lng = $lng + "0.00$slng";
			}
			return "$lat|$lng";
		}
	}
	return false;
}

function semilimpieza($str) {
	$str = trim($str);
	$str = strip_tags($str);
	$str = preg_replace( "/^\.+|\.+$/", "", $str);
	$str = preg_replace( "/^\,+|\,+$/", "", $str);
	return $str;
}

function miles($num) {
	return number_format($num,0,',','.');
}

function diasemana($fecha) {
	$ci =& get_instance();
	$db = $ci->load->database('mesa',TRUE);

	$sql = "SELECT COUNT(*) C FROM MESAMS.FERIADOS WHERE DIA='$fecha' ";
	$c = $db->query($sql);
	if ($c->num_rows() > 0)
		return false;
	$ts = strtotime($fecha);
	$d = strftime("%u", $ts);
	if ($d < 6) {
		return true;
	} else {
		return false;
	}
}

function gfwd($month, $year, $day = 1) {
	$dateData = getdate(mktime(null, null, null, $month, $day, $year));
	if (in_array($dateData['wday'], range(1, 5))) {
		return $dateData['mday'];
	}
	return gfwd($month, $year, ($day+1));
}


function get_enum($tabla, $campo) {
	$ci=& get_instance();
	$elems = array();
	$describe = $ci->db->query("DESCRIBE $tabla")->result();
	if ($describe) {
		foreach ($describe as $ligne) {
			//print_r($ligne);
			extract((array)$ligne, EXTR_PREFIX_ALL, "IN");
			if ((substr($IN_Type,0,4)=='enum') && ($IN_Field == $campo )) {
				$liste = substr($IN_Type,5,strlen($IN_Type));
				$liste = substr($liste,0,(strlen($liste)-2));
				$enums = explode(',',$liste);
				if (sizeof($enums) > 0) {
					for ($i=0; $i < sizeof($enums); $i++) {
						$elem = trim(strtr($enums[$i],"'"," "));
						$elems[] = $elem;
					}
				}
			}
		}
		return $elems;
	} else {
		return false;
	}
}

function week_start_date($wk_num, $yr, $first = 1, $format = 'Y-m-d') {
	$wk_num--;
	$wk_ts  = strtotime('+' . $wk_num . ' weeks', strtotime($yr . '0101'));
	$mon_ts = strtotime('-' . date('w', $wk_ts) + $first . ' days', $wk_ts);
	return date($format, $mon_ts);
}

function estados($asarr=false) {
	$ci=& get_instance();
	$sql = "SELECT * FROM visitas_estados ORDER BY visita_estado_id";
	$rs = $ci->db->query($sql)->result();
	if ($asarr) {
		$arr = array();
		foreach ($rs as $ro) {
			$arr[$ro->visita_estado_id] = $ro->visita_estado_nombre;
		}
		return $arr;
	} else {
		return $rs;
	}
}

function mes($mes) {
	$array = array(
		1 => "Enero",
		2 => "Febrero",
		3 => "Marzo",
		4 => "Abril",
		5 => "Mayo",
		6 => "Junio",
		7 => "Julio",
		8 => "Agosto",
		9 => "Septiembre",
		10 => "Octubre",
		11 => "Noviembre",
		12 => "Diciembre"
		
	);
	return $array[$mes];
}

function reversedate($date) {
	return implode("-",array_reverse(explode("-", $date)));
}



function getStartAndEndDate($week, $year) {
  $dto = new DateTime();
  $dto->setISODate($year, $week);
  $ret['week_start'] = $dto->format('Y-m-d');
  $dto->modify('+6 days');
  $ret['week_end'] = $dto->format('Y-m-d');
  return $ret;
}

 function full_url()
{
   $ci=& get_instance();
   $return = $ci->config->site_url().$ci->uri->uri_string();
   if(count($_GET) > 0)
   {
      $get =  array();
      foreach($_GET as $key => $val)
      {
         $get[] = $key.'='.$val;
      }
      $return .= '?'.implode('&',$get);
   }
   return $return;
}  

function removeqsvar($url, $varname) {
    return preg_replace('/([?&])'.$varname.'=[^&]+(&|$)/','$1',$url);
}


function cleanString ($string) {
	$normalizeChars = array(
	'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
	'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
	'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
	'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
	'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
	'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
	'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f', 'ı'=>'i', 'İ'=>'I', 'ş'=>'s',
	'Ş'=>'S', 'ü'=>'u', 'Ü'=>'U', 'ğ'=>'g', 'Ğ'=>'G', "\r"=>'', "\n"=>''
	);
    $string = strtr($string, $normalizeChars);
    $string = mb_convert_encoding($string,'ASCII');
    return $string;
} 


function sum_the_time($time1, $time2) {
	$times = array($time1, $time2);
	$seconds = 0;
	foreach ($times as $time)
	{
		list($hour,$minute,$second) = explode(':', $time);
		$seconds += $hour*3600;
		$seconds += $minute*60;
		$seconds += $second;
	}
	$hours = floor($seconds/3600);
	$seconds -= $hours*3600;
	$minutes  = floor($seconds/60);
	$seconds -= $minutes*60;
	// return "{$hours}:{$minutes}:{$seconds}";
	return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}