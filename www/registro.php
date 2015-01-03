<?php
include('../lib/funciones.inc.php');

session_start();
$_SESSION['pagina'] = "registro";

if($_SESSION['userId']==0) {
	header('Location: login.php');
	exit;
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

    <title>UbikApp - Editar Campa&ntilde;a</title>

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
           <!-- inicio header cfuentea -->
        <?php
        include('header.php');
        ?>
            <!-- fin header cfuentea -->
             
            <!-- inicio -->
           <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Perfil Empresa: {idEmpresa}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Ingrese sus datos
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form role="form">

                        <div class="col-lg-6">

                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input class="form-control" placeholder="Ingrese Nombre" name="nombre">
                                </div>

                                <div class="form-group">
                                    <label>Nombre Fantasia</label>
                                    <input class="form-control" placeholder="Ingrese Nombre de Fantasia" name="nombreFantasia">
                                </div>

                                <div class="form-group">
                                    <label>Rut</label>
                                    <input class="form-control" placeholder="Ingrese Rut" name="rut">
                                </div>


                                <div class="form-group">
                                    <label>Direccion</label>
                                    <input class="form-control" placeholder="Ingrese Direccion" name="direccion">
                                </div>

                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input class="form-control" placeholder="Ingrese Telefono" name="telefono">
                                </div>                                                              
                        
                                <div class="form-group">
                                    <label>Representante Legal</label>
                                    <input class="form-control" placeholder="Enter text" name="representanteLegal">
                                </div>

                                <div class="form-group input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" class="form-control" placeholder="e-Mail" name="email">
                                </div>
                                

                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input type="password" class="form-control" placeholder="Ingrese su contraseña" name="password">
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
                        </div>
                                                
                        </form>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>


            <!-- fin -->
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <!--<script src="js/jquery.js"></script>-->
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