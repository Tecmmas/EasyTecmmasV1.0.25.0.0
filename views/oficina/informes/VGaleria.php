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
        <title>ESTADO DEL VEHÍCULO</title>
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
        <link href="<?php echo base_url(); ?>assets/plugins/image-cropper/css/cropper.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/plugins/image-cropper/css/main.css" rel="stylesheet" type="text/css" media="screen"/>

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/tecmmas.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <!--<form action="<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/gestionar" method="post">-->
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
                <section class="box " style="padding: 5px">
                    <div class="col-lg-12 col-md-12 col-12">


                        <section class="box " style="padding: 20px">
                            <header class="panel_header">
                                <h2 class="title float-left">Estado del vehículo</h2>
                            </header>
                            <form action="<?php echo base_url(); ?>index.php/oficina/informes/CPrerevision/verFoto" method="post">
                                <?php echo $fotos; ?>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- <h3>Demo:</h3> -->
                                        <div class="img-container">
                                            <!--<img id="image" src="../data/image-cropper-1.jpg" alt="Picture">-->
                                            <input type="hidden" name="idprerevision" value="<?php
                                            if (isset($idprerevision)) {
                                                echo $idprerevision;
                                            }
                                            ?>" />
                                            <img id="image" src="<?php
                                            if (isset($foto)) {
                                                echo $foto;
                                            }
                                            ?>" >

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- <h3>Preview:</h3> -->
                                        <div class="docs-preview clearfix">
                                            <div class="img-preview preview-lg" style="height: 400px;width: 800px"></div>
                                            <!--                                        <div class="img-preview preview-md"></div>
                                                                                    <div class="img-preview preview-sm"></div>
                                                                                    <div class="img-preview preview-xs"></div>-->
                                        </div>

                                        <!-- <h3>Data:</h3> -->
                                        <!--                                    <div class="docs-data">
                                                                                <div class="input-group input-group-sm">
                                                                                    <label class="input-group-addon" for="dataX">X</label>
                                                                                    <input type="text" class="form-control" id="dataX" placeholder="x">
                                                                                    <span class="input-group-addon">px</span>
                                                                                </div>
                                                                                <div class="input-group input-group-sm">
                                                                                    <label class="input-group-addon" for="dataY">Y</label>
                                                                                    <input type="text" class="form-control" id="dataY" placeholder="y">
                                                                                    <span class="input-group-addon">px</span>
                                                                                </div>
                                                                                <div class="input-group input-group-sm">
                                                                                    <label class="input-group-addon" for="dataWidth">Width</label>
                                                                                    <input type="text" class="form-control" id="dataWidth" placeholder="width">
                                                                                    <span class="input-group-addon">px</span>
                                                                                </div>
                                                                                <div class="input-group input-group-sm">
                                                                                    <label class="input-group-addon" for="dataHeight">Height</label>
                                                                                    <input type="text" class="form-control" id="dataHeight" placeholder="height">
                                                                                    <span class="input-group-addon">px</span>
                                                                                </div>
                                                                                <div class="input-group input-group-sm">
                                                                                    <label class="input-group-addon" for="dataRotate">Rotate</label>
                                                                                    <input type="text" class="form-control" id="dataRotate" placeholder="rotate">
                                                                                    <span class="input-group-addon">deg</span>
                                                                                </div>
                                                                                <div class="input-group input-group-sm">
                                                                                    <label class="input-group-addon" for="dataScaleX">ScaleX</label>
                                                                                    <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
                                                                                </div>
                                                                                <div class="input-group input-group-sm">
                                                                                    <label class="input-group-addon" for="dataScaleY">ScaleY</label>
                                                                                    <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
                                                                                </div>
                                                                            </div>-->
                                    </div>
                                </div>
                            </form>
                        </section>
                        <input type="button" class="btn btn-block bot_rojo"  onclick="window.close();"  value="Cerrar" style="width: 200px"/>
