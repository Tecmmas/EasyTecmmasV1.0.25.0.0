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
        <title>ADMINISTRAR CLIENTE</title>
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

        <!-- START CONTENT -->
        <section class="wrapper main-wrapper row" style=''>
            <div class="clearfix"></div>
            <!-- MAIN CONTENT AREA STARTS -->
            <div class="col-xl-12">
                <section class="box ">
                    <div class="content-body"  style="background: whitesmoke">    
                        <div class="row" >
                            <div class="col-lg-12 col-md-12 col-12">
                                <section class="box ">
                                    <header class="panel_header">
                                        <h2 class="title float-left">Administrar cliente</h2>
                                    </header>
                                    <div class="content-body" >    
                                        <form action="<?php echo base_url(); ?>index.php/oficina/cliente/Ccliente" style="width: 100px" method="post">
                                            <input name="button" class="btn btn-block bot_azul"  type="submit"  value="Atras" />   
                                        </form>     
                                        <br>
                                        <form action="<?php echo base_url(); ?>index.php/oficina/cliente/CAdministrarCliente/guardar" method="post">
                                            <input type="hidden" name="idcliente" value="<?php
                                            if (isset($cliente->idcliente)) {
                                                echo $cliente->idcliente;
                                            } else {
                                                echo "";
                                            }
                                            ?>"/>
                                            <table class="table dt-responsive display">
                                                <tr>
                                                    <td style="text-align: right">
                                                        TIPO DOCUMENTO
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="tipo_identificacion" style="background: #FFE1E1">
                                                            <?php
                                                            if (isset($tipo_identificacion)) {
                                                                echo $tipo_identificacion;
                                                            }
                                                            ?>
                                                            <option value="1">Cédula de ciudadanía</option>
                                                            <option value="2">Numero Identificación Tributaria (NIT)</option>
                                                            <option value="3">Cédula de extrangería</option>
                                                            <option value="4">Tarjeta de identidad</option>
                                                            <option value="5">N. único de Id. Personal</option>
                                                            <option value="6">Pasaporte</option>
                                                        </select>
                                                        <strong style="color: #E31F24"><?php echo form_error('tipo_identificacion'); ?></strong>
                                                    </td>
                                                    <td style="text-align: right">
                                                        NUMERO DE DOCUMENTO
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="numero_identificacion" value="<?php
                                                        if (isset($cliente->numero_identificacion)) {
                                                            echo $cliente->numero_identificacion;
                                                        }
                                                        ?>" style="background: #FFE1E1" type="number" >
                                                        <strong style="color: #E31F24"><?php echo form_error('numero_identificacion'); ?></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right">
                                                        NOMBRES
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="nombres" value="<?php
                                                        if (isset($cliente->nombre1)) {
                                                            echo trim($cliente->nombre1 . ' ' . $cliente->nombre2);
                                                        }
                                                        ?>" style="background: #FFE1E1" type="text">
                                                        <strong style="color: #E31F24"><?php echo form_error('nombres'); ?></strong>
                                                    </td>
                                                    <td style="text-align: right">
                                                        APELLIDOS
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="apellidos" value="<?php
                                                        if (isset($cliente->nombre1)) {
                                                            echo trim($cliente->apellido1 . ' ' . $cliente->apellido2);
                                                        }
                                                        ?>" style="background: #FFE1E1" type="text">
                                                        <strong style="color: #E31F24"><?php echo form_error('apellidos'); ?></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right">
                                                        TELEFONO DE CONTACTO 1
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="telefono1" value="<?php
                                                        if (isset($cliente->telefono1)) {
                                                            echo $cliente->telefono1;
                                                        }
                                                        ?>" style="background: #FFE1E1" type="number">
                                                        <strong style="color: #E31F24"><?php echo form_error('telefono1'); ?></strong>
                                                    </td>
                                                    <td style="text-align: right">
                                                        TELEFONO DE CONTACTO 2
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="telefono2" value="<?php
                                                        if (isset($cliente->telefono2)) {
                                                            echo $cliente->telefono2;
                                                        }
                                                        ?>" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right">
                                                        DIRECCIÓN DE RESIDENCIA
                                                    </td>
                                                    <td >
                                                        <input class="form-control" name="direccion" value="<?php
                                                        if (isset($cliente->direccion)) {
                                                            echo trim($cliente->direccion);
                                                        }
                                                        ?>" style="background: #FFE1E1" type="text">
                                                        <strong style="color: #E31F24"><?php echo form_error('direccion'); ?></strong>
                                                    </td>
                                                    <td style="text-align: right">
                                                        CIUDAD DE RESIDENCIA
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="" id="s2example-1" name="cod_ciudad" style="background: #FFE1E1" >
                                                                <?php
                                                                if (isset($ciudad)) {
                                                                    echo $ciudad;
                                                                }
                                                                ?>
                                                                <?php
                                                                if (isset($ciudades)) {
                                                                    echo $ciudades;
                                                                }
                                                                ?>
                                                            </select>
                                                            <strong style="color: #E31F24"><?php echo form_error('cod_ciudad'); ?></strong>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right">
                                                        NUMERO DE LICENCIA
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="numero_licencia" value="<?php
                                                        if (isset($cliente->numero_licencia)) {
                                                            echo trim($cliente->numero_licencia);
                                                        }
                                                        ?>" type="text">
                                                    </td>
                                                    <td style="text-align: right">
                                                        CATEGORIA DE LICENCIA
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="categoria_licencia">
                                                            <?php
                                                            if (isset($categoria_licencia)) {
                                                                echo trim($categoria_licencia);
                                                            }
                                                            ?>
                                                            <option value="A1">A1</option>
                                                            <option value="A2">A2</option>
                                                            <option value="B1">B1</option>
                                                            <option value="B2">B2</option>
                                                            <option value="B3">B3</option>
                                                            <option value="C1">C1</option>
                                                            <option value="C2">C2</option>
                                                            <option value="C3">C3</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right">
                                                        CORREO ELECTRONICO
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="correo" value="<?php
                                                        if (isset($cliente->correo)) {
                                                            echo trim($cliente->correo);
                                                        }
                                                        ?>" type="text">
                                                        <strong style="color: #E31F24"><?php echo form_error('correo'); ?></strong>
                                                    </td>
                                                    <td style="text-align: right">
                                                        <label class="form-label" for="field-11">FECHA DE NACIMIENTO</label>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <span class="desc">e.j. "1990-08-02"</span>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" name="cumpleanos" data-mask="y-m-d" value="<?php
                                                                if (isset($cliente->cumpleanos)) {
                                                                    echo trim($cliente->cumpleanos);
                                                                }
                                                                ?>">
                                                            </div>
                                                        </div>    
                                                <!--                                                <input class="form-control" name="cumpleanos" value="<?php
                                                        if (isset($cliente->cumpleanos)) {
                                                            echo trim($cliente->cumpleanos);
                                                        }
                                                        ?>" type="text">-->
                                                        <strong style="color: #E31F24"><?php echo form_error('cumpleanos'); ?></strong>
                                                    </td>
                                                </tr>

                                            </table>
                                            <table style="text-align: center;width: 100%" >
                                                <tr>
                                                    <td>
                                                        <input name="guardar" class="btn  btn-block bot_gris" type="submit"  value="Guardar" />   
                                                    </td>
                                                    <td>
                                                        <input name="btnguardarnuevo" class="btn btn-block bot_gris" type="submit"  value="Guardar y nuevo" />   
                                                    </td>
                                                    <td>
                                                        <input name="guardarfinalizar" class="btn btn-block bot_gris" type="submit"  value="Guardar y finalizar" />   
                                                    </td>
                                                    <td>
                                                        <input name="btnnuevo" class="btn btn-block bot_verde" type="submit"  value="Nuevo" />   
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                        <br>
                                        <form action="<?php echo base_url(); ?>index.php/oficina/cliente/Ccliente" method="post" style="width: 200px">
                                            <input name="button" class="btn btn-block bot_rojo"  type="submit"  value="Cancelar" />   
                                        </form> 

                                        <br>
                                        <div style="text-align: center;color: gray">
                                            <?php echo $this->config->item('derechos'); ?>    
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

            <!-- MAIN CONTENT AREA ENDS -->
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
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


    <!-- CORE TEMPLATE JS - START --> 
    <script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script> 
    <!-- END CORE TEMPLATE JS - END --> 


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



