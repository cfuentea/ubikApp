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

</head>

<body>
	
	<div id="wrapper">

		<!-- Navigation -->
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.html">UbikApp</a>
			</div>
			<!-- /.navbar-header -->
			<ul class="nav navbar-top-links navbar-right">
				<!-- /.dropdown -->
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-alerts">
						<li>
							<a href="#">
								<div>
									<i class="fa fa-comment fa-fw"></i> New Comment
									<span class="pull-right text-muted small">4 minutes ago</span>
								</div>
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="#">
								<div>
									<i class="fa fa-twitter fa-fw"></i> 3 New Followers
									<span class="pull-right text-muted small">12 minutes ago</span>
								</div>
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="#">
								<div>
									<i class="fa fa-envelope fa-fw"></i> Message Sent
									<span class="pull-right text-muted small">4 minutes ago</span>
								</div>
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="#">
								<div>
									<i class="fa fa-tasks fa-fw"></i> New Task
									<span class="pull-right text-muted small">4 minutes ago</span>
								</div>
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="#">
								<div>
									<i class="fa fa-upload fa-fw"></i> Server Rebooted
									<span class="pull-right text-muted small">4 minutes ago</span>
								</div>
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a class="text-center" href="#">
								<strong>See All Alerts</strong>
								<i class="fa fa-angle-right"></i>
							</a>
						</li>
					</ul>
					<!-- /.dropdown-alerts -->
				</li>
				<!-- /.dropdown -->
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
						</li>
						<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
						</li>
						<li class="divider"></li>
						<li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
						</li>
					</ul>
					<!-- /.dropdown-user -->
				</li>
				<!-- /.dropdown -->
			</ul>
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
				<div class="col-lg-8">
					<div class="panel panel-default">
						<?php 
						if($_GET) {
							echo createSucursal(getIdEmpresa($_SESSION['userId']),$_GET);
							print_r($_GET);
						} 
						?>
						<!-- /.panel-heading -->                        
						<div class="panel-body">
							<form role="form" action="addSucursal.php" method="get">
								<div class="form-group">
									<label>Nombre de Sucursal</label>
									<input name="nombre" class="form-control" placeholder="Promoci&oacute;n imperdible!">
								</div>
								<div class="form-group">
									<label>Tipo de Sucursal</label>
									<input class="form-control" list="sucursales" name="tipoSucursal">
									<datalist id="tipoSucursal">
										<option value="Casa Matriz">
										<option value="Ventas">
										<option value="Bodega">
									</datalist>
								</div>
								<div class="form-group">
									<label>Selecciona direcci&oacute;n</label>
									<!-- Mapa con selección de puntos -->
									<!-- inicio mapa -->
									<form>
										<input id="geocomplete" type="text" placeholder="Ingrese la direcci&oacute;n" size="90" />
										<input id="find" type="button" value="Buscar" /><br />
										<label>Long</label>
										<input name="lng" type="text" value="" disabled><br />
										<label>Lat</label>
										<input name="location" type="text" value="" disabled><br />
										<label>Direcci&oacute;n</label>
        								<input name="formatted_address" type="text" value="" disabled><br />
									</form>

									<div class="map_canvas"></div>

									<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
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
											blur: true,
											geocodeAfterResult: true
										});

										/*$("#geocomplete").geocomplete(options)
										.bind("geocode:result", function(event, result){
											$.log("Result: " + result.formatted_address);
										})
										.bind("geocode:error", function(event, status){
											$.log("ERROR: " + status);
										})
										.bind("geocode:multiple", function(event, results){
											$.log("Multiple: " + results.length + " results found");
										});*/

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