<!--                        <table style="text-align: center;width: 100%">
                            <tr>
                                <td>
                                    <input id="btnGuardar" class="btn  btn-block bot_gris" value="Guardar" onclick="guardarVehiculo()" disabled/>   
                                    <label id="msjguardar" style="display: none;position: absolute"></label>
                                </td>
                                <td>
                                    <input id="btnGuardarNuevo" type="button" class="btn btn-block bot_gris" type="submit"  value="Guardar y nuevo" onclick="guardarNuevo()" disabled/>   
                                </td>
                                <td>
                                    <input id="btnGuardarFinalizar" type="button" class="btn btn-block bot_gris" type="submit"  value="Guardar y finalizar" onclick="guardarFinalizar()" disabled/>   
                                </td>
                                <td>
                                    <input class="btn btn-block bot_verde" type="button"  value="Nuevo" onclick="location.reload()"/>   
                                </td>
                            </tr>
                        </table>-->
                        <br>

                        <div style="text-align: center;color: gray">
                            <?php echo $this->config->item('derechos'); ?>    
                        </div>

                    </div>
                </section>
            </div>


            <!-- MAIN CONTENT AREA ENDS -->
        </section>

        <!-- END CONTENT -->
        <div class="modal" id="colorModal" s tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >BUSCAR COLOR</h4>
                    </div>
                    <div class="modal-body" style="background: whitesmoke">
                        <table class="table">
                            <tr id="facturacion">
                                <td style="width: 40%;text-align: right">
                                    COLOR
                                </td>
                                <td style="width: 60%;text-align: left;padding-left: 10px">
                                    <input id="textoColor" type="text" class="form-control"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;text-align: left;padding-left: 10px">
                                    <input class="btn btn-block bot_verde" onclick="buscarColores(this.title)" title="a" type="button"  style="height: 40px;padding: 5px"  value="Aproximado 🔎" />
                                </td>
                                <td style="width: 50%;text-align: left;padding-left: 10px">
                                    <input class="btn btn-block bot_verde" onclick="buscarColores(this.title)" title="e" type="button"  style="height: 40px;padding: 5px"  value="Exacto 🔎" />
                                </td>
                            </tr>

                        </table>
                        <label id="mensaje"
                               style="background: white;
                               width: 100%;
                               text-align: center;
                               font-weight: bold;
                               font-size: 15px;
                               padding: 5px;border: solid gray 2px;
                               border-radius:  15px 15px 15px 15px;color: SALMON"></label>
                        <br>
                        <h5>Coincidencias</h5>
                        <table id="listaColores" class="table">
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">CANCELAR</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="marcaModal" s tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >BUSCAR MARCA</h4>
                    </div>
                    <div class="modal-body" style="background: whitesmoke">
                        <table class="table">
                            <tr id="facturacion">
                                <td style="width: 40%;text-align: right">
                                    MARCA
                                </td>
                                <td style="width: 60%;text-align: left;padding-left: 10px">
                                    <input id="textoMarca" type="text" class="form-control"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;text-align: left;padding-left: 10px">
                                    <input class="btn btn-block bot_verde" onclick="buscarMarcas(this.title)" title="a" type="button"  style="height: 40px;padding: 5px"  value="Aproximado 🔎" />
                                </td>
                                <td style="width: 50%;text-align: left;padding-left: 10px">
                                    <input class="btn btn-block bot_verde" onclick="buscarMarcas(this.title)" title="e" type="button"  style="height: 40px;padding: 5px"  value="Exacto 🔎" />
                                </td>
                            </tr>

                        </table>
                        <label id="mensajeM"
                               style="background: white;
                               width: 100%;
                               text-align: center;
                               font-weight: bold;
                               font-size: 15px;
                               padding: 5px;border: solid gray 2px;
                               border-radius:  15px 15px 15px 15px;color: SALMON"></label>
                        <br>
                        <h5>Coincidencias</h5>
                        <table id="listaMarcas" class="table">
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">CANCELAR</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="lineaModal" s tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >BUSCAR LINEA</h4>
                    </div>
                    <div class="modal-body" style="background: whitesmoke">
                        <table class="table">
                            <tr id="facturacion">
                                <td style="width: 40%;text-align: right">
                                    LINEA
                                </td>
                                <td style="width: 60%;text-align: left;padding-left: 10px">
                                    <input id="textoLinea" type="text" class="form-control"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;text-align: left;padding-left: 10px">
                                    <input class="btn btn-block bot_verde" onclick="buscarLineas(this.title)" title="a" type="button"  style="height: 40px;padding: 5px"  value="Aproximado 🔎" />
                                </td>
                                <td style="width: 50%;text-align: left;padding-left: 10px">
                                    <input class="btn btn-block bot_verde" onclick="buscarLineas(this.title)" title="e" type="button"  style="height: 40px;padding: 5px"  value="Exacto 🔎" />
                                </td>
                            </tr>

                        </table>
                        <label id="mensajeL"
                               style="background: white;
                               width: 100%;
                               text-align: center;
                               font-weight: bold;
                               font-size: 15px;
                               padding: 5px;border: solid gray 2px;
                               border-radius:  15px 15px 15px 15px;color: SALMON"></label>
                        <br>
                        <h5>Coincidencias</h5>
                        <table id="listaLineas" class="table">
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">CANCELAR</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="carroceriaModal" s tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >BUSCAR CARROCERIA</h4>
                    </div>
                    <div class="modal-body" style="background: whitesmoke">
                        <table class="table">
                            <tr id="facturacion">
                                <td style="width: 40%;text-align: right">
                                    CARROCERIA
                                </td>
                                <td style="width: 60%;text-align: left;padding-left: 10px">
                                    <input id="textoCarroceria" type="text" class="form-control"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;text-align: left;padding-left: 10px">
                                    <input class="btn btn-block bot_verde" onclick="buscarCarroceria(this.title)" title="a" type="button"  style="height: 40px;padding: 5px"  value="Aproximado 🔎" />
                                </td>
                                <td style="width: 50%;text-align: left;padding-left: 10px">
                                    <input class="btn btn-block bot_verde" onclick="buscarCarroceria(this.title)" title="e" type="button"  style="height: 40px;padding: 5px"  value="Exacto 🔎" />
                                </td>
                            </tr>

                        </table>
                        <label id="mensajeC"
                               style="background: white;
                               width: 100%;
                               text-align: center;
                               font-weight: bold;
                               font-size: 15px;
                               padding: 5px;border: solid gray 2px;
                               border-radius:  15px 15px 15px 15px;color: SALMON"></label>
                        <br>
                        <h5>Coincidencias</h5>
                        <table id="listaCarrocerias" class="table">
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">CANCELAR</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="modalOtroCda" s tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >INFORMACION IMPORTANTE</h4>
                    </div>
                    <div class="modal-body" style="background: whitesmoke">

                        <label id="mensaje"
                               style="background: white;
                               width: 100%;
                               text-align: center;
                               font-weight: bold;
                               font-size: 15px;
                               padding: 5px;border: solid gray 2px;
                               border-radius:  15px 15px 15px 15px;color: SALMON">EL VEHÍCULO ESTUVO EN OTRO CDA RECIENTEMENTE, COMUNIQUESE CON EL JEFE DE PISTA</label>
                        <br>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">CANCELAR</button>
                    </div>
                </div>
            </div>
        </div>

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
        <script src="<?php echo base_url(); ?>assets/plugins/image-cropper/js/cropper.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/image-cropper/js/main.js" type="text/javascript"></script>
        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <script type="text/javascript">
                                        function setFotos(src) {
                                            document.getElementById("image").src = src;
                                        }
        </script>
        <!-- General section box modal start -->
        <div class="modal" id="modalPlaca" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ingrese la placa</h4>
                    </div>
                    <div class="modal-body" style="text-align: center">
                        <input name="numero_placa" 
                               id="num_placa"
                               style="
                               width: 100px;height: 50px;border: solid black;
                               border-radius: 10px 10px 10px 10px;text-align: center;
                               background: gold;font-size: 20px;font-weight: bold;
                               text-transform: uppercase" type="text" >
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="button">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal end -->
    </body>
    <!--</form>-->
</html>



