<!DOCTYPE html>
<html class=" ">
    <head>

        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>DESCARGA DE CONFIGURACION</title>
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
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <link href="<?php echo base_url(); ?>assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" media="screen"/>
        <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->
    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class="login_page" style="background: white">

        <div class="col-xl-12">
            <section class="box ">
                <div class="content-body"  style="background: lightgrey">    
                    <div class="row" >
                        <div class="col-lg-12 col-md-12 col-12">
                            <section class="box ">
                                <header class="panel_header">
                                    <h2 class="title float-left">configuración del sistema</h2>
                                </header>
                                <div class="content-body" >
                                    <strong style="color: salmon">Advertencia:</strong> Esta acción puede alterar el funcionamiento normal del sistema, se recomienda que se ponga en contacto con el área técnica de TECMMAS SAS.<br><br>
                                    <form action="<?php echo base_url(); ?>index.php/oficina/login/Cconf/solicitar" method="post" style="width: 100%">
                                        <table style="width: 100%;text-align: center" >
                                            <tr>
                                                <td width="30%">
                                                    <label for="url">URL CLIENTE (aliascda.tecmmas.com)<br/>
                                                        <input type="text" name="url" id="dominio" class="form-control"  size="50" value="<?php
                                                        if (isset($url)) {
                                                            echo $url;
                                                        } else {
                                                            echo "";
                                                        }
                                                        ?>"/>
                                                        <strong style="color: #E31F24"><?php echo form_error('url'); ?></strong>
                                                    </label>            
                                                </td >
                                                <td width="20%">
                                                    <input name="button" id="registrar" class="btn btn-accent btn-block" style="width: 300px;background: #393185"  value="Registrar equipo" />
                                                </td>
                                                <td width="10%">
                                                    <label for="url">ACTUALIZACION DE TABLAS<br/>
                                                        <input type="button" class="btn btn-accent btn-block" id="btn_conf_tablas"  style="width: 300px;background: #393185"   value="Actualizar tablas"  size="50" />
                                                    </label>
                                                    <label id="msjatributos" style="color: brown;font-weight: bold"></label>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>

                                    <label id="mensaje" style="color: brown;font-weight: bold"></label>
                                    <?php
                                    if (isset($mensaje)) {
                                        echo $mensaje;
                                    }
                                    ?><br>
                                    <?php
                                    if (isset($conf)) {
                                        $encrptopenssl = New Opensslencryptdecrypt();
                                        $json = $encrptopenssl->decrypt($conf, true);
                                        $dat = json_decode($json, true);
                                        if ($dat) {
                                            ?>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Valor</th>
                                                        <th>Descripción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($dat as $d) {
                                                        ?>   
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                echo $d["valor"];
                                                                ?>                
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo $d["descripcion"];
                                                                ?>                
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>   
                                                </tbody>
                                            </table>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <br>
                                    <br>
                                    <form action="<?php echo base_url(); ?>index.php/" method="post">
                                        <input name="button" class="btn btn-accent btn-block" style="width: 100px;background: #393185" type="submit"  value="Atras" />
                                    </form>
                                    <br>
                                    <h5 class="title float-left">ACTUALIZACIÓN DE PARAMETROS</h5>
                                    <table class="table" style="width: 100%;text-align: center" >
                                        <tr>
                                            <td width="25%">
                                                <strong>PROCESO</strong>
                                            </td>
                                            <td width="15%">
                                                <strong>FECHA PROCESO</strong>
                                            </td>
                                            <td width="15%">
                                                <strong>INICIAR</strong>
                                            </td>
                                            <td width="45%">
                                                <strong>DESCRIPCION</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >
                                                ACTUALIZAR LINEAS VEHICULOS A 745 RUNT<br>
                                                <label id="msjActLineas" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td >
                                                <label id="ActLineas"></label>
                                            </td>
                                            <td >
                                                <input name="button" id="ActLineas" onclick="getActualizacionParametro(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td >
                                                Solo aplica para establecimientos que manejen descarga de datos directamente del runt o que tengan la prerevisión EasyTecmmas.
                                            </td>
                                        </tr>

                                    </table>
                                    <br>
                                    <h5 class="title float-left">DESCARGA DE ARCHIVOS DE CONFIGURACIÓN</h5>
                                    <table class="table" style="width: 100%;text-align: center" >
                                        <tr>
                                            <td width="40%">
                                                <strong>PARAMETRO</strong>
                                            </td>
                                            <td width="25%">
                                                <strong>FECHA ACTUALIZACION</strong>
                                            </td>
                                            <td width="20%">
                                                <strong>ACTUALIZAR</strong>
                                            </td>
                                            <td width="20%">
                                                <strong>VER</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN ADMINISTRATIVA<br>
                                                <label id="msjoficina" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="oficina"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="oficina" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="oficina" onclick="verConfiguracion(this.title)" class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN LUXOMETROS<br>
                                                <label id="msjluxometro" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="luxometro"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="luxometro" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="luxometro" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN OPACIMETROS<br>
                                                <label id="msjopacimetro" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="opacimetro"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="opacimetro" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="opacimetro" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN ANALIZADORES<br>
                                                <label id="msjanalizador" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="analizador"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="analizador" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="analizador" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN SONOMETRÍA<br>
                                                <label id="msjsonometro" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="sonometro"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="sonometro" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="sonometro" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN CAMARAS<br>
                                                <label id="msjcamara" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="camara"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="camara" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="camara" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN TAXIMETROS<br>
                                                <label id="msjtaximetro" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="taximetro"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="taximetro" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="taximetro" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN FRENOMETROS<br>
                                                <label id="msjfrenometro" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="frenometro"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="frenometro" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="frenometro" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN BASCULAS<br>
                                                <label id="msjbascula" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="bascula"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="bascula" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="bascula" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN VISUAL<br>
                                                <label id="msjvisual" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="visual"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="visual" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="visual" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN BANCO SUSPENSIÓN<br>
                                                <label id="msjbanco_suspension" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="banco_suspension"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="banco_suspension" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="banco_suspension" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN ALINEADORES<br>
                                                <label id="msjalineador" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="alineador"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="alineador" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="alineador" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN CAPTADOR<br>
                                                <label id="msjcaptador" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="captador"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="captador" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="captador" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN TERMOHIGROMETROS<br>
                                                <label id="msjtermohigrometro" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="termohigrometro"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="termohigrometro" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="termohigrometro" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN PROFUNDIMETROS<br>
                                                <label id="msjprofundimetro" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="profundimetro"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="profundimetro" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="profundimetro" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN PIE DE REY<br>
                                                <label id="msjpie_de_rey" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="pie_de_rey"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="pie_de_rey" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="pie_de_rey" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN DETECTOR DE HOLGURAS<br>
                                                <label id="msjdetector_holguras" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="detector_holguras"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="detector_holguras" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="detector_holguras" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN ELEVADOR DE MOTOS<br>
                                                <label id="msjelevador" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="elevador"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="elevador" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="elevador" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN SENSOR VIBRACION<br>
                                                <label id="msjsensor_vibracion" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="sensor_vibracion"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="sensor_vibracion" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="sensor_vibracion" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN SENSOR BATERIA<br>
                                                <label id="msjsensor_bateria" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="sensor_bateria"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="sensor_bateria" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="sensor_bateria" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN SENSOR INDUCCIÓN<br>
                                                <label id="msjsensor_induccion" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="sensor_induccion"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="sensor_induccion" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="sensor_induccion" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                CONFIGURACIÓN SONDA TEMPERATURA<br>
                                                <label id="msjsonda_temperatura" style="color: brown;font-weight: bold"></label>
                                            </td>
                                            <td>
                                                <label id="sonda_temperatura"></label>
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" id="sonda_temperatura" onclick="getActualizacionArchivo(this)" class="btn btn-accent btn-block" style="background: #393185"  value="Actualizar" />
                                            </td>
                                            <td style="text-align: center">
                                                <input name="button" title="sonda_temperatura" onclick="verConfiguracion(this.title)"  class="btn btn-accent btn-block" style="background: #393185"  value="Ver" />
                                            </td>
                                        </tr>
                                    </table>
                                    <h4 id="titulo_conf"></h4>
                                    <div class="col-xs-12">
                                        <table id="example-1" class="table table-striped dt-responsive display">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Linea</th>
                                                    <th>Nombre</th>
                                                    <th>Marca</th>
                                                    <th>Serie</th>
                                                    <th>Referencia</th>
                                                    <th>Nombre</th>
                                                    <th>Valor</th>
                                                    <th>Descripción</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Nombre</th>
                                                    <th>Marca</th>
                                                    <th>Serie</th>
                                                    <th>Referencia</th>
                                                    <th>Nombre</th>
                                                    <th>Valor</th>
                                                    <th>Descripción</th>
                                                </tr>
                                            </tfoot>
                                            <tbody id="configuracion"></tbody>
                                        </table>
                                    </div>
                                    <form action="<?php echo base_url(); ?>index.php/" method="post">
                                        <input name="button" class="btn btn-accent btn-block" style="width: 100px;background: #393185" type="submit"  value="Atras" />
                                    </form>
                                </div>

                                <img src="<?php echo base_url(); ?>assets/images/logo.png" />
                                <div class="modal" id="Modal-token" s tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog animated bounceInDown">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="titulo_">Validar Token</h4>
                                            </div>
                                            <div class="modal-body" >
                                                <label style="color: black; justify-content: center">Para poder ejecutar este comando, por favor comuniquese con el area de desarrollo para que le entregue un token y pueda continuar con el proceso</label>
                                                <br>
                                                <br>
                                                <div style="text-align: center">
                                                    <input type="text" placeholder="Token" class="input" id="token" autocomplete="off">
                                                </div>
                                                <div id="valid-token" style="color: red"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button data-dismiss="modal" class="btn btn-default" type="button">CANCELAR</button>
                                                <button id="btnAsignar" class="btn btn-success" type="button" onclick="Validar()">Validar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal" id="Modal-token-data" s tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog animated bounceInDown">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="titulo_">Ingrese los siguientes datos</h4>
                                            </div>
                                            <div class="modal-body" >
                                                <div style="text-align: center">
                                                    <input type="text" placeholder="Nombre usuario" class="input" autocomplete="off" id="usuario" style=" width: 90%">
                                                    <br>
                                                    <br>
                                                    <input type="text" placeholder="Nombre cda" class="input" id="cda" autocomplete="off" style=" width: 90%">
                                                    <br>
                                                    <br>
                                                    <textarea type="text" placeholder="Descripcion" class="input" id="descripcion" autocomplete="off" style=" width: 90%; height: 160px"></textarea>
                                                </div>
                                                <div id="valid-data" style="color: red"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button data-dismiss="modal" class="btn btn-default" type="button">CANCELAR</button>
                                                <button id="btnAsignar" class="btn btn-success" type="button" onclick="enviar()">Enviar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </section>
                            <?php echo $this->config->item('derechos'); ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>


        <!-- MAIN CONTENT AREA ENDS -->
        <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->


        <!-- CORE JS FRAMEWORK - START --> 
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/js/popper.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/js/jquery.easing.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
        <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
        <script src="<?php echo base_url(); ?>assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>  
        <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"><\/script>');</script>
        <!-- CORE JS FRAMEWORK - END --> 


        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <script src="<?php echo base_url(); ?>assets/plugins/icheck/icheck.min.js" type="text/javascript"></script>
        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <script type="text/javascript">
                                                    var app = {
                                                        registrar: function () {
                                                            validar1();
                                                        },
                                                        load: function () {
                                                            if (localStorage.getItem('urlserver') !== null && localStorage.getItem('urlserver') !== '') {
                                                                var url = localStorage.getItem('urlserver');
                                                                url = url.split(':');
                                                                $("#ip").val(url[1].toString().substr(2));
                                                                $("#puerto").val(url[2]);
                                                            }
                                                            if (localStorage.getItem('dominio') !== null && localStorage.getItem('urlserver') !== '')
                                                                $("#dominio").val(localStorage.getItem('dominio'));
                                                            if (localStorage.getItem('serial') !== null && localStorage.getItem('serial') !== '') {
                                                                var serial = localStorage.getItem('serial');
                                                                var serial1 = serial.substring(0, 5);
                                                                var serial2 = serial.substring(5, 10);
                                                                var serial3 = serial.substring(10, 15);
                                                                var serial4 = serial.substring(15, 20);
                                                                $("#serial").text(serial1 + '-' + serial2 + '-' + serial3 + '-' + serial4);
                                                            } else {
                                                                $("#serial").text("NO REGISTRA SERIAL");
                                                            }
                                                        },
                                                        init: function () {
                                                            this.load();
                                                            getDominio();
                                                            setFechaActualizacion("system-oficina.json", 'oficina');
                                                            setFechaActualizacion("system-luxometro.dat", 'luxometro');
                                                            setFechaActualizacion("system-opacimetro.dat", 'opacimetro');
                                                            setFechaActualizacion("system-analizador.dat", 'analizador');
                                                            setFechaActualizacion("system-sonometro.dat", 'sonometro');
                                                            setFechaActualizacion("system-camara.dat", 'camara');
                                                            setFechaActualizacion("system-taximetro.dat", 'taximetro');
                                                            setFechaActualizacion("system-frenometro.dat", 'frenometro');
                                                            setFechaActualizacion("system-bascula.dat", 'bascula');
                                                            setFechaActualizacion("system-visual.dat", 'visual');
                                                            setFechaActualizacion("system-banco_suspension.dat", 'banco_suspension');
                                                            setFechaActualizacion("system-alineador.dat", 'alineador');
                                                            setFechaActualizacion("system-captador.dat", 'captador');
                                                            setFechaActualizacion("system-termohigrometro.dat", 'termohigrometro');
                                                            setFechaActualizacion("system-profundimetro.dat", 'profundimetro');
                                                            setFechaActualizacion("system-pie_de_rey.dat", 'pie_de_rey');
                                                            setFechaActualizacion("system-detector_holguras.dat", 'detector_holguras');
                                                            setFechaActualizacion("system-elevador.dat", 'elevador');
                                                            setFechaActualizacion("system-sensor_vibracion.dat", 'sensor_vibracion');
                                                            setFechaActualizacion("system-sensor_bateria.dat", 'sensor_bateria');
                                                            setFechaActualizacion("system-sensor_induccion.dat", 'sensor_induccion');
                                                            setFechaActualizacion("system-sonda_temperatura.dat", 'sonda_temperatura');
                                                            document.getElementById('registrar').addEventListener('click', this.registrar, false);
                                                        }
                                                    };

                                                    $(document).ready(function () {
                                                        app.init();
//                console.log("Hola");
                                                    });

                                                    function validar1() {
                                                        $.ajax({
                                                            url: '<?php echo base_url(); ?>index.php/Cconfiguracion/getCda',
                                                            type: 'post',
                                                            success: function (rta) {
                                                                validar2(rta);
                                                            },
                                                            timeout: 5000,
                                                            error: function (rta, status, err) {
                                                                hideAlert();
                                                                if (status === "timeout") {
                                                                    $("#mensaje").text('Su petición demoro mas de lo permitido (urlserver). ' + err);
                                                                } else {
                                                                    $("#mensaje").text('Verifique la direccion del servidor (urlserver). ' + err);
                                                                }

                                                            }
                                                        });
                                                    }

                                                    function validar2(cda) {
                                                        $.ajax({
                                                            url: "http://" + $('#dominio').val() + "/cda/index.php/Cservicio/getCda",
                                                            type: 'post',
                                                            success: function (rta) {
                                                                if (cda === rta) {
                                                                    validar3();
                                                                } else {
                                                                    $("#mensaje").text('Error de dominio', 'Por favor verifique si el dominio es correcto o si pertenece al presente CDA.');
                                                                }
                                                            },
                                                            timeout: 5000,
                                                            error: function (rta, status, err) {
                                                                if (status === "timeout") {
                                                                    $("#mensaje").text('Su petición demoro mas de lo permitido (dominio). ' + err);
                                                                } else {
                                                                    $("#mensaje").text('Verifique la direccion del servidor (dominio). ' + err);
                                                                }
                                                            }
                                                        });
                                                    }

                                                    function validar3() {
                                                        $.ajax({
                                                            url: '<?php echo base_url(); ?>index.php/Cconfiguracion/getMac',
                                                            type: 'post',
                                                            success: function (mac) {
                                                                
                                                                if (mac !== '') {
                                                                    alert(mac);
                                                                    var data = {
                                                                        serial: mac,
                                                                        descripcion: 'Dispositivo oficina'
                                                                    };
                                                                    $.ajax({
                                                                        url: "http://" + $('#dominio').val() + "/cda/index.php/Cservicio/guardarDispositivo",
                                                                        type: 'post',
                                                                        data: data,
                                                                        success: function (rta) {
                                                                            if (rta === 'SI') {
                                                                                $("#mensaje").text('El dispositivo ya esta registrado, comuníquese con TECMMAS SAS para validar su activación.');
                                                                            } else {
                                                                                $("#mensaje").text('El dispositivo se ha resgistrado, comuníquese con TECMMAS SAS para validar su activación.');
                                                                            }
                                                                            saveDominio();
                                                                        },
                                                                        timeout: 5000,
                                                                        error: function (rta, status, err) {
                                                                            hideAlert();
                                                                            if (status === "timeout") {
                                                                                $("#mensaje").text('Su peticion demoro mas de lo permitido (dominio). ' + err);
                                                                            } else {
                                                                                $("#mensaje").text('Verifique la direccion del servidor (dominio). ' + err);
                                                                            }
                                                                        }
                                                                    });
                                                                } else {
                                                                    validar4();
                                                                }

                                                            },
                                                            timeout: 5000,
                                                            error: function (rta, status, err) {
                                                                hideAlert();
                                                                if (status === "timeout") {
                                                                    showAlert('Error de conexion', 'Su peticion demoro mas de lo permitido (dominio). ' + err, 'error', false);
                                                                } else {
                                                                    showAlert('Error de conexion', 'Verifique la direccion del servidor (dominio). ' + err, 'error', false);
                                                                }
                                                            }
                                                        });
                                                    }

                                                    function validar4() {
                                                        $.ajax({
                                                            url: '<?php echo base_url(); ?>index.php/Cconfiguracion/getMacServer',
                                                            type: 'post',
                                                            success: function (mac) {
                                                                if (mac !== '') {
                                                                    var data = {
                                                                        serial: mac,
                                                                        descripcion: 'Servidor'
                                                                    };
                                                                    $.ajax({
                                                                        url: "http://" + $('#dominio').val() + "/cda/index.php/Cservicio/guardarDispositivo",
                                                                        type: 'post',
                                                                        data: data,
                                                                        success: function (rta) {
                                                                            if (rta === 'SI') {
                                                                                $("#mensaje").text('El dispositivo ya esta registrado, comuníquese con TECMMAS SAS para validar su activación.');
                                                                            } else {
                                                                                $("#mensaje").text('El dispositivo se ha resgistrado, comuníquese con TECMMAS SAS para validar su activación.');
                                                                            }
                                                                            saveDominio();
                                                                        },
                                                                        timeout: 5000,
                                                                        error: function (rta, status, err) {
                                                                            hideAlert();
                                                                            if (status === "timeout") {
                                                                                $("#mensaje").text('Su peticion demoro mas de lo permitido (dominio). ' + err);
                                                                            } else {
                                                                                $("#mensaje").text('Verifique la direccion del servidor (dominio). ' + err);
                                                                            }
                                                                        }
                                                                    });
                                                                } else {
                                                                    $("#mensaje").text('El sistema no reconoce la MAC de este equipo');
                                                                }
                                                            },
                                                            timeout: 5000,
                                                            error: function (rta, status, err) {
                                                                hideAlert();
                                                                if (status === "timeout") {
                                                                    showAlert('Error de conexion', 'Su peticion demoro mas de lo permitido (dominio). ' + err, 'error', false);
                                                                } else {
                                                                    showAlert('Error de conexion', 'Verifique la direccion del servidor (dominio). ' + err, 'error', false);
                                                                }
                                                            }
                                                        });

                                                    }

                                                    var saveDominio = function () {
                                                        var data = {
                                                            dominio: $('#dominio').val()
                                                        };
                                                        $.ajax({
                                                            url: '<?php echo base_url(); ?>index.php/Cconfiguracion/saveDominio',
                                                            type: 'post',
                                                            data: data
                                                        });
                                                    };

                                                    var getDominio = function () {
                                                        $.ajax({
                                                            url: '<?php echo base_url(); ?>index.php/Cconfiguracion/getDominio',
                                                            type: 'post',
                                                            success: function (dominio) {
                                                                if (dominio !== '') {
                                                                    $("#dominio").val(dominio);
                                                                }
                                                            }
                                                        });
                                                    };

                                                    var setFechaActualizacion = function (archivo, campo) {
                                                        var data = {
                                                            archivo: archivo
                                                        };
                                                        $.ajax({
                                                            url: '<?php echo base_url(); ?>index.php/Cconfiguracion/getFechaArchivo',
                                                            type: 'post',
                                                            data: data,
                                                            success: function (fecha) {
                                                                $("#" + campo).text(fecha);
                                                            }
                                                        });
                                                    };

                                                    var verConfiguracion = function (tipo) {
                                                        var data = {
                                                            tipo: tipo
                                                        };
                                                        $.ajax({
                                                            url: '<?php echo base_url(); ?>index.php/Cconfiguracion/verConfiguracion',
                                                            type: 'post',
                                                            data: data,
                                                            success: function (conf) {
                                                                document.getElementById("configuracion").innerHTML = conf;
                                                                document.getElementById("titulo_conf").innerHTML = "CONFIGURACIÓN DE " + tipo.toString().toUpperCase();
                                                            }
                                                        });
                                                    };

                                                    var getActualizacionArchivo = function (e) {
                                                        document.getElementById("msj" + e.id).style.color = 'black';
                                                        e.disabled = true;
                                                        $("#msj" + e.id).text('Actualizando configuración ' + e.id + ' por favor espere..');

                                                        $.ajax({
                                                            url: "https://" + $("#dominio").val() + "/cda/index.php/Cservicio/getLineas",
                                                            success: function (datos) {
                                                                var data = {
                                                                    tipo: e.id,
                                                                    url: $("#dominio").val(),
                                                                    datos: datos
                                                                };
                                                                $.ajax({
                                                                    url: '<?php echo base_url(); ?>index.php/Cconfiguracion/getActualizacionArchivoNew',
                                                                    type: 'post',
                                                                    data: data,
                                                                    success: function (data, textStatus, jqXHR) {
                                                                        if (e.id === 'oficina') {
                                                                            setFechaActualizacion("system-oficina.json", 'oficina');
                                                                        } else {
                                                                            setFechaActualizacion("system-" + e.id + ".dat", e.id);
                                                                        }
                                                                        document.getElementById("msj" + e.id).style.color = 'green';
                                                                        $("#msj" + e.id).text('Actualización de configuración para ' + e.id + ' exitosa.');
                                                                        e.disabled = false;
                                                                    }
                                                                });

                                                            },
                                                            timeout: 60000,
                                                            error: function (rta, status, err) {
                                                                console.log(rta)
                                                                document.getElementById("msj" + e.id).style.color = 'red';
                                                                if (status === "timeout") {
                                                                    $("#msj" + e.id).text('Su petición demoro mas de lo permitido. Este problema puede estar ligado a que el dispositivo no tiene conexión con el servidor local o su conexión a internet no responde -> ' + err);
                                                                } else {
                                                                    $("#msj" + e.id).text('Verifique la conexión con su servidor local. ' + err);
                                                                }
                                                                e.disabled = false;
                                                            }
                                                        });
                                                    };

                                                    var getActualizacionParametro = function (e) {
                                                        document.getElementById("msj" + e.id).style.color = 'black';
                                                        e.disabled = true;
                                                        var data = {
                                                            tipo: e.id
                                                        };
                                                        $.ajax({
                                                            url: '<?php echo base_url(); ?>index.php/Cconfiguracion/getActualizacionParametro',
                                                            type: 'post',
                                                            data: data,
                                                            success: function () {
                                                                if (e.id === 'oficina') {
                                                                    setFechaActualizacion("system-oficina.json", 'oficina');
                                                                } else {
                                                                    setFechaActualizacion("system-" + e.id + ".dat", e.id);
                                                                }
                                                                document.getElementById("msj" + e.id).style.color = 'green';
                                                                $("#msj" + e.id).text('Actualización de configuración para ' + e.id + ' exitosa.');
                                                                e.disabled = false;
                                                            },
                                                            error: function (rta, status, err) {
                                                                document.getElementById("msj" + e.id).style.color = 'red';
                                                                if (status === "timeout") {
                                                                    $("#msj" + e.id).text('Su petición demoro mas de lo permitido. Este problema puede estar ligado a que el dispositivo no tiene conexión con el servidor local o su conexión a internet no responde -> ' + err);
                                                                } else {
                                                                    $("#msj" + e.id).text('Verifique la conexión con su servidor local. ' + err);
                                                                }
                                                                e.disabled = false;
                                                            }
                                                        });
                                                    };

                                                    $('#btn_conf_tablas').click(function () {
                                                        $('#Modal-token').show();
                                                    });
                                                    var tokenval = "";

                                                    function Validar() {
                                                        var token = $("#token").val();
                                                        $("#valid-token").html('');
                                                        $.ajax({
                                                            url: 'https://atalayasoft.tecmmas.com/atalaya/index.php/Ctriguer/validToken',
                                                            type: 'post',
                                                            mimeType: 'json',
                                                            data: {token: token},
                                                            success: function (data, textStatus, jqXHR) {
                                                                if (data == 1) {
                                                                    tokenval = token;
                                                                    $('#Modal-token').hide();
                                                                    $("#Modal-token-data").show();
                                                                } else {
                                                                    $("#valid-token").html('El token no es correcto');
                                                                }
                                                            },
                                                            error: function (jqXHR, textStatus, errorThrown) {
                                                                alert('Error: ' + jqXHR);
                                                            }
                                                        });
                                                    }

                                                    function enviar() {
                                                        $("#valid-data").html('');
                                                        var usuario = $("#usuario").val();
                                                        var cda = $("#cda").val();
                                                        var descripcion = $("#descripcion").val();
                                                        if ((usuario == "" || usuario == null) || (cda == "" || cda == null) || (descripcion == "" || descripcion == null)) {
                                                            $("#valid-data").html('Todos los campos son obligatorios.');
                                                        } else {
                                                            $.ajax({
                                                                url: 'https://atalayasoft.tecmmas.com/atalaya/index.php/Ctriguer/UpdateToken',
                                                                type: 'post',
                                                                mimeType: 'json',
                                                                data: {token: tokenval,
                                                                    usuario: usuario,
                                                                    cda: cda,
                                                                    descripcion: descripcion},
                                                                success: function (data, textStatus, jqXHR) {
//                                                                    alert(data);
                                                                    configurarTablas();
                                                                    $("#Modal-token-data").hide();
                                                                },
                                                                error: function (jqXHR, textStatus, errorThrown) {
                                                                    alert('Error: ' + jqXHR);
                                                                }
                                                            });
                                                        }
                                                    }

                                                    var configurarTablas = function () {
                                                        var e = document.getElementById("btn_conf_tablas");
//                            e.disabled = true;
                                                        $("#btn_conf_tablas").attr("disabled", true);
                                                        $.ajax({
                                                            url: '<?php echo base_url(); ?>index.php/Cconfiguracion/configurarTablas',
                                                            success: function () {
                                                                crearTablas();
                                                                document.getElementById("msj" + e.id).style.color = 'green';
                                                                $("#msj" + e.id).text('Actualización de configuración para ' + e.id + ' exitosa.');
                                                                e.disabled = false;
                                                            },
                                                            error: function () {
                                                                crearTablas();
                                                                document.getElementById("msj" + e.id).style.color = 'red';
                                                                $("#msj" + e.id).text('Esta actualización ya ha sido aplicada.');
//                                                                e.disabled = false;
                                                            }
                                                        });
                                                    };

                                                    var crearTablas = function () {
                                                        $.ajax({
                                                            url: '<?php echo base_url(); ?>index.php/Cconfiguracion/getDominio',
                                                            type: 'post',
                                                            success: function (dominio) {
                                                                $.ajax({
                                                                    url: "http://" + dominio + "/cda/index.php/Cservicio/createtable",
                                                                    async: false,
                                                                    success: function (r) {
                                                                    }
                                                                });
                                                            }
                                                        });
                                                    };
        </script>

    </body>
</html>



