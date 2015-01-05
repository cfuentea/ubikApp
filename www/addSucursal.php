<?php
include('../lib/funciones.inc.php');

session_start();
$_SESSION['pagina'] = "addSucursal";

if($_SESSION['userId']==0) {
	header('Location: login.php');
	exit;
}

// Mostramos errores

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>UbikApp - A&ntilde;adir Sucursal</title>

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
	<script src="js/jsvalidator.js" type="text/javascript"></script>
</head>

<body>
	
	<div id="wrapper">

		<!-- Navigation -->
		<!-- inicio header cfuentea -->
        <?php
        include('header.php');
        ?>
            <!-- fin header cfuentea -->
        	<!-- /.navbar-top-links -->
			<!-- barra de menu -->
			<?php
			include('menu.general.php');
			?>
			<!-- fin barra de menu -->
		</nav>

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Ingresar Sucursal</h1>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
			<div class="row">
				<div class="col-lg-8-">
					<div class="panel panel-default">
						<?php 
						if($_GET) {
							echo createSucursal(getIdEmpresa($_SESSION['userId']),$_GET);
							//print_r($_GET)."<br />";

						} 
						?>
						<!-- /.panel-heading -->                        
						<div class="panel-body">
							<form role="form" action="addSucursal.php" method="get" id="formulario">
								<div class="form-group">
									<label>Nombre de Sucursal</label>
									<input name="nombre" class="form-control" placeholder="Ej: Sucursal Santiago Centro">
								</div>
								<!--<div class="form-group">
									<select class="form-control">
										<?//=listarCiudad();?>
									</select>
								</div>-->
								<div class="form-group">
									<label>Tipo de Sucursal</label>
									<input class="form-control" list="tipoSucursal" name="tipoSucursal"/>
									<datalist id="tipoSucursal">
										<option value="Casa Matriz">
										<option value="Ventas">
										<option value="Bodega">
									</datalist>
								</div>
								<div class="form-group">
									<label>Ingresar la direcci&oacute;n</label>
									<!-- Mapa con selección de puntos -->
									<!-- inicio mapa -->
									<!-- <div class="datosMapa"> -->
										<input id="geocomplete" type="text" />
										<!-- <input id="find" type="button" value="Buscar" /><br /> -->
										<input name="location" type="hidden" value="" >
										<input name="lat" type="hidden" value="" >
										<input name="lng" type="hidden" value="" >
										<input name="locality" type="hidden" value="" >
										<input name="country" type="hidden" value="" >
        								<input name="formatted_address" type="hidden" value="" >
									<!-- </div> -->

									<div class="map_canvas"></div>

									<script src="http://maps.googleapis.com/maps/api/js?sensor=true&amp;libraries=places"></script>
									<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

									<script src="js/maps/jquery.geocomplete.js"></script>
									<script src="js/maps/logger.js"></script>

									<script>
									$(function(){

										var options = {
											map: ".map_canvas"
										};

										$("#geocomplete").geocomplete({
											map: ".map_canvas",
											details: "form",
											geocodeAfterResult: true
										});

										$("#find").click(function(){
											$("#geocomplete").trigger("geocode");
										});

									});
									</script>
									<!-- fin mapa -->
								</div>
										<input type="submit" class="btn btn-lg btn-success btn-block" value="Enviar">
										<!-- <a href="index.html" class="btn btn-lg btn-success btn-block">Login</a>-->
								</form>
								</div>
									<!-- /.panel-body -->
							</div>
								<!-- /.table-responsive -->
						</div>
					</div>
						<!-- /.col-lg-4 -->
				</div>
					<!-- /.row -->
			</div>
				<!-- /#page-wrapper -->

			</div>
			<!-- /#wrapper -->
			<!-- validador formulario -->
    		<script  type="text/javascript">
        		var frmvalidator = new Validator("formulario");
        		frmvalidator.addValidation("nombre","req","Debes ingresar el nombre de la Sucursal");
        		frmvalidator.addValidation("nombre","maxlen=20", "Largo máximo para el nombre es de 20 caracteres");

        		frmvalidator.addValidation("tipoSucursal","req");

        		frmvalidator.addValidation("lat","req","Debes ingresar la dirección exacta de la sucursal");

    		</script>
			<!-- jQuery -->
			<!--<script src="js/jquery.js"></script>-->

			<!-- API de Google Maps 
			<script type="text/javascript"
			src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDQV3VTbtrEGmwYNdy6PtjDmSgrxN4W1dY&sensor=FALSE">
			</script>-->

			<!-- Bootstrap Core JavaScript -->
			<script src="js/bootstrap.min.js"></script>

			<!-- Metis Menu Plugin JavaScript -->
			<script src="js/plugins/metisMenu/metisMenu.min.js"></script>

			<!-- Custom Theme JavaScript -->
			<script src="js/sb-admin-2.js"></script>

		</body>

		</html>
