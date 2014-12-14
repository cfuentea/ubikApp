<?php
header('Content-type: application/json');
$arreglo = json_decode($_POST);
print_r($arreglo);

foreach ($phpArray as $key => $value) { 
    echo "<p>$key | $value</p>";
}

?>
