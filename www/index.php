<?php
include('../lib/funciones.inc.php');

session_start();
$_SESSION['pagina'] = "indice";

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

    <title>UbikApp - Dashboard</title>

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
    <!-- calcula la estadistica de Área -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        <?=estadisticaArea(getIdEmpresa($_SESSION['userId']));?>
    </script>
    <script type="text/javascript">
        <?=estadisticaDona(getIdEmpresa($_SESSION['userId']));?>
    </script>
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
                    <h1 class="page-header">Panel de Control - <?=readCliente($_SESSION['userId']);?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8-">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Estado de Campa&ntilde;as                         
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Chart area -->
                            <div id="chart_div" style="width: 80%; height: 400px;"></div>
                            <!-- Chart dona -->
                            <div id="donutchart" style="width: 80%; height: 400px;"></div>
                            <!--<div id="morris-area-chart"></div>-->
                            <!--<div id="morris-donut-chart"></div>-->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.table-responsive -->
                    <!-- /.panel -->
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
