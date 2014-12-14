<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php"<?=sitioActualBold('indice')?><i class="fa fa-dashboard fa-fw"></i> Panel de Control</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Men&uacute; Campa&ntilde;as<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="addCampana.php" <?=sitioActualBold('addCampana')?>Ingresar Campa&ntilde;a</a>
                                </li>
                                <li>
                                    <a href="editCampana.php" <?=sitioActualBold('editCampana')?>Editar Campa&ntilde;a</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Men&uacute; Sucursales<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="addSucursal.php" <?=sitioActualBold('addSucursal')?>Ingresar Sucursal</a>
                                </li>
                                <li>
                                    <a href="editSucursal.php" <?=sitioActualBold('editSucursal')?>Editar Sucursal</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                        </li>
                      </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->