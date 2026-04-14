
<!DOCTYPE html>
<html class=" ">
    <head>
        <!-- 
         * @Package: Complete Admin - Responsive Theme
         * @Subpackage: Bootstrap
         * @Version: BS4-1.0
         * This file is part of Complete Admin Theme.
        -->
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title><?php echo $this->config->item('titulo'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" type="image/x-icon" />    <!-- Favicon -->
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-57-precomposed.png">	<!-- For iPhone -->
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-114-precomposed.png">    <!-- For iPhone 4 Retina display -->
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-72-precomposed.png">    <!-- For iPad -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-144-precomposed.png">    <!-- For iPad Retina display -->

        <!--<script src="<?php echo base_url(); ?>application/libraries/sesion.js"  type="text/javascript"></script>-->



        <!-- CORE CSS FRAMEWORK - START -->
        <link href="<?php echo base_url(); ?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/> 
        <link href="<?php echo base_url(); ?>assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START --> 

        <link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-2.0.1.css" rel="stylesheet" type="text/css" media="screen"/>

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/tecmmas.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->


        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START --> 


        <link href="<?php echo base_url(); ?>assets/plugins/datatables/css/jquery.dataTables.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/css/datatables.min.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/extensions/TableTools/css/dataTables.tableTools.min.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css" media="screen"/>

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END --> 

        <link href="<?php echo base_url(); ?>assets/plugins/daterangepicker/css/daterangepicker-bs3.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/datepicker/css/datepicker.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/multi-select/css/multi-select.css" rel="stylesheet" type="text/css" media="screen"/>



        <link href="<?php echo base_url(); ?>assets/plugins/messenger/css/messenger.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/messenger/css/messenger-theme-future.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/messenger/css/messenger-theme-flat.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/css/tecmmas.css" rel="stylesheet" type="text/css"/>
    </head>
    <!-- END HEAD -->


    

    <!-- BEGIN BODY -->
    <body class=" "><!-- START TOPBAR -->
        <div class='page-topbar '>
            <div class='logo-area'>

            </div>
            <div class='quick-area'>
                <div class='float-left'>
                    <ul class="info-menu left-links list-inline list-unstyled">
                        <li class="sidebar-toggle-wrap list-inline-item">
                            <a href="#" data-toggle="sidebar" class="sidebar_toggle">
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>
                        <li class="message-toggle-wrapper list-inline-item">
                            <ul class="dropdown-menu messages animated fadeIn">
                                <li class="list dropdown-item">
                                    <ul class="dropdown-menu-list list-unstyled ps-scrollbar"></ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class='float-right'>
                    <ul class="info-menu right-links list-inline list-unstyled">
                        <li class="profile list-inline-item">
                            <!--                            <a href="#" data-toggle="dropdown" class="toggle">
                                                            <img src="<?php echo base_url(); ?>assets/images/profile/<?php echo $this->session->userdata('usuario') ?>.png" alt="user-image" class="rounded-circle img-inline">
                                                            <span><?php echo $this->session->userdata('nombre') ?> <i class="fa fa-angle-down"></i></span>
                                                        </a>
                                                        <ul class="dropdown-menu profile animated fadeIn">
                            
                                                            <li class="dropdown-item">
                                                                <a href="#profile">
                                                                    <i class="fa fa-user"></i>
                                                                    Perfil
                                                                </a>
                                                            </li>
                            
                                                            <li class="last dropdown-item">
                                                                <a href="<?php echo base_url(); ?>index.php/clogin">
                                                                    <i class="fa fa-lock"></i>
                                                                    Cerrar Sesión
                                                                </a>
                                                            </li>
                                                        </ul>-->
                        </li>

                    </ul>			
                </div>		
            </div>

        </div>
        <!-- END TOPBAR -->
        <!-- START CONTAINER -->
        <div class="page-container row-fluid container-fluid">

            <!-- SIDEBAR - START -->

            <div class="page-sidebar fixedscroll">

                <!-- MAIN MENU - START -->
                <div class="page-sidebar-wrapper" id="main-menu-wrapper"> 

                    <!-- USER INFO - START -->
                    <div class="profile-info row">

                        <div class="profile-image col-4">
                            <a href="ui-profile.html">
<!--                                <img alt="" src="<?php echo base_url(); ?>assets/images/profile/<?php echo $this->session->userdata('usuario') ?>.png" class="img-fluid rounded-circle">-->
                                <img alt="" src="<?php echo base_url(); ?>assets/images/profile/user.png" class="img-fluid rounded-circle">
                            </a>
                        </div>

                        <div class="profile-details col-8">

                            <h3>
                                <a href="ui-profile.html"><?php echo $this->session->userdata('nombre') ?></a>
<!--                                <a href="ui-profile.html"><?php echo $this->session->userdata('nombre') ?></a>-->

                                <!-- Available statuses: online, idle, busy, away and offline -->
                                <span class="profile-status online"></span>
                            </h3>

                            <!--<p class="profile-title">Operario</p>-->

                        </div>

                    </div>
                    <!-- USER INFO - END -->
                    <ul class='wraplist'>	
                        <li class='menusection'>Menú principal</li>
                        <?php if ($this->session->userdata('idperfil') !== "2") { ?>

                            <li id="li_pal" class=""> 
                                <a href="<?php echo base_url(); ?>index.php/oficina/CPrincipal">
                                    <i class="fa fa-home"></i>
                                    <span class="title">Inicio</span>
                                </a>
                            </li>
                            <li id="li_pal" class=""> 
                                <a href="<?php echo base_url(); ?>index.php/oficina/usuarios/Cusuarios">
                                    <i class="fa fa-user"></i>
                                    <span class="title">Usuarios</span>
                                </a>
                            </li>
                            <li id="li_nte" class=""> 
                                <a href="<?php echo base_url(); ?>index.php/oficina/cliente/Ccliente">
                                    <i class="fa fa-user"></i>
                                    <span class="title">Clientes</span>
                                </a>
                            </li>
                            <li id="li_ulo" class=""> 
                                <a href="<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo">
                                    <i class="fa fa-car"></i>
                                    <span class="title">Vehiculos</span>
                                </a>
                            </li>
                            <li id="li_bas" class=""> 
                                <a href="<?php echo base_url(); ?>index.php/oficina/pruebas/Cpruebas">
                                    <i class="fa fa-road"></i>
                                    <span class="title">Pruebas</span>
                                </a>
                            </li>
                            <li id="li_ion" class=""> 
                                <a href="<?php echo base_url(); ?>index.php/oficina/CGestion">
                                    <i class="fa fa-eye"></i>
                                    <span class="title">Visor y gestion</span>
                                </a>
                            </li>
                        <?php } ?>
                        <li class='menusection'>Informes y formatos</li>

                        <?php if ($this->session->userdata('idperfil') !== "2") { ?>
                            <li class=''> 
                                <a href='javascript:;'>
                                    <i class='fa fa-file-text'></i>
                                    <span class='title'>Informes</span>
                                    <span class='arrow '></span>
                                </a>
                                <ul class='sub-menu' >
                                    <li id="li_sta" class=""> 
                                        <a href="<?php echo base_url(); ?>index.php/oficina/informes/CFur">
                                            <i class="fa fa-file-text"></i>
                                            <span class="title">Formato uniforme</span>
                                        </a>
                                    </li>
                                    <li id="li_sta" class=""> 
                                        <a href="<?php echo base_url(); ?>index.php/oficina/informes/CPrerevision">
                                            <i class="fa fa-file-text"></i>
                                            <span class="title">Prerevision</span>
                                        </a>
                                    </li>
                                <?php }if ($this->session->userdata('idperfil') !== "2" && $this->session->userdata('idperfil') !== "4") { ?>
                                    <li id="li_sta" class=""> 
                                        <a href="<?php echo base_url(); ?>index.php/oficina/informes/Catestiguamiento">
                                            <i class="fa fa-file-text"></i>
                                            <span class="title">Atestiguamiento</span>
                                        </a>
                                    </li>

                                    <li id="li_con" class=""> 
                                        <a href="<?php echo base_url(); ?>index.php/oficina/reportes/Cambientales">
                                            <i class="fa fa-file-text"></i>
                                            <span class="title">Ambientales</span>
                                        </a>
                                    </li>
                                </ul>
                                <a href='javascript:;'>
                                    <i class='fa fa-file-text'></i>
                                    <span class='title'>Formatos</span>
                                    <span class='arrow '></span>
                                </a>
                                <ul class='sub-menu' >
                                    <li id="li_sta" class=""> 
                                        <a href="<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/registroentrada" target="_blank">
                                            <i class="fa fa-edit"></i>
                                            <span class="title">Registro entrada</span>
                                        </a>
                                    </li>
                                    <li id="li_sta" class=""> 
                                        <a href="<?php echo base_url(); ?>index.php/oficina/reportes/pruebas/Cpruebas/tiempoPruebas" target="_blank">
                                            <i class="fa fa-clock-o"></i>
                                            <span class="title">Tiempo pruebas</span>
                                        </a>
                                    </li>
                                </ul>
                            <li id="li_cerrar_sesion" class="" > 
                                <a href="<?php echo base_url(); ?>index.php/oficina/reportes/auditorias/Cauditorias">
                                    <i class="fa fa-bar-chart"></i>
                                    <span class="title">Auditoria Pruebas</span>
                                </a>
                            </li>
                            </li>


                            <li class='menusection'>Modulos adicionales</li>
                            <li class=''> 
                                <a href='javascript:;'>
                                    <i class='fa fa-hand-o-right'></i>
                                    <span class='title'>Registros</span>
                                    <span class='arrow '></span>
                                </a>
                                <ul class='sub-menu' >
                                    <li id="li_sta" class=""> 
                                        <a href="<?php echo base_url(); ?>index.php/oficina/reportes/adicionales/Cadicionales">
                                            <i class="fa fa-file-text"></i>
                                            <span class="title">Metrologia</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php if ($this->session->userdata('actualizaciones') == '1') { ?>

                                <li id="li_cerrar_sesion" class="" > 
                                    <a href="<?php echo base_url(); ?>index.php/oficina/descargas/Cdescargas">
                                        <i class="fa fa-download"></i>
                                        <span class="title">Descarga de actualización</span>
                                    </a>
                                </li>
                                <?php
                            }
                            if ($this->session->userdata('backup') == '1') {
                                ?>

                                <li id="li_cerrar_sesion" class="" > 
                                    <a href="<?php echo base_url(); ?>index.php/oficina/backup/Cbackup">
                                        <i class="fa fa-cloud"></i>
                                        <span class="title">Generar backup</span>
                                    </a>
                                </li>


                                <?php
                            }
                            if ($this->session->userdata('agop') == '1') {
                                ?>

                                <li id="li_cerrar_sesion" class="" > 
                                    <a href="<?php echo base_url(); ?>index.php/oficina/reportes/stats/Cstats/agop">
                                        <i class="fa fa-refresh"></i>
                                        <span class="title">Iniciar AG/OP</span>
                                    </a>
                                </li>
                            <?php } ?>

                            <li class='menusection'>Base de datos</li>
                            <li id="li_cerrar_sesion" class="" > 
                                <a href="<?php echo base_url(); ?>index.php/oficina/reportes/db/Cdb">
                                    <i class="fa fa-database"></i>
                                    <span class="title">Optimizar base de datos</span>
                                </a>
                            </li>


                        <?php } ?>

                    </ul>
                    <ul>
                        <li class='menusection'>Cierre de sesión</li>
                        <li id="li_cerrar_sesion" class="" > 
                            <a  onclick="cerrarSesion()">
                                <i class="fa fa-power-off"></i>
                                <span class="title">Cerrar Sesión</span>
                            </a>
<!--                            <a  href="<?php echo base_url(); ?>index.php">
                                <i class="fa fa-power-off"></i>
                                <span class="title">Cerrar Sesión</span>
                            </a>-->
                        </li>
                    </ul>

                </div>
                <!-- MAIN MENU - END -->
            </div>
            <style type="text/css">
                td {
                    text-align: center;
                    vertical-align: middle
                }
                th {
                    text-align: center;
                    vertical-align: middle
                }
                tr {
                    text-align: center;
                    vertical-align: middle
                }
            </style>
            <script type="text/javascript">
                var IdUsuario = '<?php echo $this->session->userdata('IdUsuario'); ?>';

                window.onload = function () {
                    localStorage.setItem('IdUsuario', IdUsuario);
                    var sPath = window.location.pathname;
                    var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
                    $('#li_' + sPage.substring(sPage.length - 3)).addClass('open');
                    ocultarComponente('btnTerminar');
                };


                function mostrarComponente(componente) {
                    $('#' + componente).css('visibility', 'visible');
                    $('#' + componente).css('position', 'relative');
                }

                function ocultarComponente(componente) {
                    $('#' + componente).css('visibility', 'hidden');
                    $('#' + componente).css('position', 'absolute');
                }
            </script>



