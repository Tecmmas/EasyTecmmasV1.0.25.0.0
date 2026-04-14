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


                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left">vehículo</h2>
                            </header>
                            <div class="row">
                                <div class="col-md-4 col-lg-4 col-sm-4">
                                    <input type="button" class="btn btn-block bot_azul"  style="width: 100px" onclick="location.href = '../CPrincipal';"  value="Atras" />             
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-4">
                                    <input class="btn btn-block bot_verde" type="button" style="width: 100px"  value="Nuevo" onclick="location.reload()"/>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3 col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" id="numero_placa" placeholder="PLACA" />
                                        <label id="msjnumero_placa" style="display: none;position: absolute"></label>
                                    </div>	
                                </div>
                                <div class="col-md-3 col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <input class="btn btn-block bot_verde"  style="height: 40px;padding: 5px;" onclick="buscarVehiculo()" type="submit"  value="Buscar" />
                                    </div>	
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-4 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Extranjero</label>
                                                <select class="form-control" id="extranjero">
                                                    <option value='N' select>NO</option>
                                                    <option value='S'>SI</option>
                                                </select>
                                            </div>	
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Clase</label>
                                                <select class="form-control" id="idclase" disabled></select>
                                                <label id="msjidclase" style="display: none;position: absolute"></label>
                                            </div>	
                                        </div>
                                        <div class="col-md-12 col-lg-12 col-sm-12">
                                            <label for="validationCustomUsername">Marca</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <input class="btn btn-block bot_verde"  type="button" id="btnmarca"  style="height: 40px;padding: 5px"  value="🔎" disabled  data-toggle='modal' data-target='#marcaModal'/>
                                                </div>
                                                <input class="form-control" id="idmarca" disabled/>
                                                <input type="hidden" id="idmarcarunt" />
                                                <label id="msjidmarca" style="display: none;position: absolute"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-12 col-sm-12" style="margin-top: 20px">
                                            <label for="validationCustomUsername">Linea</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <input class="btn btn-block bot_verde" type="button" id="btnlinea"  style="height: 40px;padding: 5px"  value="🔎" disabled  data-toggle='modal' data-target='#lineaModal'/>
                                                    <input type="hidden" id="idlinearunt" />
                                                    <label id="msjidlinea" style="display: none;position: absolute"></label>
                                                </div>
                                                <input class="form-control" id="idlinea" disabled/>
                                            </div>	
                                        </div>
                                        <div class="col-md-12 col-lg-12 col-sm-12" style="margin-top: 20px">
                                            <label for="validationCustomUsername">Carroceria</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <input type="hidden" id="idcarroceriarunt" />
                                                    <input class="btn btn-block bot_verde"  type="button" id="btncarroceria"  style="height: 40px;padding: 5px"  value="🔎" disabled  data-toggle='modal' data-target='#carroceriaModal'/>
                                                    <label id="msjidcarroceria" style="display: none;position: absolute"></label>
                                                </div>
                                                <input class="form-control" id="diseno" disabled/>
                                            </div>	
                                        </div>
                                        <div class="col-md-3 col-lg-6 col-sm-6" style="margin-top: 20px">
                                            <div class="form-group">
                                                <label class="control-label">Servicio</label>
                                                <select class="form-control" id="idservicio" disabled></select>
                                                <label id="msjidservicio" style="display: none;position: absolute"></label>
                                            </div>	
                                        </div>
                                        <div class="col-md-3 col-lg-6 col-sm-6" style="margin-top: 20px">
                                            <div class="form-group">
                                                <label class="control-label">Combustible</label>
                                                <select class="form-control" id="idcombustible" disabled></select>
                                                <label id="msjidcombustible" style="display: none;position: absolute"></label>
                                            </div>	
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Modelo</label>
                                                <input class="form-control" id="ano_modelo" type="number" disabled>
                                                <label id="msjano_modelo" style="display: none;position: absolute"></label>
                                            </div>	
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Kilometraje</label>
                                                <input class="form-control" id="kilometraje" type="number" disabled="">
                                            </div>	
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-4 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12 col-sm-12">
                                            <label for="validationCustomUsername">Color</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <input type="hidden" id="idcolorrunt" />
                                                    <input class="btn btn-block bot_verde" type="button" id="btncolor"  style="height: 40px;padding: 5px"  value="🔎" disabled  data-toggle='modal' data-target='#colorModal'/>
                                                    <label id="msjidcolor" style="display: none;position: absolute"></label>
                                                </div>
                                                <input class="form-control" id="idcolor" disabled/>
                                            </div>	
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-6" style="margin-top: 20px">
                                            <div class="form-group">
                                                <label class="control-label">N° Chasis/serie</label>
                                                <input class="form-control" id="numero_serie"  type="text" disabled>

                                            </div>	
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-6" style="margin-top: 20px">
                                            <div class="form-group">
                                                <label class="control-label">N° de motor</label>
                                                <input class="form-control" id="numero_motor" type="text" disabled>
                                            </div>	
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Vin</label>
                                                <input class="form-control" id="numero_vin" type="text" disabled>
                                            </div>	
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-sm-4" id="div_potencia">
                                            <div class="form-group">
                                                <label class="control-label" >Potencia</label>
                                                <input class="form-control" id="potencia_motor" disabled="">
                                            </div>	
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Cilindraje</label>
                                                <input class="form-control" id="cilindraje" disabled="">
                                            </div>	
                                        </div>
                                        <div class="col-md-12 col-lg-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">N° tarjeta propiedad</label>
                                                <input class="form-control" id="numero_tarjeta_propiedad" disabled="">
                                            </div>	
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Tipo vehiculo</label>
                                                <select class="form-control" id="tipo_vehiculo" onchange="cambiarTV(this)" disabled=""></select>
                                                <strong style="color: #E31F24"></strong>
                                            </div>	
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Fecha matricula</label>
                                                <input type="text" class="form-control" id="fecha_matricula" data-mask="y-m-d" disabled="">
                                            </div>	
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Número ejes</label>
                                                <select class="form-control" id="numejes" disabled=""></select>
                                            </div>

                                        </div>
                                        <div class="col-md-4 col-lg-4 col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Número llantas</label>
                                                <select class="form-control" id="numero_llantas" disabled=""></select>
                                            </div>	
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Número sillas </label>
                                                <input class="form-control" id="numsillas" type="number" disabled="">
                                            </div>	
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-4 col-sm-12">
                                    <div class="row">

                                        <div class="col-md-4 col-lg-4 col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Tiempos</label>
                                                <select class="form-control" id="tiempos" disabled=""></select>
                                            </div>	
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-sm-4" id="div_cilindros">
                                            <div class="form-group">
                                                <label class="control-label" >Cilindros </label>
                                                <select class="form-control" id="cilindros" disabled=""></select>
                                            </div>	
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Enseñanza </label>
                                                <select class="form-control" id="ensenanza" disabled=""></select>
                                            </div>	
                                        </div>
                                        <div class="col-md-8 col-lg-8 col-sm-8">
                                            <div class="form-group">
                                                <label class="control-label">Pasajeros (sin conductor) </label>
                                                <input class="form-control" id="num_pasajeros" type="number" disabled="">
                                            </div>	
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-sm-4" id="div_taximetro">
                                            <div class="form-group">
                                                <label class="control-label">Taximetro </label>
                                                <select class="form-control" id="taximetro" disabled=""></select>
                                            </div>	
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Pais </label>
                                                <select class="form-control" id="idpais" disabled=""></select>
                                            </div>	
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Numero de exostos </label>
                                                <select class="form-control" id="numero_exostos" disabled=""></select>
                                            </div>	
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-6" id="div_convertidor">
                                            <div class="form-group">
                                                <label class="control-label" id="labelScooter">Convertidor catalitico </label>
                                                <select class="form-control" id="scooter" disabled=""></select>
                                            </div>	
                                        </div>
                                        <div class="col-md-3 col-lg-3 col-sm-3" id="div_blindaje">
                                            <div class="form-group">
                                                <label class="control-label">Blindaje </label>
                                                <select class="form-control" id="blindaje" disabled=""></select>
                                            </div>	
                                        </div>
                                        <div class="col-md-3 col-lg-3 col-sm-3" id="div_polarizado">
                                            <div class="form-group">
                                                <label class="control-label">Polarizado </label>
                                                <select class="form-control" id="polarizado" disabled=""></select>
                                            </div>	
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-6" >
                                            <div class="form-group">
                                                <label class="control-label">Fecha vencimiento soat </label>
                                                <input type="text" class="form-control" id="fecha_vencimiento_soat" data-mask="y-m-d" disabled="">
                                            </div>	
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-6" id="div_conversion_gas">
                                            <div class="form-group">
                                                <label class="control-label">Conversion a gas</label>
                                                <select class="form-control" id="chk_3" disabled=""></select>
                                            </div>	
                                        </div>
                                        <div class="col-md-12 col-lg-12 col-sm-12" id="div_fecha_certificado_gas">
                                            <div class="form-group">
                                                <label class="control-label">Fecha certificado gas</label>
                                                <input type="text" class="form-control" id="fecha_final_certgas" data-mask="y-m-d" disabled="">
                                            </div>	
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                </section>

                <section class="box">
                    <div class="row">
                        <div class="col-md-12 col-lg-5 col-sm-12">
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <header class="panel_header" >
                                        <h2 class="title float-left">PROPIETARIO</h2>
                                    </header>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6" style="margin-top: 10px">
                                    <input type="button" id="btnBuscarPropietario" class="btn bot_azul" title="1"  value="Buscar propietario" onclick="BuscarPropietario(this)" disabled />   
                                </div>
                            </div>
                            <input type="hidden" id="idpropietario"/>
                            <div class="row" style="margin-left: 20px">
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <label class="control-label">Documento</label>
                                    <input type="text" class="form-control" id="documento_propietario" disabled="">
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <label class="control-label">Nombres</label>
                                    <input type="text" class="form-control" id="nombre_propietario" disabled="">
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <label class="control-label">Apellidos</label>
                                    <input type="text" class="form-control" id="apellido_propietario" disabled="">
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <label class="control-label">Telefono</label>
                                    <input type="text" class="form-control" id="telefono_propietario" disabled="">
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 col-sm-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <div style="display: flex; justify-content: center; margin-top: 40px">
                                        <label class="form-label" for="field-11">¿La persona que trajo el vehículo es el propietario?</label><br>
                                        <select class="form-control" id="escliente" onchange="escliente(this.value)" disabled></select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <br>
                        <div class="col-md-12 col-lg-5 col-sm-12">
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <header class="panel_header" >
                                        <h2 class="title float-left">CLIENTE</h2>
                                    </header>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6" style="margin-top: 10px; text-align: center">
                                    <input type="button" id="buscar_cliente"  class="btn bot_azul" title="0" onclick="BuscarPropietario(this)"  value="Buscar cliente" disabled/>   
                                </div>
                            </div>
                            <input type="hidden" id="idcliente" />
                            <div class="row" style="margin-right: 20px; margin-left: 20px">
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <label class="control-label">Documento</label>
                                    <input type="text" id="documento_cliente" class="form-control" id="documento_cliente" disabled>
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <label class="control-label">Nombres</label>
                                    <input type="text" id="nombre_cliente" class="form-control" id="nombre_cliente" disabled>
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <label class="control-label">Apellidos</label>
                                    <input type="text" id="apellido_cliente" class="form-control" id="apellido_cliente" disabled>
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <label class="control-label">Telefono</label>
                                    <input type="text" id="telefono_cliente" class="form-control" id="telefono_cliente" disabled>
                                </div>

                            </div>
                        </div>
                    </div>
                    <br>
                </section>

                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="row">
                        <div class="col-md-6 col-lg-3 col-sm-6">
                            <input id="btnGuardar" class="btn  btn-block bot_gris" value="Guardar" onclick="guardarVehiculo()" disabled/>   
                            <label id="msjguardar" style="display: none;position: absolute"></label>
                        </div>
                        <div class="col-md-6 col-lg-3 col-sm-6">
                            <input id="btnGuardarNuevo" type="button" class="btn btn-block bot_gris" type="submit"  value="Guardar y nuevo" onclick="guardarNuevo()" disabled/>   
                        </div>
                        <div class="col-md-6 col-lg-3 col-sm-6">
                            <input id="btnGuardarFinalizar" type="button" class="btn btn-block bot_gris" type="submit"  value="Guardar y finalizar" onclick="guardarFinalizar()" disabled/>   
                        </div>
                        <div class="col-md-6 col-lg-3 col-sm-6">
                            <input class="btn btn-block bot_verde" type="button"  value="Nuevo" onclick="location.reload()"/>   
                        </div>
                    </div>
                </div>


                <br>
                <input type="button" class="btn btn-block bot_rojo"  onclick="location.href = '../CPrincipal';"  value="Cancelar" style="width: 200px"/>   
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
<div class="modal" id="sel_tipo_vehiculo" s tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog animated bounceInDown">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" >Bienvenido al modulo vehiculos.</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="cierre-modal">×</button>
            </div>

            <div class="modal-body" style="background: whitesmoke">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="sel-intro-vehiculo" style="text-align: center; margin-top: 25px;">
                            <div class="row">
                                <div class="col-sm-6 col-lg-6 col-md-6">
                                    <button class="btn-success" onclick="ingresarPlaca()">Ingresar Placa</button>
                                </div>
                                <div class="col-sm-6 col-lg-6 col-md-6">
                                    <button class="btn-success" onclick="selVewhiculo()" >Seleccionar vehiculo</button>
                                </div>
                            </div>
                        </div>


                        <div style="display: none; text-align: center; position: absolute" id="div-buscar-placa">
                            <div class="row">
                                <div class="col-sm-6 col-lg-6 col-md-6">
                                    Placa:
                                </div>
                                <div class="col-sm-6 col-lg-6 col-md-6">
                                    <input id="placaIngresada" type="text" class="form-control" style="width: 250px; text-transform: uppercase"/>
                                </div>
                            </div>
                        </div>


                        <div style="display: none; text-align: center; position: absolute" id="div-selvehiculo">
                            <div class="row">
                                <div class="col-sm-6">
                                    Tipo vehiculo:
                                </div>
                                <div class="col-sm-6">
                                    <select id="select-tipovehiculo" style="width: 220px; height: 40px">
                                        <option value="">Seleccionar</option>
                                        <option value="1">Liviano</option>
                                        <option value="2">Pesado</option>
                                        <option value="3">Moto</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <label id="mensajeModalVehiculo"
                       style="background: white;
                       width: 100%;
                       text-align: center;
                       font-weight: bold;
                       font-size: 15px;
                       padding: 5px;border: solid gray 2px;
                       border-radius:  15px 15px 15px 15px;color: SALMON;display: none"></label>
            </div>
            <div class="modal-footer">
                <div style="text-align: center"></div>
                <div id="btn-save-configuracion"></div>

                <button data-dismiss="modal" class="btn btn-default" type="button" id="cancel-modal-vehiculo">Cancelar</button>
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
<script src="<?php echo base_url(); ?>/application/libraries/package/dist/sweetalert2.all.min.js"></script>
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
<!--        <script src="<?php echo base_url(); ?>assets/sesion.js"  type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>application/libraries/sesion.js"  type="text/javascript"></script>
<script type="text/javascript">

                                        var consultaRunt = '<?php
                    if (isset($consultaRunt)) {
                        echo $consultaRunt;
                    } else {
                        echo'0';
                    }
                    ?>';
                                        var activoSicov = '<?php
                    if (isset($activoSicov)) {
                        echo $activoSicov;
                    } else {
                        echo'0';
                    }
                    ?>';
                                        var ipSicovAlternativo = '<?php
                    if (isset($ipSicovAlternativo)) {
                        echo $ipSicovAlternativo;
                    } else {
                        echo'0';
                    }
                    ?>';
                                        var sicovModoAlternativo = '<?php
                    if (isset($sicovModoAlternativo)) {
                        echo $sicovModoAlternativo;
                    } else {
                        echo'0';
                    }
                    ?>';
                                        var ipSicov = '<?php
                    if (isset($ipSicov)) {
                        echo $ipSicov;
                    } else {
                        echo'0';
                    }
                    ?>';
                                        var usuarioSicov = '<?php
                    if (isset($usuarioSicov)) {
                        echo $usuarioSicov;
                    } else {
                        echo'0';
                    }
                    ?>';
                                        var claveSicov = '<?php
                    if (isset($claveSicov)) {
                        echo $claveSicov;
                    } else {
                        echo'0';
                    }
                    ?>';
                                        var sicov = '<?php
                    if (isset($sicov)) {
                        echo $sicov;
                    } else {
                        echo'0';
                    }
                    ?>';
                                        $(document).ready(function () {
                                            var placa = '<?php echo $this->session->userdata('numero_placa'); ?>';
                                            console.log("placa session" + placa);
                                            var placa2 = localStorage.getItem('placa');
                                            console.log(placa2)
                                            if (placa !== '') {
                                                localStorage.removeItem('placa');
                                                setAtributoVeh('numero_placa', placa);
                                                buscarVehiculo();
                                            } else if (placa2 !== null && placa2 !== '') {
                                                console.log('placa2')
                                                setAtributoVeh('numero_placa', placa2);
                                                buscarVehiculo();

                                            } else {
                                                $("#sel_tipo_vehiculo").modal();
                                            }

                                        });

                                        $("#cancel-modal-vehiculo").click(function () {
                                            location.reload();
                                        })

                                        function ingresarPlaca() {
                                            document.getElementById("sel-intro-vehiculo").style.display = 'none';
                                            document.getElementById("div-buscar-placa").style.display = '';
                                            $("#btn-save-configuracion").html("<button class='btn btn-success' type='button' onclick='IngresoConPlaca()'>Aceptar</button>")
                                        }

                                        function selVewhiculo() {
                                            document.getElementById("sel-intro-vehiculo").style.display = 'none';
                                            document.getElementById("div-selvehiculo").style.display = '';
                                            document.getElementById("div-selvehiculo").style.display = 'relative';
                                            $("#btn-save-configuracion").html("<button class='btn btn-success' type='button' onclick='IngresoConSelVehiculo()'>Aceptar</button>")
                                        }

                                        function IngresoConPlaca() {
                                            var placa = $("#placaIngresada").val();
                                            if (placa == null || placa == "") {
                                                document.getElementById("mensajeModalVehiculo").style.display = '';
                                                $("#mensajeModalVehiculo").text('Ingrese la placa');
                                            } else {
                                                document.getElementById("mensajeModalVehiculo").style.display = 'none';
                                                $("#cierre-modal").click();
                                                $('#numero_placa').val(placa.toString().toUpperCase());
                                                buscarVehiculo();
                                            }
                                        }

                                        function IngresoConSelVehiculo() {
                                            var tipoVehiculo = $('#select-tipovehiculo option:selected').attr("value");
                                            console.log(tipoVehiculo);
                                            if (tipoVehiculo == null || tipoVehiculo == "") {
                                                document.getElementById("mensajeModalVehiculo").style.display = '';
                                                $("#mensajeModalVehiculo").text('Seleccione el tipo vehiculo.');
                                            } else {
                                                $("#cierre-modal").click();
                                                document.getElementById("mensajeModalVehiculo").style.display = 'none';
                                                switch (tipoVehiculo) {
                                                    case '1':
                                                        setAtributoVehSelect('tipo_vehiculo', "<option value='1'>LIVIANO</option>");
                                                        $("#labelScooter").text('Convertidor Catalitico');
                                                        break;
                                                    case '2':
                                                        document.getElementById("div_taximetro").style.display = 'none';
                                                        document.getElementById("div_taximetro").style.position = 'absolute';
                                                        setAtributoVehSelect('tipo_vehiculo', "<option value='2'>PESADO</option>");
                                                        break;

                                                    default:
                                                        $("#labelScooter").text('Scooter');
                                                        setAtributoVehSelect('tipo_vehiculo', "<option value='3'>MOTO</option>");
                                                        //document.getElementById("div_potencia").style.display = 'none';
                                                        //document.getElementById("div_potencia").style.position = 'absolute';
//                                                        document.getElementById("div_cilindros").style.display = 'none';
//                                                        document.getElementById("div_cilindros").style.position = 'absolute';
                                                        document.getElementById("div_blindaje").style.display = 'none';
                                                        document.getElementById("div_blindaje").style.position = 'absolute';
                                                        document.getElementById("div_polarizado").style.display = 'none';
                                                        document.getElementById("div_polarizado").style.position = 'absolute';
                                                        document.getElementById("div_conversion_gas").style.display = 'none';
                                                        document.getElementById("div_conversion_gas").style.position = 'absolute';
                                                        document.getElementById("div_fecha_certificado_gas").style.display = 'none';
                                                        document.getElementById("div_fecha_certificado_gas").style.position = 'absolute';
                                                        document.getElementById("div_taximetro").style.display = 'none';
                                                        document.getElementById("div_taximetro").style.position = 'absolute';
                                                        break;
                                                }
                                                document.getElementById("mensajeModalVehiculo").style.display = 'none';
                                            }
                                        }



                                        var buscarColores = function (tipo) {
                                            var color = $('#textoColor').val();
                                            document.getElementById('listaColores').innerHTML = "";
                                            if ((color.toString().length > 2 && tipo === 'a') || tipo === 'e') {
                                                $('#mensaje').text('BUSCANDO');
                                                var data = {
                                                    textocolor: color
                                                };
                                                var url = "";
                                                if (tipo === 'a') {
                                                    url = '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/getColores';
                                                } else {
                                                    url = '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/getColoresE';
                                                }
                                                $.ajax({
                                                    url: url,
                                                    data: data,
                                                    type: 'post',
                                                    success: function (rta) {
                                                        document.getElementById('listaColores').innerHTML = rta;
                                                        $('#mensaje').text('FINALIZADO');
                                                    }
                                                });
                                            } else {
                                                $('#mensaje').text('MÍNIMO 3 CARACTERES PARA INICIAR LA BUSQUEDA');
                                            }
                                        };
                                        var buscarCarroceria = function (tipo) {
                                            var carroceria = $('#textoCarroceria').val();
                                            document.getElementById('listaCarrocerias').innerHTML = "";
                                            if ((carroceria.toString().length > 2 && tipo === 'a') || tipo === 'e') {
                                                $('#mensajeC').text('BUSCANDO');
                                                var data = {
                                                    textocarroceria: carroceria
                                                };
                                                var url = "";
                                                if (tipo === 'a') {
                                                    url = '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/getCarrocerias';
                                                } else {
                                                    url = '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/getCarroceriasE';
                                                }
                                                $.ajax({
                                                    url: url,
                                                    data: data,
                                                    type: 'post',
                                                    success: function (rta) {
                                                        document.getElementById('listaCarrocerias').innerHTML = rta;
                                                        $('#mensajeC').text('FINALIZADO');
                                                    }
                                                });
                                            } else {
                                                $('#mensajeC').text('MÍNIMO 3 CARACTERES PARA INICIAR LA BUSQUEDA');
                                            }
                                        };
                                        var buscarMarcas = function (tipo) {
                                            var marca = $('#textoMarca').val();
                                            document.getElementById('listaMarcas').innerHTML = "";
                                            if ((marca.toString().length > 2 && tipo === 'a') || tipo === 'e') {
                                                $('#mensajeM').text('BUSCANDO');
                                                var data = {
                                                    textomarca: marca
                                                };
                                                var url = "";
                                                if (tipo === 'a') {
                                                    url = '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/getMarcas';
                                                } else {
                                                    url = '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/getMarcasE';
                                                }
                                                $.ajax({
                                                    url: url,
                                                    data: data,
                                                    type: 'post',
                                                    success: function (rta) {
                                                        document.getElementById('listaMarcas').innerHTML = rta;
                                                        $('#mensajeM').text('FINALIZADO');
                                                    }
                                                });
                                            } else {
                                                $('#mensajeM').text('MÍNIMO 3 CARACTERES PARA INICIAR LA BUSQUEDA');
                                            }
                                        };
                                        var buscarLineas = function (tipo) {
                                            var linea = $('#textoLinea').val();
                                            document.getElementById('listaLineas').innerHTML = "";
                                            if ((linea.toString().length > 2 && tipo === 'a') || tipo === 'e') {
                                                $('#mensajeL').text('BUSCANDO');
                                                var data = {
                                                    textolinea: linea,
                                                    codigo: idmarca
                                                };
                                                var url = "";
                                                if (tipo === 'a') {
                                                    url = '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/getLineas';
                                                } else {
                                                    url = '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/getLineasE';
                                                }
                                                $.ajax({
                                                    url: url,
                                                    data: data,
                                                    type: 'post',
                                                    success: function (rta) {
                                                        document.getElementById('listaLineas').innerHTML = rta;
                                                        $('#mensajeL').text('FINALIZADO');
                                                    }
                                                });
                                            } else {
                                                $('#mensajeL').text('MÍNIMO 3 CARACTERES PARA INICIAR LA BUSQUEDA');
                                            }
                                        };
                                        var asignarColor = function (e) {
                                            document.getElementById('listaColores').innerHTML = "";
                                            $('#idcolorrunt').val(e.id);
                                            $('#idcolor').val(e.value);
                                            $("#colorModal").modal('hide');
                                        };
                                        var asignarMarca = function (e) {
                                            document.getElementById('listaMarcas').innerHTML = "";
                                            idmarca = e.id;
                                            $('#idmarcarunt').val(e.id);
                                            $('#idmarca').val(e.value);
                                            $("#marcaModal").modal('hide');
                                        };
                                        var asignarCarroceria = function (e) {
                                            document.getElementById('listaCarrocerias').innerHTML = "";
                                            $('#idcarroceriarunt').val(e.id);
                                            $('#diseno').val(e.value);
                                            $("#carroceriaModal").modal('hide');
                                        };
                                        var asignarLinea = function (e) {
                                            document.getElementById('listaLineas').innerHTML = "";
                                            idlinea = e.id;
                                            $('#idlinearunt').val(e.id);
                                            $('#idlinea').val(e.value);
                                            $("#lineaModal").modal('hide');
                                        };
                                        var vehiculo = new Object();
                                        var escliente = function (valor) {
                                            if (valor === "SI") {
                                                document.getElementById("buscar_cliente").disabled = true;
                                                setAtributoVehPer('idcliente', vehiculo.idpropietario);
                                                setAtributoVehPer('documento_cliente', vehiculo.documento_propietario);
                                                setAtributoVehPer('nombre_cliente', vehiculo.nombre_propietario);
                                                setAtributoVehPer('apellido_cliente', vehiculo.apellido_propietario);
                                                setAtributoVehPer('telefono_cliente', vehiculo.telefono_propietario);
                                            } else {
                                                document.getElementById("buscar_cliente").disabled = false;
                                                setAtributoVehPer('idcliente', '');
                                                setAtributoVehPer('documento_cliente', '');
                                                setAtributoVehPer('nombre_cliente', '');
                                                setAtributoVehPer('apellido_cliente', '');
                                                setAtributoVehPer('telefono_cliente', '');
                                            }
                                        };
                                        var buscarVehiculo = function () {
                                            vehiculo = new Object();
                                            limpiarFormulario();
                                            $('#numero_placa').val($('#numero_placa').val().toString().toUpperCase());
                                            if (cumple('numero_placa', 'PLACA')) {
                                                habilitarComponente('numero_placa', false);
                                                getVehiculo($("#numero_placa").val());
                                                if (vehiculo.tipo_vehiculo !== undefined) {
                                                    if (vehiculo.tipo_vehiculo === '<option value="1">LIVIANO</option>') {
                                                        $('#select-tipovehiculo').html("<option value='1'>LIVIANO</option>");
//                                                    $('#idclase').html("<option value='1'>AUTOMOVIL</option>");
                                                        IngresoConSelVehiculo();
                                                    } else if (vehiculo.tipo_vehiculo === '<option value="2">PESADO</option>') {
                                                        $('#select-tipovehiculo').html("<option value='2'>PESADO</option>");
//                                                    $('#idclase').html("<option value='1'>AUTOMOVIL</option>");
                                                        IngresoConSelVehiculo();
                                                    } else {
                                                        $('#select-tipovehiculo').html("<option value='3'>MOTO</option>");
//                                                    $('#idclase').html("<option value='10'>MOTOCICLETA</option>");
                                                        IngresoConSelVehiculo();
                                                    }
                                                }

//                                                var idClase = getIdClase(clase);
//                                                ve.idclase = "<option value='" + idClase + "'>" + clase + "</option>";
                                                if (vehiculo.numero_placa !== undefined) {

//                                                    if (consultaRunt === '1' && activoSicov === '1' && sicov === 'CI2') {
//                                                        vehiculo = consultarRuntxCi2($("#numero_placa").val(), vehiculo);
//                                                    }
//                                                    if (consultaRunt === '1' && activoSicov === '1' && sicov === 'INDRA') {
//                                                        vehiculo = consultaRuntxIndra($("#numero_placa").val(), vehiculo);
//                                                    }

                                                    setAtributoVehSelect('idclase', vehiculo.idclase);
                                                    setAtributoVehSelect('idservicio', vehiculo.idservicio);
                                                    setAtributoVehSelect('idcombustible', vehiculo.idcombustible);
                                                    setAtributoVeh('idcolorrunt', vehiculo.idcolorrunt);
                                                    setAtributoVeh('idmarca', vehiculo.idmarca);
                                                    habilitarComponente('idmarca', false);
                                                    setAtributoVeh('idcolor', vehiculo.idcolor);
                                                    habilitarComponente('idcolor', false);
                                                    setAtributoVeh('idlinearunt', vehiculo.idlineaRUNT);
                                                    idlinea = vehiculo.idlineaRUNT;
                                                    setAtributoVeh('idlinea', vehiculo.idlinea);
                                                    habilitarComponente('idlinea', false);
                                                    setAtributoVeh('idcarroceriarunt', vehiculo.idcarroceriarunt);
                                                    setAtributoVeh('diseno', vehiculo.diseno);
                                                    habilitarComponente('diseno', false);
                                                    setAtributoVeh('ano_modelo', vehiculo.ano_modelo);
                                                    setAtributoVeh('numero_serie', vehiculo.numero_serie);
                                                    setAtributoVeh('numero_motor', vehiculo.numero_motor);
                                                    setAtributoVeh('numero_vin', vehiculo.numero_vin);
                                                    setAtributoVeh('potencia_motor', vehiculo.potencia_motor);
                                                    setAtributoVeh('cilindraje', vehiculo.cilindraje);
                                                    setAtributoVeh('numero_tarjeta_propiedad', vehiculo.numero_tarjeta_propiedad);
                                                    setAtributoVeh('kilometraje', vehiculo.kilometraje);
                                                    setAtributoVehSelect('tipo_vehiculo', vehiculo.tipo_vehiculo);
                                                    var tipoVehiculo = $('#select-tipovehiculo option:selected').attr("value");
                                                    if (tipoVehiculo === '3') {
                                                        $("#labelScooter").text('Scooter');
                                                    } else {
                                                        $("#labelScooter").text('Convertidor Catalitico');
                                                    }
                                                    setAtributoVeh('fecha_matricula', vehiculo.fecha_matricula);
                                                    setAtributoVehSelect('numejes', vehiculo.numejes);
                                                    setAtributoVehSelect('numero_llantas', vehiculo.numero_llantas);
                                                    setAtributoVehSelect('tiempos', vehiculo.tiempos);
                                                    setAtributoVeh('numsillas', vehiculo.numsillas);
                                                    setAtributoVeh('num_pasajeros', vehiculo.num_pasajeros);
                                                    setAtributoVehSelect('cilindros', vehiculo.cilindros);
                                                    setAtributoVehSelect('ensenanza', vehiculo.ensenanza);
                                                    setAtributoVehSelect('taximetro', vehiculo.taximetro);
                                                    setAtributoVehSelect('idpais', vehiculo.idpais);
                                                    setAtributoVehSelect('numero_exostos', vehiculo.numero_exostos);
                                                    setAtributoVehSelect('scooter', vehiculo.scooter);
                                                    setAtributoVehSelect('blindaje', vehiculo.blindaje);
                                                    setAtributoVehSelect('polarizado', vehiculo.polarizado);
                                                    setAtributoVeh('fecha_vencimiento_soat', vehiculo.fecha_vencimiento_soat);
                                                    setAtributoVehSelect('chk_3', vehiculo.chk_3);
                                                    setAtributoVeh('fecha_final_certgas', vehiculo.fecha_final_certgas);
                                                    setAtributoVehPer('idpropietario', vehiculo.idpropietario);
                                                    setAtributoVehPer('documento_propietario', vehiculo.documento_propietario);
                                                    setAtributoVehPer('nombre_propietario', vehiculo.nombre_propietario);
                                                    setAtributoVehPer('apellido_propietario', vehiculo.apellido_propietario);
                                                    setAtributoVehPer('telefono_propietario', vehiculo.telefono_propietario);
                                                    setAtributoVehPer('idcliente', vehiculo.idcliente);
                                                    setAtributoVehPer('documento_cliente', vehiculo.documento_cliente);
                                                    setAtributoVehPer('nombre_cliente', vehiculo.nombre_cliente);
                                                    setAtributoVehPer('apellido_cliente', vehiculo.apellido_cliente);
                                                    setAtributoVehPer('telefono_cliente', vehiculo.telefono_cliente);
                                                    document.getElementById('escliente').innerHTML = "";
                                                    if (vehiculo.idcliente === vehiculo.idpropietario) {
                                                        document.getElementById('escliente').innerHTML += "<option value='SI'>SI</option>";
                                                        document.getElementById('escliente').innerHTML += "<option value='NO'>NO</option>";
                                                        habilitarComponente('buscar_cliente', false);
                                                    } else {
                                                        document.getElementById('escliente').innerHTML += "<option value='NO'>NO</option>";
                                                        document.getElementById('escliente').innerHTML += "<option value='SI'>SI</option>";
                                                        habilitarComponente('buscar_cliente', true);
                                                    }

                                                } else {

                                                    var tipoVehiculo = $('#select-tipovehiculo option:selected').attr("value");
                                                    if (tipoVehiculo === '3') {
                                                        $("#labelScooter").text('Scooter');
                                                    } else {
                                                        $("#labelScooter").text('Convertidor Catalitico');
                                                    }
//                                                    $("#labelScooter").text('CONVERTIDOR CATALITICO');
                                                    if (consultaRunt === '1' && activoSicov === '1' && sicov === 'CI2') {
                                                        vehiculo = consultarRuntxCi2($("#numero_placa").val(), vehiculo);
                                                        setAtributoVehSelect('idclase', vehiculo.idclase);
                                                        setAtributoVehSelect('idservicio', vehiculo.idservicio);
                                                        setAtributoVehSelect('idcombustible', vehiculo.idcombustible);
                                                        setAtributoVeh('idmarcarunt', vehiculo.idmarcaRUNT);
                                                        setAtributoVeh('idmarca', vehiculo.idmarca);
                                                        setAtributoVeh('idlinearunt', vehiculo.idlinearunt);
                                                        setAtributoVeh('idlinea', vehiculo.idlinea);
                                                        setAtributoVeh('idcolorrunt', vehiculo.idcolorrunt);
                                                        setAtributoVeh('idcolor', vehiculo.idcolor);
                                                        setAtributoVeh('ano_modelo', vehiculo.ano_modelo);
                                                        setAtributoVeh('numero_serie', vehiculo.numero_serie);
                                                        setAtributoVeh('numero_motor', vehiculo.numero_motor);
                                                        setAtributoVeh('numero_vin', vehiculo.numero_vin);
                                                        setAtributoVeh('fecha_matricula', vehiculo.fecha_matricula);
                                                        setAtributoVeh('numsillas', vehiculo.numsillas);
                                                        setAtributoVeh('num_pasajeros', vehiculo.num_pasajeros);
                                                        setAtributoVehSelect('blindaje', vehiculo.blindaje);
                                                        setAtributoVeh('fecha_vencimiento_soat', vehiculo.fecha_vencimiento_soat);
                                                        setAtributoVeh('cilindraje', '');
                                                        setAtributoVeh('numero_tarjeta_propiedad', '');
                                                        setAtributoVeh('idcarroceriarunt', '0');
                                                        setAtributoVeh('diseno', 'SIN CARROCERIA');
                                                    } else if (consultaRunt === '1' && activoSicov === '1' && sicov === 'INDRA') {
                                                        vehiculo = consultaRuntxIndra($("#numero_placa").val(), vehiculo);
                                                        setAtributoVehSelect('idclase', vehiculo.idclase);
                                                        setAtributoVehSelect('idservicio', vehiculo.idservicio);
                                                        setAtributoVehSelect('idcombustible', vehiculo.idcombustible);
                                                        setAtributoVeh('idmarcarunt', vehiculo.idmarcaRUNT);
                                                        setAtributoVeh('idmarca', vehiculo.idmarca);
                                                        setAtributoVeh('idlinearunt', vehiculo.idlinearunt);
                                                        setAtributoVeh('idlinea', vehiculo.idlinea);
                                                        setAtributoVeh('idcolorrunt', vehiculo.idcolorrunt);
                                                        setAtributoVeh('idcolor', vehiculo.idcolor);
                                                        setAtributoVeh('cilindraje', vehiculo.cilindraje);
                                                        setAtributoVeh('numero_tarjeta_propiedad', vehiculo.numero_tarjeta_propiedad);
                                                        setAtributoVeh('ano_modelo', vehiculo.ano_modelo);
                                                        setAtributoVeh('numero_serie', vehiculo.numero_serie);
                                                        setAtributoVeh('numero_motor', vehiculo.numero_motor);
                                                        setAtributoVeh('numero_vin', vehiculo.numero_vin);
                                                        setAtributoVeh('fecha_matricula', vehiculo.fecha_matricula);
                                                        setAtributoVeh('numsillas', vehiculo.numsillas);
                                                        setAtributoVeh('num_pasajeros', vehiculo.num_pasajeros);
                                                        setAtributoVehSelect('blindaje', vehiculo.blindaje);
                                                        setAtributoVehSelect('polarizado', vehiculo.polarizado);
                                                        setAtributoVeh('idcarroceriarunt', vehiculo.idcarroceriarunt);
                                                        setAtributoVeh('diseno', vehiculo.diseno);
                                                        setAtributoVeh('fecha_vencimiento_soat', vehiculo.fecha_vencimiento_soat);
                                                    } else {
                                                        setAtributoVehSelect('idclase', "<option value='1'>AUTOMOVIL</option>");
                                                        setAtributoVeh('idmarcarunt', "0");
                                                        setAtributoVeh('idmarca', "SIN MARCA");
                                                        setAtributoVehSelect('idservicio', "<option value='3'>PARTICULAR</option>");
                                                        setAtributoVehSelect('idcombustible', "<option value='2'>GASOLINA</option>");
                                                        setAtributoVeh('idcolorrunt', '0');
                                                        setAtributoVeh('idcolor', "SIN COLOR");
                                                        setAtributoVeh('numero_tarjeta_propiedad', '');
                                                        setAtributoVeh('cilindraje', '');
                                                        setAtributoVeh('ano_modelo', '');
                                                        setAtributoVeh('numero_serie', '');
                                                        setAtributoVeh('numero_motor', '');
                                                        setAtributoVeh('numero_vin', '');
                                                        setAtributoVeh('fecha_matricula', '');
                                                        setAtributoVeh('numsillas', "5");
                                                        setAtributoVeh('num_pasajeros', "4");
                                                        setAtributoVehSelect('blindaje', "<option value='0'>NO</option>");
                                                        setAtributoVehSelect('polarizado', "<option value='0'>NO</option>");
                                                        setAtributoVeh('fecha_vencimiento_soat', '');
                                                    }
                                                    setAtributoVeh('potencia_motor', '');
                                                    setAtributoVeh('kilometraje', '');
                                                    setAtributoVehSelect('tipo_vehiculo', "<option value='1'>LIVIANO</option>");
                                                    setAtributoVehSelect('numejes', "<option value='2'>2</option>");
                                                    setAtributoVehSelect('numero_llantas', "<option value='4'>4</option>");
                                                    setAtributoVehSelect('tiempos', "<option value='4'>4</option>");
                                                    setAtributoVehSelect('cilindros', "<option value='1'>1</option>");
                                                    setAtributoVehSelect('ensenanza', "<option value='0'>NO</option>");
                                                    setAtributoVehSelect('taximetro', "<option value='0'>NO</option>");
                                                    setAtributoVehSelect('idpais', "<option value='90'>COLOMBIA</option>");
                                                    setAtributoVehSelect('numero_exostos', "<option value='1'>1</option>");
                                                    setAtributoVehSelect('scooter', "<option value='0'>NO</option>");
                                                    setAtributoVehSelect('chk_3', "<option value='NA'>NO APLICA</option>");
                                                    setAtributoVeh('fecha_final_certgas', '');
                                                    setAtributoVehPer('idpropietario', '');
                                                    setAtributoVehPer('documento_propietario', '');
                                                    setAtributoVehPer('nombre_propietario', '');
                                                    setAtributoVehPer('apellido_propietario', '');
                                                    setAtributoVehPer('telefono_propietario', '');
                                                    setAtributoVehPer('idcliente', '');
                                                    setAtributoVehPer('documento_cliente', '');
                                                    setAtributoVehPer('nombre_cliente', '');
                                                    setAtributoVehPer('apellido_cliente', '');
                                                    setAtributoVehPer('telefono_cliente', '');
                                                    document.getElementById('escliente').innerHTML = "";
                                                    document.getElementById('escliente').innerHTML += "<option value='SI'>SI</option>";
                                                    document.getElementById('escliente').innerHTML += "<option value='NO'>NO</option>";
                                                    habilitarComponente('buscar_cliente', false);
                                                    habilitarComponente('idcolor', false);
                                                    habilitarComponente('idmarca', false);
                                                    habilitarComponente('idlinea', false);
                                                    habilitarComponente('diseno', false);
                                                }
                                                habilitarComponente('btncarroceria', true);
                                                habilitarComponente('btnlinea', true);
                                                habilitarComponente('btnmarca', true);
                                                habilitarComponente('btncolor', true);
                                                habilitarComponente('btnBuscarPropietario', true);
                                                habilitarComponente('escliente', true);
                                                habilitarComponente('btnGuardar', true);
                                                habilitarComponente('btnGuardarNuevo', true);
                                                habilitarComponente('btnGuardarFinalizar', true);
                                            }
                                        };

                                        var consultaRuntxIndra = function (placa, ve) {
                                            data = {
                                                placa: placa,
                                                extranjero: $("#extranjero").val(),
                                                ip: ipSicov
                                            };
                                            $.ajax({
                                                url: '<?php echo base_url() ?>index.php/OFCConsultarRunt/ConsultarXIndra',
                                                data: data,
                                                type: 'post',
                                                async: false,
                                                success: function (respuesta) {
                                                    var v = JSON.parse(respuesta);
                                                    ve.numero_placa = placa;
                                                    if (v.codRespuesta === 1) {
                                                        var servicio = v.vehRespuesta.TipoServicio.toString().toUpperCase();
                                                        var idServicio = 3;
                                                        switch (servicio) {
                                                            case "PARTICULAR":
                                                                idServicio = 3;
                                                                break;
                                                            case "PÚBLICO":
                                                                idServicio = 2;
                                                                break;
                                                            case "PUBLICO":
                                                                idServicio = 2;
                                                                break;
                                                            case "DIPLOMÁTICO":
                                                                idServicio = 4;
                                                                break;
                                                            case "DIPLOMATICO":
                                                                idServicio = 4;
                                                                break;
                                                            case "OFICIAL":
                                                                idServicio = 1;
                                                                break;
                                                            case "ESPECIALRNMA":
                                                                idServicio = 7;
                                                                break;
                                                            default:
                                                                idServicio = 3;
                                                                break;
                                                        }
                                                        ve.idservicio = "<option value='" + idServicio + "'>" + servicio + "</option>";
                                                        var clase = v.vehRespuesta.Clase.toString().toUpperCase();
                                                        var idClase = getIdClase(clase);
                                                        ve.idclase = "<option value='" + idClase + "'>" + clase + "</option>";
                                                        ve.numero_tarjeta_propiedad = v.vehRespuesta.Licencia;
                                                        ve.idmarca = v.vehRespuesta.Marca.toString().toUpperCase();
                                                        ve.idmarcarunt = v.vehRespuesta.CodigoMarca.toString().toUpperCase();
                                                        ve.idlinea = v.vehRespuesta.Linea.toString().toUpperCase();
                                                        ve.idlinearunt = getIdLinea(v.vehRespuesta.CodigoLinea, v.vehRespuesta.CodigoMarca); //v.vehRespuesta.CodigoLinea.toString().toUpperCase();
                                                        ve.ano_modelo = v.vehRespuesta.Modelo;
                                                        ve.numsillas = v.vehRespuesta.CantSillas;
                                                        ve.num_pasajeros = v.vehRespuesta.CapacidadPasajeros;
                                                        ve.idcolor = v.vehRespuesta.Color.toString().toUpperCase();
                                                        ve.idcolorrunt = v.vehRespuesta.CodigoColor.toString().toUpperCase();
                                                        if (v.vehRespuesta.Serie == "") {
                                                            ve.numero_serie = v.vehRespuesta.Chasis;
                                                        } else {
                                                            ve.numero_serie = v.vehRespuesta.Serie;
                                                        }
                                                        ve.numero_motor = v.vehRespuesta.MotorNo;
                                                        if (v.vehRespuesta.VIN === '') {
                                                            ve.numero_vin = '****';
                                                        } else {
                                                            ve.numero_vin = v.vehRespuesta.VIN;
                                                        }
                                                        ve.cilindraje = v.vehRespuesta.Cilindraje.toString().toLocaleUpperCase();
                                                        var combustible = v.vehRespuesta.Combustible.toString().toUpperCase();
                                                        switch (servicio) {
                                                            case "DIESEL":
                                                                idcombustible = 1;
                                                                break;
                                                            case "DIÉSEL":
                                                                idcombustible = 1;
                                                                break;
                                                            case "GASOLINA":
                                                                idcombustible = 2;
                                                                break;
                                                            case "GNV":
                                                                idcombustible = 3;
                                                                break;
                                                            case "GAS GASOL":
                                                                idcombustible = 4;
                                                                break;
                                                            case "ELECTRICO":
                                                                idcombustible = 5;
                                                                break;
                                                            case "HIDROGENO":
                                                                idcombustible = 6;
                                                                break;
                                                            case "ETANOL":
                                                                idcombustible = 7;
                                                                break;
                                                            case "BIODIESEL":
                                                                idcombustible = 8;
                                                                break;
                                                            case "GLP":
                                                                idcombustible = 9;
                                                                break;
                                                            case "GASO ELEC":
                                                                idcombustible = 10;
                                                                break;
                                                            case "DIES ELEC":
                                                                idcombustible = 11;
                                                                break;
                                                            default:
                                                                idcombustible = 2;
                                                                break;
                                                        }
                                                        ve.idcombustible = "<option value='" + idcombustible + "'>" + combustible + "</option>";
                                                        var fechaMat = v.vehRespuesta.FechaMatricula.split('T');
                                                        ve.fecha_matricula = fechaMat[0];
                                                        ve.num_pasajeros = v.vehRespuesta.CapacidadPasajeros.toString().toLocaleUpperCase();
                                                        ve.numejes = v.vehRespuesta.CantEjes.toString().toLocaleUpperCase();
                                                        if (v.vehRespuesta.Blindado === 'NO' || v.vehRespuesta.Blindado === '') {
                                                            ve.blindaje = "<option value='0'>NO</option>";
                                                        } else {
                                                            ve.blindaje = "<option value='1'>SI</option>";
                                                        }
                                                        var FechaSoat = v.vehRespuesta.FechaSoat.split('T');
                                                        ve.fecha_vencimiento_soat = FechaSoat[0];

                                                        if (v.vehRespuesta.VidriosPolarizados === 'NO' || v.vehRespuesta.VidriosPolarizados === 'N') {
                                                            ve.polarizado = "<option value='0'>NO</option>";
                                                        } else {
                                                            ve.polarizado = "<option value='1'>SI</option>";
                                                        }

                                                        ve.diseno = v.vehRespuesta.TipoCarroceria.toString().toUpperCase();
                                                        ve.idcarroceriarunt = v.vehRespuesta.CodigoTipoCarroceria.toString().toUpperCase();
                                                        // var clase = v.vehRespuesta.Marca.toString().toUpperCase();
                                                        //------------------------------------------------------------------------------



                                                        // if (v.vehRespuesta.esEnsenanza === 'NO') {
                                                        //     ve.ensenanza = "<option value='0'>NO</option>";
                                                        // } else {
                                                        //     ve.ensenanza = "<option value='1'>SI</option>";
                                                        // }

                                                        // if (v.ConsultaRUNTResult.datosCdasRtm === "SI") {
                                                        //     $("#modalOtroCda").modal();
                                                        // }
//
//                                                        if (v.ConsultaRUNTResult.datosSoat.estado === "NO VIGENTE") {
//                                                            $("#noVigente").modal();
//                                                        }
                                                    } else {
                                                        ve.idclase = "<option value='1'>AUTOMOVIL</option>";
                                                        ve.idmarcarunt = '0';
                                                        ve.idmarca = 'SIN MARCA';
                                                        ve.idlinearunt = '0';
                                                        ve.idlinea = 'SIN LINEA';
                                                        ve.idservicio = "<option value='3'>PARTICULAR</option>";
                                                        ve.idcombustible = "<option value='2'>GASOLINA</option>";
                                                        ve.idcolorrunt = '0';
                                                        ve.idcolor = "SIN COLOR";
                                                        ve.ano_modelo = '';
                                                        ve.numero_serie = '';
                                                        ve.numero_motor = '';
                                                        ve.numero_vin = '';
                                                        ve.fecha_matricula = '';
                                                        ve.numsillas = "5";
                                                        ve.num_pasajeros = "4";
                                                        ve.blindaje = "<option value='0'>NO</option>";
                                                        ve.fecha_vencimiento_soat = '';
                                                    }
                                                }
                                            });
                                            return ve;
                                        }

                                        var getIdClase = function (nombre) {
                                            var idclase = "1";
                                            data = {
                                                nombre: nombre
                                            };
                                            $.ajax({
                                                url: '<?php echo base_url() ?>index.php/oficina/vehiculo/Cvehiculo/getIdClase',
                                                data: data,
                                                type: 'post',
                                                async: false,
                                                success: function (idclase_) {
                                                    idclase = idclase_;
                                                }
                                            });
                                            return idclase;
                                        };
                                        var getIdMarca = function (nombre) {
                                            var idmarca = "0";
                                            data = {
                                                nombre: nombre
                                            };
                                            $.ajax({
                                                url: '<?php echo base_url() ?>index.php/oficina/vehiculo/Cvehiculo/getIdMarca',
                                                data: data,
                                                type: 'post',
                                                async: false,
                                                success: function (idmarca_) {
                                                    idmarca = idmarca_;
                                                }
                                            });
                                            return idmarca;
                                        };
                                        var getIdColor = function (nombre) {
                                            var idcolor = "0";
                                            data = {
                                                nombre: nombre
                                            };
                                            $.ajax({
                                                url: '<?php echo base_url() ?>index.php/oficina/vehiculo/Cvehiculo/getIdColor',
                                                data: data,
                                                type: 'post',
                                                async: false,
                                                success: function (idcolor_) {
                                                    idcolor = idcolor_;
                                                }
                                            });
                                            return idcolor;
                                        };
                                        var getIdLinea = function (nombre, idmarca) {
                                            var idlinea = "0";
                                            data = {
                                                idmarca: idmarca,
                                                nombre: nombre
                                            };
                                            $.ajax({
                                                url: '<?php echo base_url() ?>index.php/oficina/vehiculo/Cvehiculo/getIdLinea',
                                                data: data,
                                                type: 'post',
                                                async: false,
                                                success: function (idlinea_) {
                                                    idlinea = idlinea_;
                                                }
                                            });
                                            return idlinea;
                                        };
                                        var consultarRuntxCi2 = function (placa, ve) {
                                            data = {
                                                placa: placa,
                                                usuario: usuarioSicov,
                                                clave: claveSicov
                                            };
                                            $.ajax({
                                                url: '<?php echo base_url() ?>index.php/OFCConsultarRunt/ConsultarXCi2',
                                                data: data,
                                                type: 'post',
                                                async: false,
                                                success: function (respuesta) {
                                                    var v = JSON.parse(respuesta);
                                                    ve.numero_placa = placa;
                                                    if (v.ConsultaRUNTResult.CodigoRespuesta === '0000') {
                                                        ve.numero_serie = v.ConsultaRUNTResult.noSerie;
                                                        ve.idmarcarunt = v.ConsultaRUNTResult.idMarca;
                                                        ve.idmarca = v.ConsultaRUNTResult.marca.toString().toUpperCase();
                                                        ve.idlinearunt = v.ConsultaRUNTResult.idLinea;
                                                        ve.idlinea = v.ConsultaRUNTResult.linea.toString().toUpperCase();
                                                        var idServicio = v.ConsultaRUNTResult.idTipoServicio;
                                                        if (v.ConsultaRUNTResult.idTipoServicio === '1') {
                                                            idServicio = '3';
                                                        } else if (v.ConsultaRUNTResult.idTipoServicio === '3') {
                                                            idServicio = '4';
                                                        } else if (v.ConsultaRUNTResult.idTipoServicio === '4') {
                                                            idServicio = '1';
                                                        }
                                                        ve.idservicio = "<option value='" + idServicio + "'>" + v.ConsultaRUNTResult.tipoServicio.toString().toUpperCase() + "</option>";
                                                        ve.idcolorrunt = v.ConsultaRUNTResult.idColor.toString().toUpperCase();
                                                        ve.idcolor = v.ConsultaRUNTResult.color;
                                                        ve.ano_modelo = v.ConsultaRUNTResult.modelo;
                                                        var idcombustible = v.ConsultaRUNTResult.idTipoCombustible;
                                                        if (idcombustible === '1') {
                                                            idcombustible = '2';
                                                        } else if (idcombustible === '2') {
                                                            idcombustible = '3';
                                                        } else if (idcombustible === '3') {
                                                            idcombustible = '1';
                                                        }
                                                        ve.idcombustible = "<option value='" + idcombustible + "'>" + v.ConsultaRUNTResult.tipoCombustible.toString().toUpperCase() + "</option>";
                                                        ve.idclase = "<option value='" + v.ConsultaRUNTResult.idClaseVehiculo + "'>" + v.ConsultaRUNTResult.claseVehiculo + "</option>";
                                                        ve.numero_motor = v.ConsultaRUNTResult.noMotor;
                                                        if (v.ConsultaRUNTResult.noVIN === '') {
                                                            ve.numero_vin = '****';
                                                        } else {
                                                            ve.numero_vin = v.ConsultaRUNTResult.noVIN;
                                                        }
                                                        ve.numsillas = v.ConsultaRUNTResult.capacidadPasajerosSentados;
                                                        ve.num_pasajeros = parseInt(v.ConsultaRUNTResult.capacidadPasajerosSentados) - 1;
                                                        if (v.ConsultaRUNTResult.blindado === 'NO' || v.ConsultaRUNTResult.blindado === "N") {
                                                            ve.blindaje = "<option value='0'>NO</option>";
                                                        } else {
                                                            ve.blindaje = "<option value='1'>SI</option>";
                                                        }
                                                        var fechaMat = v.ConsultaRUNTResult.fechaMatricula.split('/');
                                                        ve.fecha_matricula = fechaMat[2] + "-" + fechaMat[1] + "-" + fechaMat[0];
                                                        if (v.ConsultaRUNTResult.esEnsenanza === 'NO' || v.ConsultaRUNTResult.esEnsenanza === 'N') {
                                                            ve.ensenanza = "<option value='0'>NO</option>";
                                                        } else {
                                                            ve.ensenanza = "<option value='1'>SI</option>";
                                                        }
                                                        var fechaSoat = v.ConsultaRUNTResult.datosSoat.fechaVencimiento.split('/');
                                                        ve.fecha_vencimiento_soat = fechaSoat[2] + "-" + fechaSoat[1] + "-" + fechaSoat[0];
                                                        if (v.ConsultaRUNTResult.datosCdasRtm === "SI") {
                                                            $("#modalOtroCda").modal();
                                                        }
//
//                                                        if (v.ConsultaRUNTResult.datosSoat.estado === "NO VIGENTE") {
//                                                            $("#noVigente").modal();
//                                                        }
                                                    } else {
                                                        ve.idclase = "<option value='1'>AUTOMOVIL</option>";
                                                        ve.idmarcarunt = '0';
                                                        ve.idmarca = 'SIN MARCA';
                                                        ve.idlinearunt = '0';
                                                        ve.idlinea = 'SIN LINEA';
                                                        ve.idservicio = "<option value='3'>PARTICULAR</option>";
                                                        ve.idcombustible = "<option value='2'>GASOLINA</option>";
                                                        ve.idcolorrunt = '0';
                                                        ve.idcolor = "SIN COLOR";
                                                        ve.ano_modelo = '';
                                                        ve.numero_serie = '';
                                                        ve.numero_motor = '';
                                                        ve.numero_vin = '';
                                                        ve.fecha_matricula = '';
                                                        ve.numsillas = "5";
                                                        ve.num_pasajeros = "4";
                                                        ve.blindaje = "<option value='0'>NO</option>";
                                                        ve.fecha_vencimiento_soat = '';
                                                    }
                                                }
                                            });
                                            return ve;
                                        };
                                        var setAtributoVehSelect = function (id, dato) {
                                            habilitarComponente(id, true);
                                            setItemSelect(id, dato);
                                            cargarDatos(id);
                                        };
                                        var setAtributoVeh = function (id, dato) {
                                            habilitarComponente(id, true);
                                            $("#" + id).val(dato);
                                        };
                                        var setAtributoVehPer = function (id, dato) {
                                            $("#" + id).val(dato);
                                        };
                                        var setAtributoVehLin = function (id, dato) {
                                            innerCompLimpiar(id);
                                            habilitarComponente(id, true);
                                            setItemSelect(id, dato);
                                            cargarDatosVar(id);
                                        };
                                        var limpiarFormulario = function () {
                                            innerCompLimpiar('idclase');
                                            innerCompLimpiar('idmarca');
                                            innerCompLimpiar('idlinea');
                                            innerCompLimpiar('idservicio');
                                            innerCompLimpiar('idcombustible');
                                            innerCompLimpiar('diseno');
                                            innerCompLimpiar('tipo_vehiculo');
                                            innerCompLimpiar('numejes');
                                            innerCompLimpiar('numero_llantas');
                                            innerCompLimpiar('tiempos');
                                            innerCompLimpiar('cilindros');
                                            innerCompLimpiar('ensenanza');
                                            innerCompLimpiar('taximetro');
                                            innerCompLimpiar('idpais');
                                            innerCompLimpiar('numero_exostos');
                                            innerCompLimpiar('scooter');
                                            innerCompLimpiar('blindaje');
                                            innerCompLimpiar('polarizado');
                                            innerCompLimpiar('chk_3');
                                        };
                                        var setItemSelect = function (id, valor) {
                                            if (valor !== null && valor !== undefined)
                                                innerComp(id, valor);
                                        };
                                        var cumple = function (id, campo) {
                                            var c = true;
                                            if ($("#" + id).val() === '') {
                                                document.getElementById("msj" + id).style.color = 'red';
                                                document.getElementById("msj" + id).style.display = 'block';
                                                document.getElementById("msj" + id).style.position = 'relative';
                                                $("#msj" + id).text('El campo ' + campo + ' es obligario');
                                                c = false;
                                            } else {
                                                $("#msj" + id).text('');
                                                c = true;
                                                document.getElementById("msj" + id).style.color = 'black';
                                                document.getElementById("msj" + id).style.display = 'none';
                                                document.getElementById("msj" + id).style.position = 'absolute';
                                            }
                                            return c;
                                        };
                                        var habilitarComponente = function (id, hab) {
                                            if (hab) {
                                                document.getElementById(id).disabled = false;
                                            } else {
                                                document.getElementById(id).disabled = true;
                                            }
                                        };
                                        var innerComp = function (id, datos) {
//                                            if (id === 'ensenanza') {
//                                                console.log("ensenanza: " + datos)
//                                            }
                                            if (id === 'idcolor')
                                                id = 's2example-1';
                                            document.getElementById(id).innerHTML += datos;
                                        }
                                        var innerCompLimpiar = function (id) {

//                                    document.getElementById(id).innerHTML = "";
                                        };
                                        var idmarca = 0;
                                        var idlinea = 0;
                                        var cargarDatos = function (id) {
                                            var funcion = '';
                                            switch (id) {
                                                case 'idclase':
                                                    funcion = 'getClases';
                                                    break;
                                                case 'idmarca':
                                                    funcion = 'getMarcas';
                                                    break;
                                                case 'idservicio':
                                                    funcion = 'getServicios';
                                                    break;
                                                case 'idcombustible':
                                                    funcion = 'getCombustibles';
                                                    break;
//                                    case 'idcolor':
//                                        funcion = 'getColores';
//                                        break;
                                                case 'diseno':
                                                    funcion = 'getCarrocerias';
                                                    break;
                                                case 'tipo_vehiculo':
                                                    funcion = 'getTipo_Vehiculos';
                                                    break;
                                                case 'numejes':
                                                    funcion = 'getNumejes';
                                                    break;
                                                case 'numero_llantas':
                                                    funcion = 'getNumllantas';
                                                    break;
                                                case 'tiempos':
                                                    funcion = 'getTiempos';
                                                    break;
                                                case 'cilindros':
                                                    funcion = 'getCilindros';
                                                    break;
                                                case 'cilindros':
                                                    funcion = 'getCilindros';
                                                    break;
                                                case 'ensenanza':
                                                    funcion = 'getSiNo';
                                                    break;
                                                case 'taximetro':
                                                    funcion = 'getSiNo';
                                                    break;
                                                case 'idpais':
                                                    funcion = 'getPaises';
                                                    break;
                                                case 'numero_exostos':
                                                    funcion = 'getNumExostos';
                                                    break;
                                                case 'scooter':
                                                    funcion = 'getSiNo';
                                                    break;
                                                case 'blindaje':
                                                    funcion = 'getSiNo';
                                                    break;
                                                case 'polarizado':
                                                    funcion = 'getSiNo';
                                                    break;
                                                case 'chk_3':
                                                    funcion = 'getSiNoNa';
                                                    break;
                                                default:
                                                    break;
                                            }
                                            if (id !== 'idcolor')
                                                $.ajax({
                                                    url: '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/' + funcion,
                                                    type: 'post',
                                                    success: function (datos) {
                                                        innerComp(id, datos);
                                                    }
                                                });
                                        };
                                        var cargarLineas = function (e) {
                                            innerCompLimpiar('idlinea');
                                            idmarca = e.value;
                                            habilitarComponente('idlinea', true);
                                            cargarDatosVar('idlinea');
                                        };
                                        var cargarDatosVar = function (id) {
                                            var funcion = '';
                                            var data;
                                            switch (id) {
                                                case 'idlinea':
                                                    funcion = 'getLineas';
                                                    data = {
                                                        codigo: idmarca
                                                    };
                                                    break;
                                                default:

                                                    break;
                                            }

                                            $.ajax({
                                                url: '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/' + funcion,
                                                type: 'post',
                                                data: data,
                                                success: function (datos) {
                                                    innerComp(id, datos);
                                                }
                                            });
                                        };
                                        var getVehiculo = function (numero_placa) {
                                            var data = {
                                                numero_placa: numero_placa
                                            };
                                            $.ajax({
                                                url: '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/buscarVehiculo',
                                                type: 'post',
                                                data: data,
                                                async: false,
                                                success: function (dato) {
                                                    if (dato !== '')
                                                        vehiculo = JSON.parse(dato);
                                                }
                                            });
                                        };


                                        var siPropietario = '0';

                                        var BuscarPropietario = function (e) {
                                            if ($('#fecha_vencimiento_soat').val() !== "") {
                                                siPropietario = e.title;
                                                guardarVehiculo();
                                                location.href = '../vehiculo/Cvehiculo/BuscarPropietario';
                                            } else {
                                                Swal.fire({
                                                    position: 'center',
                                                    icon: 'error',
                                                    title: 'Campos obligatorios.',
                                                    html: 'Antes de buscar el propietario, por favor llene todos los campos del formulario vehiculo.',
                                                    showConfirmButton: true,
//                                                    timer: 1500
                                                })
//                                                AlertTecmmas('error', 'Campo obligatorio', 'Fecha vencimiento del SOAT');
                                            }

                                        };
                                        $("#btnGuardar").click(function () {
                                            localStorage.removeItem('placa');
                                            '<?php $this->session->unset_userdata('numero_placa'); ?>'
                                        })
                                        var guardarNuevo = function () {
                                            if ($('#fecha_vencimiento_soat').val() !== "") {
                                                guardarVehiculo();
                                                location.reload();
                                                localStorage.removeItem('placa');
                                            } else {
                                                Swal.fire({
                                                    position: 'center',
                                                    icon: 'error',
                                                    title: 'Campo obligatorio.',
                                                    html: 'Fecha vencimiento del SOAT.',
                                                    showConfirmButton: true,
//                                                    timer: 1500
                                                })
//                                                AlertTecmmas('error', 'Campo obligatorio', 'Fecha vencimiento del SOAT');
                                            }

                                        };
                                        var guardarFinalizar = function () {
                                            if ($('#fecha_vencimiento_soat').val() !== "") {
                                                guardarVehiculo();
                                                localStorage.removeItem('placa');
                                                location.href = '../CPrincipal';
                                            } else {
                                                Swal.fire({
                                                    position: 'center',
                                                    icon: 'error',
                                                    title: 'Campo obligatorio.',
                                                    html: 'Fecha vencimiento del SOAT.',
                                                    showConfirmButton: true,
//                                                    timer: 1500
                                                })
//                                                AlertTecmmas('error', 'Campo obligatorio', 'Fecha vencimiento del SOAT');
                                            }

                                        };
                                        var guardarVehiculo = function () {
                                            if ($('#fecha_vencimiento_soat').val() !== "") {
                                                var placa = $('#numero_placa').val();
                                                localStorage.setItem('placa', placa);
                                                var veh = new Object();
                                                veh.numero_placa = $('#numero_placa').val();
                                                veh.idclase = $('#idclase').val();
                                                veh.idlinea = $('#idlinearunt').val();
                                                veh.idservicio = $('#idservicio').val();
                                                veh.idtipocombustible = $('#idcombustible').val();
                                                veh.idcolor = $('#idcolorrunt').val();
                                                veh.numero_serie = $('#numero_serie').val();
                                                veh.ano_modelo = $('#ano_modelo').val();
                                                veh.numero_motor = $('#numero_motor').val();
                                                veh.numero_vin = $('#numero_vin').val();
                                                veh.potencia_motor = $('#potencia_motor').val();
                                                veh.cilindraje = $('#cilindraje').val();
                                                veh.numero_tarjeta_propiedad = $('#numero_tarjeta_propiedad').val();
                                                veh.kilometraje = $('#kilometraje').val();
                                                veh.tipo_vehiculo = $('#tipo_vehiculo').val();
//                                                if (veh.tipo_vehiculo == "3") {
//                                                    veh.diseno = 0;
//                                                } else {
//                                                    veh.diseno = $('#idcarroceriarunt').val();
//                                                }
                                                veh.diseno = $('#idcarroceriarunt').val();
                                                veh.fecha_matricula = $('#fecha_matricula').val();
                                                veh.numejes = $('#numejes').val();
                                                veh.numero_llantas = $('#numero_llantas').val();
                                                veh.tiempos = $('#tiempos').val();
                                                veh.numsillas = $('#numsillas').val();
                                                veh.num_pasajeros = $('#num_pasajeros').val();
                                                veh.cilindros = $('#cilindros').val();
                                                veh.ensenanza = $('#ensenanza').val();
                                                veh.taximetro = $('#taximetro').val();
                                                veh.idpais = $('#idpais').val();
                                                veh.numero_exostos = $('#numero_exostos').val();
                                                veh.scooter = $('#scooter').val();
                                                veh.blindaje = $('#blindaje').val();
                                                veh.polarizado = $('#polarizado').val();
                                                veh.fecha_vencimiento_soat = $('#fecha_vencimiento_soat').val();
                                                veh.chk_3 = $('#chk_3').val();
                                                veh.fecha_final_certgas = $('#fecha_final_certgas').val();
                                                veh.idcliente = $('#idcliente').val();
                                                veh.idpropietarios = $('#idpropietario').val();
                                                veh.idsoat = 1;
                                                veh.diametro_escape = 0;
                                                veh.registrorunt = 1;

                                                var data = {
                                                    vehiculo: veh,
                                                    sipropietario: siPropietario
                                                };
                                                document.getElementById("msjguardar").style.color = 'green';
                                                document.getElementById("msjguardar").style.display = 'block';
                                                document.getElementById("msjguardar").style.position = 'relative';
                                                $("#msjguardar").text('Por favor espere, guardando informacion.');
                                                console.log(veh);
                                                $.ajax({
                                                    url: '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/guardarVehiculo',
                                                    type: 'post',
                                                    data: data,
                                                    success: function () {
                                                        document.getElementById("msjguardar").style.display = 'none';
                                                        document.getElementById("msjguardar").style.position = 'absolute';
                                                        $("#msjguardar").text('');

                                                        Swal.fire({
                                                            position: 'center',
                                                            icon: 'success',
                                                            title: 'Guardado exitosamente.',
//                                                            html: 'Fecha vencimiento del SOAT.',
                                                            showConfirmButton: true,
                                                            timer: 5000
                                                        })
//                                                        $("#msjguardar").text('Guardado exitosamente');
                                                    }, error: function (jqXHR, textStatus, errorThrown) {
                                                        console.log(jqXHR)
                                                    }

                                                });
                                            } else {
                                                Swal.fire({
                                                    position: 'center',
                                                    icon: 'error',
                                                    title: 'Campo obligatorio.',
                                                    html: 'Fecha vencimiento del SOAT.',
                                                    showConfirmButton: true,
//                                                    timer: 1500
                                                });
//                                                AlertTecmmas('error', 'Campo obligatorio', 'Fecha vencimiento del SOAT');
                                            }
                                        };
                                        var cambiarTV = function (e) {
                                            if (e.value === '3') {
                                                $("#labelScooter").text('Scooter');
                                            } else {
                                                $("#labelScooter").text('Convertidor Catalitico');
                                            }
                                        };
                                        var nuevo = function (e) {

                                            $.ajax({
                                                url: '<?php echo base_url(); ?>index.php/oficina/vehiculo/Cvehiculo/nuevo',
                                                type: 'post',
                                                async: false,
                                                success: function () {
                                                    //location.href = '../Cvehiculo';
                                                    location.reload();
                                                }
                                            });
                                        };


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



