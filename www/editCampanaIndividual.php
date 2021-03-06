<?php
include('../lib/funciones.inc.php');

session_start();
$_SESSION['pagina'] = "editCampana";

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>UbikApp - A&ntilde;adir Campa&ntilde;a</title>

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
                    <h1 class="page-header">Edici&oacute;n de Campa&ntilde;a</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8-">
                    <div class="panel panel-default">
                        <?php 
                            if(!$_GET['idCampana']) {
								// echo createCampana(getIdEmpresa($_SESSION['userId']),$_GET);
                                // Escribir funcion que permita hacer Update de los valores desplegados
                                echo "<b style='color:red'>Error, sin datos ingresados</b>";
								//print_r($_GET);
							} else {
                                global $link;
                                $query = "SELECT id, Empresa_id, nombre, descripcion, fechaInicio, fechaFin
                                            FROM Campana
                                            WHERE id = ".$_GET['idCampana']."";
                                $resultado = mysql_query($query,$link);

                                $arr = mysql_fetch_assoc($resultado);
                            }

						?>
                        <!-- /.panel-heading -->                        
                        <div class="panel-body">
	                     <form role="form" action="editCampanaIndividual.php" method="get" id="formulario">
                        	<div class="form-group">
                        		<label>Nombre de campaña</label>
                        		<input name="nombre" class="form-control" placeholder="Promoci&oacute;n imperdible!" value="<?=$arr['nombre'];?>">
                        	</div>
							<div class="form-group">
								<label>Descripci&oacute;n</label>
								<input name="descripcion" class="form-control" placeholder="Descripci&oacute;n del producto" 
                                    value="<?=$arr['descripcion'];?>">
                            </div>
							<div class="form-group">
								<label>Fecha de inicio</label>
								<input type="date" name="fechaInicio" class="form-control" placeholder="AAAA-mm-dd hh:mm:ss" 
                                    value="<?=$arr['fechaInicio'];?>" >
							</div>
							<div class="form-group">
								<label>Fecha de fin</label>
								<input type="date" name="fechaFin" min="2014-01-02 00:00:00" class="form-control" placeholder="AAAA-mm-dd hh:mm:ss"
                                    value="<?=$arr['fechaFin'];?>" >
							</div>
							<div class="form-group">
								<label>Categorias</label>
								<?=readCategorias();?>
							</div>
							<div class="form-group">
								<label>Tiendas & Sucursales</label>
								<?=readSucursal(getIdEmpresa($_SESSION['userId']));?>
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
        frmvalidator.addValidation("nombre","req","Debes ingresar el nombre de la campaña");
        frmvalidator.addValidation("nombre","maxlen=20", "Largo máximo para el nombre es de 20 caracteres");

        frmvalidator.addValidation("descripcion","req");
        frmvalidator.addValidation("descripcion","maxlen=100");

        frmvalidator.addValidation("fechaInicio","req");
        frmvalidator.addValidation("fechaFin","req");

    </script>
    <!-- jQuery 
    <script src="js/jquery.js"></script> -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

</body>

</html>
