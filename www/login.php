<?php
include('../lib/funciones.inc.php');

// Mostramos errores
/*
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
*/

if(empty($session)) session_start();

/*if(!$_SESSION) */

//$_SESSION['userId'] = 0;
if($_SESSION['userId']!=0) { 
    header('Location: index.php');
} else {
    $_SESSION['userId'] = 0;
}
	
if($_POST) {
	$login = loginClientes($_POST['rut'],$_POST['password']);
	if($login>0) {	
		$_SESSION['userId'] = $login;
		header('Location: index.php');
		exit;
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>UbikApp - Inicio de Sesi&oacute;n</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Por favor ingrese sus datos</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="login.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="RUT" name="rut" type="rut" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contrase&ntilde;a" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <?php
                                        if($_POST) {
											if(empty($login)) {
												echo "<span style='color:red'>Error en rut / contrase&ntilde;a</span>";
											} else {
												echo "<span></span>";
											}
										}
										?>
                                        <!-- <input name="remember" type="checkbox" value="Remember Me">Recuerdame -->
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Ingresar">
                                <!-- <a href="index.html" class="btn btn-lg btn-success btn-block">Login</a>-->
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

</body>

</html>
