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
        <title>ADMINISTRAR VEHICULO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" type="image/x-icon" />    <!-- Favicon -->
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-57-precomposed.png">	<!-- For iPhone -->
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-114-precomposed.png">    <!-- For iPhone 4 Retina display -->
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-72-precomposed.png">    <!-- For iPad -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-144-precomposed.png">    <!-- For iPad Retina display -->




        <!-- CORE CSS FRAMEWORK - START -->
        <link href="<?php echo base_url(); ?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!-- <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/> -->
        <link href="<?php echo base_url(); ?>assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <link href="<?php echo base_url(); ?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>

        <link href="<?php echo base_url(); ?>assets/plugins/datatables/css/datatables.min.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/extensions/TableTools/css/dataTables.tableTools.min.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css" media="screen"/>

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/tecmmas.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->
    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" ">

        <!-- START TOPBAR -->
        <div class='page-topbar '>
            <div class='logo-area'>

            </div>
            <div class='quick-area'>
                <div class='float-left'>
                    <ul class="info-menu left-links list-inline list-unstyled">
                        <li class="message-toggle-wrapper list-inline-item">
                            <ul class="dropdown-menu messages animated fadeIn">
                                <li class="list dropdown-item">
                                </li>
                            </ul>
                        </li>
                </div>		
            </div>

        </div>
        <!-- END TOPBAR -->
        <br><br>
        <!-- START CONTENT -->

        <section class="box ">
            <header class="panel_header">
                <h2 class="title pull-left">BUSCAR PERSONA</h2>
            </header>
            <div class="content-body"> 

                <table style="width: 100%;text-align: left">
                    <tr>
                    <form action="<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/getCliente" method="post" >
                        <td style="text-align: left;width: 100px">
                            <label  for="placa">BUSQUEDA<br/>
                                <input type="text" name="match" id="placa" class="form-control"  value="<?php
                                if (isset($item)) {
                                    echo $item;
                                }
                                ?>" />
                            </label>
                        </td>
                        <td style="text-align: left;width: 200px">
                            <input type="submit" name="consultar" id="wp-submit" class="btn bot_azul btn-block" style="width: 150px"  value="Consultar" />
                        </td>
                    </form>
                    <td style="text-align: left;width: 200px">
                        <form action="<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo" method="post" style="width: 100%">
                            <input type="submit" name="agregar" id="wp-submit" class="btn bot_rojo btn-block" style="width: 150px" value="Cancelar" />
                        </form>
                    </td>
                    </tr>
                </table>
                <br>
                <div class="col-xs-12">
                    <table id="example-1" class="table table-striped dt-responsive display">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (isset($clientes)) {
                                echo $clientes;
                            }
                            ?>
                        </tbody>
                    </table>




                </div>
            </div>
        </section>
    </section>
    <!-- END CONTENT -->


    <!-- END CONTAINER -->
    <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->


    <!-- CORE JS FRAMEWORK - START --> 
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script> 
    <script src="<?php echo base_url(); ?>assets/js/popper.min.js" type="text/javascript"></script> 
    <script src="<?php echo base_url(); ?>assets/js/jquery.easing.min.js" type="text/javascript"></script> 
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
    <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
    <script src="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js" type="text/javascript"></script> 
    <script src="<?php echo base_url(); ?>assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>  
    <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"><\/script>');</script>
    <!-- CORE JS FRAMEWORK - END --> 


    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 

    <script src="<?php echo base_url(); ?>assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.js" type="text/javascript"></script> 
    <script src="<?php echo base_url(); ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script> 
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/js/dataTables.min.js" type="text/javascript"></script>     
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


    <!-- CORE TEMPLATE JS - START --> 
    <script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script> 
    <!-- END CORE TEMPLATE JS - END --> 
    <script type="text/javascript">

        var asignarPropietario = function (e) {
            var data = {
                idpropietarios: e.id
            };
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/asignarPropietario',
                type: 'post',
                data: data,
                async: false,
                success: function () {
                    location.href = '../Cvehiculo';
                }
            });
        };
    </script>

    <!-- General section box modal start -->
    <div class="modal" id="section-settings" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog animated bounceInDown">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Section Settings</h4>
                </div>
                <div class="modal-body">

                    Body goes here...

                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    <button class="btn btn-success" type="button">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal end -->
</body>
</html>



