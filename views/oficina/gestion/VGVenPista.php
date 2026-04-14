<!DOCTYPE html>
<html class=" ">

<head>

    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>VEHICULO EN PISTA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" type="image/x-icon" /> <!-- Favicon -->
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-57-precomposed.png"> <!-- For iPhone -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-114-precomposed.png"> <!-- For iPhone 4 Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-72-precomposed.png"> <!-- For iPad -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-144-precomposed.png"> <!-- For iPad Retina display -->

    <!-- CORE CSS FRAMEWORK - START -->
    <link href="<?php echo base_url(); ?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/> -->
    <link href="<?php echo base_url(); ?>assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS FRAMEWORK - END -->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START -->


    <link href="<?php echo base_url(); ?>assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" media="screen" />

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END -->


    <!-- CORE CSS TEMPLATE - START -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS TEMPLATE - END -->

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="login_page" style="background: white">

    <div class="col-xl-12">
        <section class="box ">
            <div class="content-body" style="background: lightyellow">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <section class="box ">
                            <form action="<?php echo base_url(); ?>index.php/oficina/CGestion" method="post">
                                <input name="button" class="btn btn-accent btn-block" style="width: 100px;background: #393185" type="submit" value="Atras" />
                            </form>
                            <header class="panel_header">
                                <h2 class="title float-left">Vehiculo en pista</h2>
                            </header>
                            <div class="content-body">
                                <input id="idhojapruebas" value="<?php echo $dato; ?>" type="hidden" />
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Id control</th>
                                            <th>Placa</th>
                                            <th>Ocasión</th>
                                            <th>Pruebas pendientes</th>
                                            <th>FUR</th>
                                            <th>Tamaño Hoja</th>
                                            <th>Medio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <?php
                                                echo $idhojapruebas;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $placaR[0]->placa;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $ocacion;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $pruebas = "";
                                                foreach ($pendientes as $pp) {
                                                    $pruebas = $pruebas . $pp->nombre . " <strong>|</strong> ";
                                                }
                                                echo $pruebas;
                                                ?>
                                            </td>
                                            <form action="<?php echo base_url(); ?>index.php/oficina/fur/CFUR" method="post" style="width: 100px;text-align: center">
                                                <td>
                                                    <button name="dato" class="btn btn-accent btn-block" value="<?php echo $dato; ?>" type="submit" formtarget="_blank" style="border-radius: 40px 40px 40px 40px;font-size: 14px;background-color: #393185">Ver</button>
                                                </td>
                                                <td>
                                                    <select name="tamano" class="form-control input-lg m-bot15">
                                                        <option value="oficio" selected>Oficio</option>
                                                        <option value="carta">Carta</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="medio" id="medioSelect" class="form-control input-lg m-bot15" onchange="guardarMedio()">
                                                        <option value="0" selected>Impreso</option>
                                                        <option value="1">Digital</option>
                                                    </select>
                                                </td>
                                            </form>
                                        </tr>

                                    </tbody>
                                </table>
                                <div style="text-align: center">
                                    <input class="btn btn-info btn-block" type="button" id="btnPresionInflado" style="border-radius: 40px 40px 40px 40px;font-size: 20px;width: 300px" value="⏲ Presión de inflado" data-toggle='modal' data-target='#presionLlantas' /><br>
                                </div>
                                <section class="box ">
                                    <?php $this->load->view('oficina/gestion/Nav-conf-prueba'); ?>
                                    <div id="RasignacionI">
                                        <header class="panel_header">
                                            <h2 class="title float-left">Reasignacion individual</h2>
                                        </header>
                                        <div class="content-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Estado</th>
                                                                <th>Fecha inicial</th>
                                                                <th>Fecha final</th>
                                                                <th>Tipo ins</th>
                                                                <th>Opciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php foreach ($placaR as $value): ?>
                                                                    <td><?= $value->idhojapruebas ?></td>
                                                                    <td><?= $value->estado ?></td>
                                                                    <td><?= $value->fechainicial ?></td>
                                                                    <td><?= $value->fechafinal ?></td>
                                                                    <td><?= $value->tipoins ?></td>
                                                                    <td>
                                                                        <input type="hidden" name="idhojapruebas" id="idhojapruebasR" value="<?= $value->idhojapruebas ?>">
                                                                        <input type="hidden" name="fechainicial" id="fechainicial" value="<?= $value->pfechainicial ?>">
                                                                        <input type="hidden" name="reinspeccion" id="reinspeccion" value="<?= $value->reinspeccion ?>">
                                                                        <input type="submit" name="consultar" id="btn-buscar-pruebas" class="btn btn-primary" style="background-color: #393185;border-radius: 40px 40px 40px 40px" value="Buscar">
                                                                    </td>
                                                                <?php endforeach; ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content-body" id="div-pruebas" style="display: none">
                                            <header class="panel_header">
                                                <div style="float: left; font-size: 1.57em">Pruebas</div>
                                                <div id="val-razon" style="color: red; text-align: center;"></div>
                                            </header>
                                            <div class="row">
                                                <div class="col-12">
                                                    <!--                                                    <div class="form-group row" >
                                                                                                                <label  class="col-sm-4 col-form-label" style="font-weight: bold; color: black;text-align: center">Razón de la reasignación:</label>
                                                                                                                <input type="text" class="mx-sm-4" id="razon-reasignacion">
                                                                                                                
                                                                                                            </div>-->

                                                    <table class="table table-bordered" id="table-rea-prueba">
                                                        <thead>
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Fecha inicial</th>
                                                                <th>Estado</th>
                                                                <th>Fecha final</th>
                                                                <th>Tipo prueba</th>
                                                                <th>Opciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="pinEstado" style="display: none; position: absolute">
                                        <header class="panel_header">
                                            <h2 class="title float-left">Cambiar pin y estado</h2>
                                        </header>
                                        <div class="content-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <!--<form action="<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/updateEstadoPin" method="post">-->
                                                    <div id="div-rest-estado"></div>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Placa</th>
                                                                <th>Estado</th>
                                                                <th>Fecha inicial</th>
                                                                <th>Tipo ins</th>
                                                                <th>Pin</th>
                                                                <th>Opciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php foreach ($placaR as $value): ?>
                                                                    <td><?= $value->placa ?></td>
                                                                    <td><label style="padding-left: 0px" id="label-estado">
                                                                            <input type="checkbox" style="transform: scale(1.0)" class="skin-square-blue rta" id="estado"><label style="padding-left: 15px"><?= $value->estado ?></label></label>
                                                                        <div style="display: none" id="select-estado">
                                                                            <input type="checkbox" style="transform: scale(1.0)" class="skin-square-blue rta2" id="estado" checked="">
                                                                            <select name="estado" id="estadoP">
                                                                                <option></option>
                                                                                <option value="1">Asignado</option>
                                                                                <option value="2">Aprobado</option>
                                                                                <option value="3">Rechazado</option>
                                                                                <option value="4">Certificado</option>
                                                                                <option value="5">Abortado</option>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    <td><?= $value->fechainicial ?></td>
                                                                    <td><?= $value->tipoins ?></td>
                                                                    <td><input type="number" id="pin" name="pin" value="<?= $value->pin ?>"></td>
                                                                    <td>
                                                                        <input type="hidden" name="idhojapruebasR" id="idhojapruebasR" value="<?= $value->idhojapruebas ?>">
                                                                        <input type="submit" name="consultar" id="btn-pin-estado" class="btn btn-primary" style="background-color: #393185;border-radius: 40px 40px 40px 40px" value="Guardar">
                                                                    </td>
                                                                <?php endforeach; ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!--</form>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="reconfPrueba" style="display: none; position: absolute">
                                        <header class="panel_header">
                                            <h2 class="title float-left">Reconfigurar vehiculos y pruebas</h2>
                                        </header>
                                        <div class="content-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="div-reconf-prueba"></div>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Placa</th>
                                                                <th>Estado</th>
                                                                <th>Tipo vehiculo</th>
                                                                <th>Fecha inicial</th>
                                                                <th>Tipo ins</th>
                                                                <th>Reconfigurar</th>
                                                                <th>Opciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php foreach ($placaR as $value): ?>
                                                                    <td><?= $value->placa ?></td>
                                                                    <td><?= $value->estado ?></td>
                                                                    <?php if ($value->tipovehiculo == 1): ?>
                                                                        <td><?php echo 'Liviano'; ?></td>
                                                                    <?php elseif ($value->tipovehiculo == 2): ?>
                                                                        <td><?php echo 'Pesado'; ?></td>
                                                                    <?php else : ?>
                                                                        <td><?php echo 'Moto'; ?></td>
                                                                    <?php endif; ?>
                                                                    <td><?= $value->fechainicial ?></td>
                                                                    <td><?= $value->tipoins ?></td>
                                                                    <td>
                                                                        <select name="selectrecofprueba" id="selectrecofprueba">
                                                                            <option value="1">Asignar taxímetro</option>
                                                                            <option value="2">Quitar taxímetro</option>
                                                                            <option value="3">Liviano a pesado</option>
                                                                            <option value="4">Pesado a liviano</option>
                                                                            <option value="5">Moto a liviano</option>
                                                                            <option value="6">Liviano a moto</option>
                                                                            <option value="7">Pesado a moto</option>
                                                                            <option value="8">Moto a pesado</option>
                                                                            <option value="9">Particular a público</option>
                                                                            <option value="10">Público a particular</option>
                                                                            <option value="11">Gasolina a diesel</option>
                                                                            <option value="12">Diesel a gasolina</option>
                                                                            <option value="13">Asignar sonometro</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" id="hojapruebasR" value="<?= $value->idhojapruebas ?>">
                                                                        <input type="hidden" name="pfechainicial" id="pfechainicialR" value="<?= $value->pfechainicial ?>">
                                                                        <input type="hidden" name="tipovehiculo" id="tipovehiculoR" value="<?= $value->tipovehiculo ?>">
                                                                        <input type="hidden" name="servicio" id="servicioR" value="<?= $value->servicio ?>">
                                                                        <input type="hidden" name="combustible" id="combustibleR" value="<?= $value->combustible ?>">
                                                                        <input type="hidden" name="placa" id="placaR" value="<?= $value->placa ?>">
                                                                        <input type="submit" name="consultar" class="btn btn-primary" id="btn-reconf-prueba" style="background-color: #393185;border-radius: 40px 40px 40px 40px" value="Guardar">
                                                                    </td>
                                                                <?php endforeach; ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="cancelPrueba" style="display: none; position: absolute">
                                        <header class="panel_header">
                                            <h2 class="title float-left">Cancelación de pruebas</h2>
                                        </header>
                                        <div class="content-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="div-cancel-prueba"></div>
                                                    <table class="table table-bordered" id="table-cancel">
                                                        <thead>
                                                            <tr>
                                                                <th>Placa</th>
                                                                <th>Estado</th>
                                                                <th>Fecha inicial</th>
                                                                <th>Tipo ins</th>
                                                                <th>Opciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php foreach ($placaR as $value): ?>
                                                                    <td><?= $value->placa ?></td>
                                                                    <td><?= $value->estado ?></td>
                                                                    <td><?= $value->fechainicial ?></td>
                                                                    <td><?= $value->tipoins ?></td>
                                                                    <td>
                                                                        <input type="hidden" value="<?= $value->idhojapruebas ?>">
                                                                        <input type="submit" name="consultar" id="btn-cancel-pruebas" class="btn btn-primary" style="background-color: #393185;border-radius: 40px 40px 40px 40px" value="Cancelar">
                                                                    </td>
                                                                <?php endforeach; ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <img src="<?php echo base_url(); ?>assets/images/logo.png" />
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal" id="presionLlantas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog animated bounceInDown">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Presión de inflado</h4>
                </div>
                <div class="modal-body" style="background: whitesmoke">
                    <div style="text-align: center">
                        <?php
                        echo $placaR[0]->placa;
                        ?>
                    </div>

                    <label id="mensajeSicov"
                        style="background: white;
                               width: 100%;
                               text-align: left;
                               font-size: 15px;
                               padding: 5px;border: solid gray 2px;
                               border-radius:  15px 15px 15px 15px;color: black">- Ingrese los valores de presión de inflado, según la configuración inferior del vehículo.<br>- Para motos, gestione los valores en llanta derecha.<br>- Si el vehículo solo tiene una llanta en los ejes traseros, asigne el valor en el lado <strong>externo</strong>.<br>- Use el punto decimal (.)</label>
                    <div style="text-align: center;width: 100%">
                        <table style="width: 100%">
                            <tr>
                                <td>
                                    Eje
                                </td>
                                <td colspan="2">
                                    Izquierdo (psi)
                                </td>
                                <td colspan="2">
                                    Derecho (psi)
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    1
                                </td>
                                <td colspan="2">
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-1-I-a" value="<?php echo $presion->llanta_1_I; ?>" onchange="guardarPresion(this)" />
                                </td>
                                <td colspan="2">
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-1-D-a" value="<?php echo $presion->llanta_1_D; ?>" onchange="guardarPresion(this)" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    2
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-2-IE-a" value="<?php echo $presion->llanta_2_IE; ?>" onchange="guardarPresion(this)" />
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-2-II-a" value="<?php echo $presion->llanta_2_II; ?>" onchange="guardarPresion(this)" />
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-2-DI-a" value="<?php echo $presion->llanta_2_DI; ?>" onchange="guardarPresion(this)" />
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-2-DE-a" value="<?php echo $presion->llanta_2_DE; ?>" onchange="guardarPresion(this)" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    3
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-3-IE-a" value="<?php echo $presion->llanta_3_IE; ?>" onchange="guardarPresion(this)" />
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-3-II-a" value="<?php echo $presion->llanta_3_II; ?>" onchange="guardarPresion(this)" />
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-3-DI-a" value="<?php echo $presion->llanta_3_DI; ?>" onchange="guardarPresion(this)" />
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-3-DE-a" value="<?php echo $presion->llanta_3_DE; ?>" onchange="guardarPresion(this)" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    4
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-4-IE-a" value="<?php echo $presion->llanta_4_IE; ?>" onchange="guardarPresion(this)" />
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-4-II-a" value="<?php echo $presion->llanta_4_II; ?>" onchange="guardarPresion(this)" />
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-4-DI-a" value="<?php echo $presion->llanta_4_DI; ?>" onchange="guardarPresion(this)" />
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-4-DE-a" value="<?php echo $presion->llanta_4_DE; ?>" onchange="guardarPresion(this)" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    5
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-5-IE-a" value="<?php echo $presion->llanta_5_IE; ?>" onchange="guardarPresion(this)" />
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-5-II-a" value="<?php echo $presion->llanta_5_II; ?>" onchange="guardarPresion(this)" />
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-5-DI-a" value="<?php echo $presion->llanta_5_DI; ?>" onchange="guardarPresion(this)" />
                                </td>
                                <td>
                                    <input type="number" style="text-align: center;width: 70px" id="llanta-5-DE-a" value="<?php echo $presion->llanta_5_DE; ?>" onchange="guardarPresion(this)" />
                                </td>
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td>
                                    Externo
                                </td>
                                <td>
                                    Interno
                                </td>
                                <td>
                                    Interno
                                </td>
                                <td>
                                    Externo
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Repuesto
                                </td>
                                <td colspan="2">
                                    <input type="number" style="text-align: center;width: 70px" value="<?php echo $presion->llanta_R; ?>" id="llanta-R-a" onchange="guardarPresion(this)" />
                                </td>
                                <td colspan="2">
                                    <input type="number" style="text-align: center;width: 70px" value="<?php echo $presion->llanta_R2; ?>" id="llanta-R" onchange="guardarPresion(this)" />
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnAsignar" data-dismiss="modal" class="btn btn-success" type="button">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal-visual" role="dialog" aria-hidden="true" style="display: none" data-backdrop="false">
        <div class="modal-dialog animated bounceInDown">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titulo_">Pruebas visual</h4>
                </div>
                <div class="modal-body">
                    <table class="table" id="table-modal-visual">
                        <tbody>
                            <div id="cap-new">
                                <label>En captador no esta asignado, si lo desea lo puede crear:</label>
                                <label style="padding-left: 40px"><input type="checkbox" style="transform: scale(2.0)" class="skin-square-blue" id="captador">
                                    <labe style="padding-left: 15px">Captador</labe>
                                </label><br>
                                <div style="color: #1D8348" id="msj-cap"></div>
                                <hr>
                            </div>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" id="btn-close" type="button">Cerrar</button>
                    <button class="btn btn-success" type="button" id="btn-reasig-visual">Guardar</button>
                </div>
            </div>
        </div>
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
    <script>
        window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"><\/script>');
    </script>
    <!-- CORE JS FRAMEWORK - END -->


    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->

    <script src="<?php echo base_url(); ?>assets/plugins/icheck/icheck.min.js" type="text/javascript"></script>
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->


    <!-- CORE TEMPLATE JS - START -->
    <script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>/application/libraries/package/dist/sweetalert2.all.min.js"></script>
    <script src="<?php echo base_url(); ?>application/libraries/sesion.js" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS - END -->
    <script type="text/javascript">
        var placa = "<?php
                        echo $placaR[0]->placa;
                        ?>";
        var reinspeccion = "<?php
                            echo $placaR[0]->reinspeccion;
                            ?>";
        var moduloPrerevision = '<?php
                                    if (isset($moduloPrerevision)) {
                                        echo $moduloPrerevision;
                                    } else {
                                        echo '0';
                                    }
                                    ?>';
        $(document).ready(function() {

        });

        document.addEventListener('DOMContentLoaded', cargarMedioGuardado);

        function guardarMedio() {
            const select = document.getElementById('medioSelect');
            const valorSeleccionado = select.value;

            // Guardar en localStorage
            localStorage.setItem('medioPreferido', valorSeleccionado);

            console.log('Medio guardado:', valorSeleccionado);
        }

        function cargarMedioGuardado() {
            const medioGuardado = localStorage.getItem('medioPreferido');

            if (medioGuardado !== null) {
                const select = document.getElementById('medioSelect');

                // Establecer el valor guardado
                select.value = medioGuardado;

                console.log('Medio cargado desde localStorage:', medioGuardado);
            }
        }

        var guardarPresion = function(e) {
            var tipo_inspeccion = "0";
            var reins = "0";
            if (reinspeccion === '0' || reinspeccion === '1') {
                tipo_inspeccion = '1';
                reins = reinspeccion;
            } else if (reinspeccion === '4444' || reinspeccion === '44441') {
                tipo_inspeccion = '2';
                if (reinspeccion === '4444') {
                    reins = '0';
                } else {
                    reins = '1';
                }
            } else {
                reins = '0';
                tipo_inspeccion = '3';
            }
            var data = {
                numero_placa_ref: placa,
                tipo_inspeccion: tipo_inspeccion,
                reinspeccion: reins,
                valor: e.value,
                id: e.id
            };
            //                                                console.log(data);
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/guardarPresion',
                type: 'post',
                data: data,
                success: function(rta) {}
            });
        };


        //---------------------------------------INTEGRACION 20210320 BRAYAN LEON

        var cargar = function() {
            $('#razon-reasignacion').val('');
            document.getElementById("div-pruebas").style.display = '';
            var idhojapruebas = $('#idhojapruebasR').val();
            var reinspeccion = $('#reinspeccion').val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/getPruebas',
                type: 'post',
                mimeType: 'json',
                data: {
                    idhojapruebas: idhojapruebas,
                    reinspeccion: reinspeccion,
                },
                success: function(data, textStatus, jqXHR) {
                    $('#table-rea-prueba tbody').html('');

                    $.each(data, function(i, data) {
                        if (data.estado == 'Asignado') {
                            var asignado = "";
                            var asignado = "<td style= 'color: gray '><strong>" + data.estado + "</strong></td>";
                        } else if (data.estado == 'Aprobado') {
                            var asignado = "";
                            var asignado = "<td style= 'color: green'><strong>" + data.estado + "</strong></td>";
                        } else {
                            var asignado = "";
                            var asignado = "<td style= 'color: red'><strong>" + data.estado + "</strong></td>";
                        }
                        var body = "<tr>";
                        body += "<td>" + data.idprueba + "</td>";
                        body += "<td>" + data.fechainicial + "</td>";
                        body += asignado;
                        body += "<td>" + data.fechafinal + "</td>";
                        body += "<td>" + data.pruebas + "</td>";
                        body += '<td style="text-aling: center;"><type="submit" class="btn btn-primary"  style="background-color: #393185;border-radius: 40px 40px 40px 40px"  onClick="reasignarpru(\'' + data.idtipo_prueba + '\',\'' + data.idprueba + '\',\'' + idhojapruebas + '\',\'' + data.pruebas + '\', \'' + data.prueba + '\')">Reasignar</td>';
                        body += "</tr>";
                        $("#table-rea-prueba tbody").append(body);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {

                }
            });
        };
        $('#btn-buscar-pruebas').click(function(ev) {
            $('#val-razon').html('');
            cargar();
        });


        function reasignarpru(idtipo_prueba, idprueba, idhojapruebas, pruebas, prueba) {
            //                                                if ($('#razon-reasignacion').val().length == 0) {
            //                                                    $('#val-razon').html('Escriba por favor la razÃ³n de la reasignaciÃ³n.');
            //                                                    $("html, body").animate({scrollTop: "0px"});
            //                                                } else {
            $('#val-razon').html('');
            var razon = $('#razon-reasignacion').val();
            if (idtipo_prueba == 8) {
                pruebavisual(idprueba, idhojapruebas);
            } else {
                pruebanormal(idprueba, idhojapruebas, pruebas, idtipo_prueba, prueba);
            }
            //                                                }
        }

        function pruebavisual(idprueba, idhojapruebas) {
            localStorage.setItem("idvisual", idprueba);
            $('#modal-visual tbody').html('');
            $('#modal-visual').modal('show');
            var reinspeccion = $('#reinspeccion').val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/getPruebasvisual',
                type: 'post',
                mimeType: 'json',
                data: {
                    idhojapruebas: idhojapruebas,
                    reinspeccion: reinspeccion,
                },
                success: function(data, textStatus, jqXHR) {
                    document.getElementById("cap-new").style.display = '';
                    document.getElementById("captador").disabled = false;
                    $('input[type=checkbox]').prop('checked', false);
                    $('#msj-cap').html('');
                    console.log(data);
                    $.each(data, function(i, data) {
                        if (data.idtipo_prueba == 14) {
                            document.getElementById("cap-new").style.display = 'none';
                        }
                        if (data.idtipo_prueba == 21 || data.idtipo_prueba == 22) {
                            var input = '<td><input checked type="checkbox" style="transform: scale(2.0)" data2="' + data.idtipo_prueba + '" data="' + data.idprueba + '"class="skin-square-blue idpruebas"  >'
                        } else {
                            var input = '<td><input type="checkbox" style="transform: scale(2.0)" data2="' + data.idtipo_prueba + '" data="' + data.idprueba + '"class="skin-square-blue idpruebas"  >'
                        }
                        var body = '<tr>';
                        body += input;
                        body += '<td style="padding-left: 3px">' + data.pruebas + '</td>';
                        body += '</tr>';
                        $("#table-modal-visual tbody").append(body);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {

                }
            });
        }

        $(document).on('click', '#captador', function(event) {
            if ($(this).is(':checked')) {
                var idhojapruebas = $('#idhojapruebasR').val();
                var fechainicial = $('#fechainicial').val();
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/getCreateCaptador',
                    type: 'post',
                    mimeType: 'json',
                    data: {
                        idhojapruebas: idhojapruebas,
                        fechainicial: fechainicial
                    },
                    success: function(data, textStatus, jqXHR) {
                        if (data == 1) {
                            document.getElementById("captador").disabled = true;
                            $('#msj-cap').html('Se creo la prueba captador');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    }
                });
            }
        });

        $('#btn-reasig-visual').click(function() {
            var idhojapruebas = $('#idhojapruebasR').val();
            var idvisual = localStorage.getItem('idvisual');
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/updateVisual',
                type: 'post',
                mimeType: 'json',
                data: {
                    idhojapruebas: idhojapruebas,
                    idvisual: idvisual,
                },
                success: function(data, textStatus, jqXHR) {
                    if (data == 1) {
                        var i = 0;
                        $('#table-modal-visual .idpruebas').each(function() {
                            if ($(this).is(':checked')) {
                                var idtipoprueba = $(this).attr('data');
                                var idtipo_prueba = $(this).attr('data2');
                                $.ajax({
                                    url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/updatePruebasVisual',
                                    type: 'post',
                                    mimeType: 'json',
                                    data: {
                                        idhojapruebas: idhojapruebas,
                                        idtipoprueba: idtipoprueba,
                                        idtipo_prueba: idtipo_prueba
                                    },
                                    success: function(data, textStatus, jqXHR) {
                                        $('#btn-close').click();
                                        $('html, body').animate({
                                            scrollTop: $("#val-razon").offset().top
                                        }, 900);
                                        $('#val-razon').html('<div style="color: #1D8348; font-size: 17px; text-align: center;">La prueba visual fue asignada.</div>');
                                        $('#razon-reasignacion').val('');
                                        reload();
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {

                                    }
                                });
                                i++;
                            } else {
                                $('#btn-close').click();
                                $('html, body').animate({
                                    scrollTop: $("#val-razon").offset().top
                                }, 900);
                                $('#val-razon').html('<div style="color: #1D8348; font-size: 17px; text-align: center;">La prueba visual fue asignada.</div>');
                                $('#razon-reasignacion').val('');
                                reload();
                            }
                        });
                    };
                },
                error: function(jqXHR, textStatus, errorThrown) {

                }
            });

        });

        function pruebanormal(idprueba, idhojapruebas, pruebas, idtipo_prueba, prueba) {
            console.log(idtipo_prueba);
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/updatePruebas',
                type: 'post',
                mimeType: 'json',
                data: {
                    idhojapruebas: idhojapruebas,
                    idprueba: idprueba,
                    idtipo_prueba: idtipo_prueba,
                    prueba: prueba
                },
                success: function(data, textStatus, jqXHR) {
                    $('html, body').animate({
                        scrollTop: $("#val-razon").offset().top
                    }, 900);
                    $('#val-razon').html('<div style="color: #1D8348; font-size: 17px; text-align: center">La prueba ' + pruebas + ' fue asignada.</div>');
                    $('#razon-reasignacion').val('');
                    reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {

                }
            });
        }
        $('#btn-close').click(function() {
            document.getElementById("modal-visual").style.display = 'none';
        });

        var reload = function() {
            var count = 0;
            var process = setInterval(function() {
                if (count === 0) {
                    cargar();
                }
                if (count === 1)
                    clearInterval(process);
                count++;
            }, 1000);
        };
        $(document).on('click', '#estado', function(event) {
            if ($(this).is(':checked')) {
                $('.rta').prop('checked', false);
                document.getElementById("select-estado").style.display = '';
                document.getElementById("label-estado").style.display = 'none';
            } else {
                $('.rta2').prop('checked', true);
                document.getElementById("select-estado").style.display = 'none';
                document.getElementById("label-estado").style.display = '';
            }
        });
        $('#btn-pin-estado').click(function() {
            var pin = $('#pin').val();
            var idhojapruebasR = $('#idhojapruebasR').val();
            var estadop = $('#estadoP option:selected').attr('value');
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/updateEstadoPin',
                type: 'post',
                mimeType: 'json',
                data: {
                    idhojapruebas: idhojapruebasR,
                    pin: pin,
                    estado: estadop
                },
                success: function(data, textStatus, jqXHR) {
                    $('#div-rest-estado').html('<div style="color: #1D8348;font-size: 17px; text-align: center">' + data + '</div>');
                    $('.rta').prop('checked', false);
                    document.getElementById("select-estado").style.display = 'none';
                    document.getElementById("label-estado").style.display = '';
                },
                error: function(jqXHR, textStatus, errorThrown) {

                }
            });
        });
        $('#btn-reconf-prueba').click(function() {
            var selectrecofprueba = $('#selectrecofprueba option:selected').attr('value');
            var hojapruebas = $('#hojapruebasR').val();
            var pfechainicial = $('#pfechainicialR').val();
            var tipovehiculo = $('#tipovehiculoR').val();
            var servicio = $('#servicioR').val();
            var combustible = $('#combustibleR').val();
            var placa = $('#placaR').val();
            //                                                console.log(selectrecofprueba, hojapruebas, pfechainicial, tipovehiculo, 'servicio:', servicio, combustible, placa);
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/reConfvehiculosPruebas',
                type: 'post',
                mimeType: 'json',
                data: {
                    idhojapruebas: hojapruebas,
                    selectrecofprueba: selectrecofprueba,
                    servicio: servicio,
                    pfechainicial: pfechainicial,
                    tipovehiculo: tipovehiculo,
                    combustible: combustible,
                    placa: placa
                },
                success: function(data, textStatus, jqXHR) {
                    $('#div-reconf-prueba').html('<div style="color: #1D8348;font-size: 17px; text-align: center">' + data + '</div>');
                },
                error: function(jqXHR, textStatus, errorThrown) {

                }
            });
        });
        $('#btn-cancel-pruebas').click(function() {
            var hojapruebas = $('#hojapruebasR').val();
            var reinspeccion = $('#reinspeccion').val();
            if (reinspeccion !== '1') {
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/cancelarPruebas',
                    type: 'post',
                    mimeType: 'json',
                    data: {
                        idhojapruebas: hojapruebas,
                        reinspeccion: reinspeccion
                    },
                    success: function(data, textStatus, jqXHR) {
                        $('#div-cancel-prueba').html('<div style="color: #1D8348; font-size: 17px; text-align: center">' + data + '</div>');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    html: '<div style="color: red; font-size: 22px">Esta cancelando una prueba de reinspección</div>',
                    showCancelButton: true,
                    confirmButtonText: `Aceptar`,
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/cancelarPruebas',
                            type: 'post',
                            mimeType: 'json',
                            data: {
                                idhojapruebas: hojapruebas,
                                reinspeccion: reinspeccion
                            },
                            success: function(data, textStatus, jqXHR) {
                                $('#div-cancel-prueba').html('<div style="color: #1D8348; font-size: 17px; text-align: center">' + data + '</div>');
                            },
                            error: function(jqXHR, textStatus, errorThrown) {

                            }
                        });
                    }
                })
            }
        });
    </script>

</body>

</html>