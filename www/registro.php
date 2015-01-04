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

    <title>UbikApp - Editar Perfil</title>

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

        global $link;
        $query = "SELECT 
                    id,
                    nombre,
                    nombreFantasia,
                    rut,
                    direccionCasaCentral,
                    telefonoFijo,
                    telefonoFax,
                    representanteLegal,
                    emailContacto,
                    fechaIngreso,
                    password
                FROM Empresa
                WHERE id = ".getIdEmpresa($_SESSION['userId'])."";
        
        $resultado = mysql_query($query,$link);
        $row = mysql_fetch_assoc($resultado);
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
                        <h1 class="page-header">Edici&oacute;n de Perfil - <?=readCliente($_SESSION['userId']);?></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-8-">
                        <div class="panel panel-default">
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                 <form role="form" method="post" id="formulario">

                        <div class="col-lg-6">

                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input class="form-control" placeholder="Ingrese Nombre" name="nombre" value="<?=$row['nombre'];?>">
                                </div>

                                <div class="form-group">
                                    <label>Nombre Fantasia</label>
                                    <input class="form-control" placeholder="Ingrese Nombre de Fantasia" name="nombreFantasia" value="<?=$row['nombreFantasia'];?>">
                                </div>

                                <div class="form-group">
                                    <label>Rut</label>
                                    <input class="form-control" placeholder="Ingrese Rut" name="rut" value="<?=$row['rut'];?>">
                                </div>


                                <div class="form-group">
                                    <label>Direccion</label>
                                    <input class="form-control" placeholder="Ingrese Direccion" name="direccionCasaCentral" value="<?=$row['direccionCasaCentral'];?>">
                                </div>

                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input class="form-control" placeholder="Ingrese Telefono" name="telefonoFijo" value="<?=$row['telefonoFijo'];?>">
                                </div>                                                              
                        
                                <div class="form-group">
                                    <label>Representante Legal</label>
                                    <input class="form-control" placeholder="Enter text" name="representanteLegal" value="<?=$row['representanteLegal'];?>">
                                </div>

                                <div class="form-group input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" class="form-control" placeholder="e-Mail" name="emailContacto" value="<?=$row['emailContacto'];?>">
                                </div>
                                

                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input type="password" class="form-control" placeholder="Ingrese su contraseña" name="password" value="">
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
                        </div>
                                                
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
        frmvalidator.addValidation("password","req","Debes ingresar una contraseña");
    </script>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

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
