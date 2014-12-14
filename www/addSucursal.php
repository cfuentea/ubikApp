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

		<style>
		html, body, #map-canvas {
			height: 100%;
			margin: 0px;
			padding: 0px
		}
		.controls {
			margin-top: 16px;
			border: 1px solid transparent;
			border-radius: 2px 0 0 2px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			height: 32px;
			outline: none;
			box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
		}

		#pac-input {
			background-color: #fff;
			padding: 0 11px 0 13px;
			width: 400px;
			font-family: Roboto;
			font-size: 15px;
			font-weight: 300;
			text-overflow: ellipsis;
		}

		#pac-input:focus {
			border-color: #4d90fe;
			margin-left: -1px;
			padding-left: 14px;  /* Regular padding-left + 1. */
			width: 401px;
		}

		.pac-container {
			font-family: Roboto;
		}

		#type-selector {
			color: #fff;
			background-color: #4d90fe;
			padding: 5px 11px 0px 11px;
		}

		#type-selector label {
			font-family: Roboto;
			font-size: 13px;
			font-weight: 300;
		}
	}

	</style>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>

	<script>
	function initialize() {
		var mapOptions = {
			center: new google.maps.LatLng(-33.8688, 151.2195),
			zoom: 13
		};
		var map = new google.maps.Map(document.getElementById('map-canvas'),
			mapOptions);

		var input = /** @type {HTMLInputElement} */(
			document.getElementById('pac-input'));

		var types = document.getElementById('type-selector');
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

		var autocomplete = new google.maps.places.Autocomplete(input);
		autocomplete.bindTo('bounds', map);

		var infowindow = new google.maps.InfoWindow();
		var marker = new google.maps.Marker({
			map: map,
			anchorPoint: new google.maps.Point(0, -29)
		});

		google.maps.event.addListener(autocomplete, 'place_changed', function() {
			infowindow.close();
			marker.setVisible(false);
			var place = autocomplete.getPlace();
			if (!place.geometry) {
				return;
			}

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
    	map.fitBounds(place.geometry.viewport);
    } else {
    	map.setCenter(place.geometry.location);
      map.setZoom(17);  // Why 17? Because it looks good.
  }
  marker.setIcon(/** @type {google.maps.Icon} */({
  	url: place.icon,
  	size: new google.maps.Size(71, 71),
  	origin: new google.maps.Point(0, 0),
  	anchor: new google.maps.Point(17, 34),
  	scaledSize: new google.maps.Size(35, 35)
  }));
  marker.setPosition(place.geometry.location);
  marker.setVisible(true);

  var address = '';
  if (place.address_components) {
  	address = [
  	(place.address_components[0] && place.address_components[0].short_name || ''),
  	(place.address_components[1] && place.address_components[1].short_name || ''),
  	(place.address_components[2] && place.address_components[2].short_name || '')
  	].join(' ');
  }

  infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
  infowindow.open(map, marker);
});

  // Sets a listener on a radio button to change the filter type on Places
  // Autocomplete.
  function setupClickListener(id, types) {
  	var radioButton = document.getElementById(id);
  	google.maps.event.addDomListener(radioButton, 'click', function() {
  		autocomplete.setTypes(types);
  	});
  }

  setupClickListener('changetype-all', []);
  setupClickListener('changetype-address', ['address']);
  setupClickListener('changetype-establishment', ['establishment']);
  setupClickListener('changetype-geocode', ['geocode']);
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>

</head>

<body onload="inicializar_mapa()">
	
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
									<label>Selecciona direcci&oacute;n</label>
									<!-- Mapa con selección de puntos -->
									<!-- inicio mapa -->
									<input id="pac-input" class="controls" type="text"
									placeholder="Enter a location">
									<div id="type-selector" class="controls">
										<input type="radio" name="type" id="changetype-all" checked="checked">
										<label for="changetype-all">All</label>

										<input type="radio" name="type" id="changetype-establishment">
										<label for="changetype-establishment">Establishments</label>

										<input type="radio" name="type" id="changetype-address">
										<label for="changetype-address">Addresses</label>

										<input type="radio" name="type" id="changetype-geocode">
										<label for="changetype-geocode">Geocodes</label>
									</div>
									<div id="map-canvas"></div>
									<!-- fin mapa -->
								</div>
								<div class="form-group">
									<label>Tipo de Sucursal</label>
									<input class="form-control" list="browsers" name="browser">
									<datalist id="tipoSucursal">
										<option value="Casa Matriz">
											<option value="Ventas">
												<option value="Bodega">
												</datalist>
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
			<script src="js/jquery.js"></script>

			<!-- API de Google Maps -->
			<script type="text/javascript"
			src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDQV3VTbtrEGmwYNdy6PtjDmSgrxN4W1dY&sensor=FALSE">
			</script>

			<!-- Bootstrap Core JavaScript -->
			<script src="js/bootstrap.min.js"></script>

			<!-- Metis Menu Plugin JavaScript -->
			<script src="js/plugins/metisMenu/metisMenu.min.js"></script>

			<!-- Custom Theme JavaScript -->
			<script src="js/sb-admin-2.js"></script>

		</body>

		</html>
