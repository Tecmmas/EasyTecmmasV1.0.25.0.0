<!DOCTYPE html>
<html class=" ">

<head>

    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>VEHICULO RECHAZADO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" type="image/x-icon" />
    <!-- Favicon -->
    <link rel="apple-touch-icon-precomposed"
        href="<?php echo base_url(); ?>assets/images/apple-touch-icon-57-precomposed.png"> <!-- For iPhone -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="<?php echo base_url(); ?>assets/images/apple-touch-icon-114-precomposed.png">
    <!-- For iPhone 4 Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="<?php echo base_url(); ?>assets/images/apple-touch-icon-72-precomposed.png"> <!-- For iPad -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="<?php echo base_url(); ?>assets/images/apple-touch-icon-144-precomposed.png">
    <!-- For iPad Retina display -->

    <!-- CORE CSS FRAMEWORK - START -->
    <link href="<?php echo base_url(); ?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css"
        media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet"
        type="text/css" />
    <!-- CORE CSS FRAMEWORK - END -->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START -->


    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END -->


    <!-- CORE CSS TEMPLATE - START -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS TEMPLATE - END -->
    <!-- CORE CSS TEMPLATE - END -->

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="login_page" style="background: white">

    <div class="col-xl-12">
        <section class="box ">
            <div class="content-body" style="background: lightsalmon">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <section class="box ">
                            <form action="<?php echo base_url(); ?>index.php/oficina/CGestion" method="post">
                                <input name="button" class="btn btn-accent btn-block"
                                    style="width: 100px;background: #393185" type="submit" value="Atras" />
                            </form>
                            <header class="panel_header">
                                <h2 class="title float-left">Vehiculo rechazado sin firmar</h2>
                            </header>
                            <div class="content-body">
                                <input id="idhojapruebas" value="<?php echo $dato; ?>" type="hidden" />
                                <strong style="color: salmon">Seleccione al jefe de pista encargado de esta
                                    inspección.</strong><br><br>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td style="text-align: right">
                                                <strong>JEFE DE PISTA</strong>
                                            </td>
                                            <td colspan="3">
                                                <select name="jefepista" onchange="cambiarJefe(this)"
                                                    class="form-control input-lg m-bot15">
                                                    <option value="<?php
                                                                    echo $jefePista->valor;
                                                                    ?> "><?php
                                                                            echo $jefePista->valor;
                                                                            ?></option>
                                                    <?php
                                                    foreach ($jefesPista->result() as $jp) {
                                                        echo "<option value='$jp->nombres $jp->apellidos'>$jp->nombres $jp->apellidos</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <?php
                                if ($reinspeccion == "0" || $reinspeccion == "1") {
                                ?>
                                    <strong style="color: salmon">Es recomendable revisar el FUR antes de realizar el envío
                                        a SICOV para la firma.</strong>
                                    <br>
                                <?php
                                }
                                ?>
                                <table class="table table-bordered" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>Id control</th>
                                            <th>Placa</th>
                                            <th>Ocasión</th>
                                            <th>Pruebas rechazadas</th>
                                            <th>FUR</th>
                                            <th>Tamaño hoja</th>
                                            <th>Medio</th>
                                            <th>Firma digital</th>
                                            <?php
                                            if ($reinspeccion == "0" || $reinspeccion == "1") {
                                            ?>
                                                <th>Atestiguamiento</th>
                                                <th>Enviar a SICOV para firmar</th>
                                                <th>LOG SICOV</th>
                                            <?php
                                            }
                                            ?>
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
                                                echo $vehiculo->placa;
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
                                                foreach ($rechazadas as $pp) {
                                                    $pruebas = $pruebas . $pp->nombre . " <strong>|</strong> ";
                                                }
                                                echo $pruebas;
                                                ?>
                                            </td>
                                            <form action="<?php echo base_url(); ?>index.php/oficina/fur/CFUR"
                                                method="post" style="width: 100px;text-align: center">
                                                <td>
                                                    <button id="btnVer" disabled="" name="dato"
                                                        class="btn btn-accent btn-block" value="<?php echo $dato; ?>"
                                                        type="submit" formtarget="_blank"
                                                        style="border-radius: 40px 40px 40px 40px;font-size: 14px;background-color: #393185">📄
                                                        Ver</button>
                                                </td>
                                                <td>
                                                    <select name="tamano" class="form-control input-lg m-bot15">
                                                        <option value="oficio" selected>Oficio</option>
                                                        <option value="carta">Carta</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="medio" id="medioSelect"
                                                        class="form-control input-lg m-bot15" onchange="guardarMedio()">
                                                        <option value="0" selected>Impreso</option>
                                                        <option value="1">Digital</option>
                                                    </select>
                                                </td>
                                                <input type="hidden" name="juez" id="juez">
                                            </form>
                                            <td>
                                                <i class="fa-file-signature"></i> <input type="button"
                                                    class="btn btn-danger btn-block" id="btnfirmaRechazado"
                                                    style="border-radius: 40px 40px 40px 40px;font-size: 20px; background-color: #abebc6"
                                                    value="✍ Firmar" onclick="crearModalFirma()" />
                                            </td>
                                            <?php
                                            if ($reinspeccion == "0" || $reinspeccion == "1") {
                                            ?>
                                                <td>
                                                    <form id="formatestiguamiento"
                                                        action="<?php echo base_url(); ?>index.php/oficina/atestiguamiento/Catestiguamiento"
                                                        method="post" target="_blank">
                                                        <!-- Campo hidden que contendrá el valor -->
                                                        <input type="hidden" name="dato" id="campoDato"
                                                            value="<?php echo $idhojapruebas . '-' . $reinspeccion; ?>">

                                                        <button class="btn btn-accent btn-block" type="submit"
                                                            id="btnAtestiguamiento"
                                                            style="border-radius: 40px 40px 40px 40px;font-size: 20px;background-color: #393185">
                                                            Atestiguamiento
                                                        </button>
                                                    </form>
                                                </td>

                                                <td>
                                                    <input type="button" disabled="" class="btn btn-danger btn-block"
                                                        id="btnenviarsicov"
                                                        style="border-radius: 40px 40px 40px 40px;font-size: 20px;"
                                                        value="✉️ Enviar" />
                                                </td>
                                                <td>
                                                    <input class="btn btn-success btn-block" onclick='verlogsicov("<?= $vehiculo->numero_placa; ?>" )'
                                                        style="border-radius: 40px 40px 40px 40px;font-size: 20px;"
                                                        value="Ver" />
                                                </td>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                                if ($reinspeccion == "0" || $reinspeccion == "1") {
                                ?>
                                    <div style="text-align: center">
                                        <input class="btn btn-warning btn-block" id="btnenviarfirmado"
                                            style="border-radius: 40px 40px 40px 40px;font-size: 20px;width: 300px"
                                            value="🖊️ Este FUR ya esta firmado" data-toggle='modal'
                                            data-target='#confirmacionFirma' /><br>
                                    </div>
                                <?php
                                }
                                ?>

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
                                                                        <input type="hidden" name="idhojapruebas"
                                                                            id="idhojapruebasR"
                                                                            value="<?= $value->idhojapruebas ?>">
                                                                        <input type="hidden" name="fechainicial"
                                                                            id="fechainicial"
                                                                            value="<?= $value->pfechainicial ?>">
                                                                        <input type="hidden" name="reinspeccion"
                                                                            id="reinspeccion"
                                                                            value="<?= $value->reinspeccion ?>">
                                                                        <input type="submit" name="consultar"
                                                                            id="btn-buscar-pruebas" class="btn btn-primary"
                                                                            style="background-color: #393185;border-radius: 40px 40px 40px 40px"
                                                                            value="Buscar">
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
                                                                            <input type="checkbox"
                                                                                style="transform: scale(1.0)"
                                                                                class="skin-square-blue rta"
                                                                                id="estado"><label
                                                                                style="padding-left: 15px"><?= $value->estado ?></label></label>
                                                                        <div style="display: none" id="select-estado">
                                                                            <input type="checkbox"
                                                                                style="transform: scale(1.0)"
                                                                                class="skin-square-blue rta2" id="estado"
                                                                                checked="">
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
                                                                    <td><input type="number" id="pin" name="pin"
                                                                            value="<?= $value->pin ?>"></td>
                                                                    <td>
                                                                        <input type="hidden" name="idhojapruebasR"
                                                                            id="idhojapruebasR"
                                                                            value="<?= $value->idhojapruebas ?>">
                                                                        <input type="submit" name="consultar"
                                                                            id="btn-pin-estado" class="btn btn-primary"
                                                                            style="background-color: #393185;border-radius: 40px 40px 40px 40px"
                                                                            value="Guardar">
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
                                                                        <select name="selectrecofprueba"
                                                                            id="selectrecofprueba">
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
                                                                        <input type="hidden" id="hojapruebasR"
                                                                            value="<?= $value->idhojapruebas ?>">
                                                                        <input type="hidden" name="pfechainicial"
                                                                            id="pfechainicialR"
                                                                            value="<?= $value->pfechainicial ?>">
                                                                        <input type="hidden" name="tipovehiculo"
                                                                            id="tipovehiculoR"
                                                                            value="<?= $value->tipovehiculo ?>">
                                                                        <input type="hidden" name="servicio" id="servicioR"
                                                                            value="<?= $value->servicio ?>">
                                                                        <input type="hidden" name="combustible"
                                                                            id="combustibleR"
                                                                            value="<?= $value->combustible ?>">
                                                                        <input type="hidden" name="placa" id="placaR"
                                                                            value="<?= $value->placa ?>">
                                                                        <input type="submit" name="consultar"
                                                                            class="btn btn-primary" id="btn-reconf-prueba"
                                                                            style="background-color: #393185;border-radius: 40px 40px 40px 40px"
                                                                            value="Guardar">
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
                                                                        <input type="hidden"
                                                                            value="<?= $value->idhojapruebas ?>">
                                                                        <input type="submit" name="consultar"
                                                                            id="btn-cancel-pruebas" class="btn btn-primary"
                                                                            style="background-color: #393185;border-radius: 40px 40px 40px 40px"
                                                                            value="Cancelar">
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

    <div class="modal" id="confirmacionEnvio" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog animated bounceInDown">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmación de envío</h4>
                </div>
                <div class="modal-body" style="background: whitesmoke">
                    <label id="mensajeSicov" style="background: white;
                               width: 100%;
                               text-align: center;
                               font-weight: bold;
                               font-size: 15px;
                               padding: 5px;border: solid gray 2px;
                               border-radius:  15px 15px 15px 15px;color: black">¿ESTÁ SEGURO(A) DE REALIZAR EL ENVÍO A
                        SICOV</label>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button" id="btnNoenvio">NO</button>
                    <button id="btnAsignar" class="btn btn-success" type="button"
                        onclick="validEventosFinalizados()">SI</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modalFirmaFur" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog animated bounceInDown">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Firmar el fur</h4>
                </div>
                <div class="modal-body" style="background: whitesmoke">
                    <div style="border: solid 2px; background-color:  white; width: 450px;">
                        <div id="root"></div>
                        <br>
                        <label id="mesajeFirma"></label>
                        <img id="image1" class="image full-width" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button style="background-color: #a3e4d7;" class="btn btn-default" type="button"
                        id="resetCanvas">Limpiar firma</button>
                    <button class="btn btn-success" type="button" id="getFirma">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="confirmacionFirma" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog animated bounceInDown">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmación de envío</h4>
                </div>
                <div class="modal-body" style="background: whitesmoke">
                    <label id="mensajeSicov" style="background: white;
                               width: 100%;
                               text-align: center;
                               font-weight: bold;
                               font-size: 15px;
                               padding: 5px;border: solid gray 2px;
                               border-radius:  15px 15px 15px 15px;color: black"><strong
                            style="color: salmon">ADVERTENCIA</strong> <br><br>Esta acción enviará la placa a la sección
                        de RECHAZADOS SIN CONSECUTIVO, se recomienda revisar si este FUR a sido firmado en el SICOV
                        antes de confirmar esta acción. <br><br> ¿DESEA ENVIAR LA PLACA A "RECHAZADOS SIN
                        CONSECUTIVO"?</label>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">NO</button>
                    <button id="btnAsignar" class="btn btn-success" type="button" onclick="enviarFirmar()">SI</button>
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
                                <label style="padding-left: 40px"><input type="checkbox" style="transform: scale(2.0)"
                                        class="skin-square-blue" id="captador">
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

    <!--        <div class="modal" id="xJuezModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog animated bounceInDown">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" >Alteraciones detectadas</h4>
                            </div>
                            <div class="modal-body" style="background: whitesmoke">
                                <label style="margin-top: 50%; margin-left: 50%" id="placa"></label>
                                <table class="table-bordered" id="table-juez" >
                                    <tbody id="body-juez">
        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>-->


    <!-- MAIN CONTENT AREA ENDS -->
    <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->

    <!-- Modal para Verificar Huella -->
    <div class="modal fade" id="modalConfirmBiometrica" tabindex="-1" role="dialog"
        aria-labelledby="modalConfirmBiometricaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmBiometricaLabel">Verificar Huella</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Controles de conexión -->
                    <div class="connection-controls mb-3">
                        <div id="statusConfirm" class="status disconnected mb-2">
                            Desconectado del servidor de huellas
                        </div>
                        <div class="btn-group" role="group">
                            <button id="btnConnectConfirm" onclick="connectConfirm()"
                                class="btn btn-outline-primary btn-sm">
                                Conectar
                            </button>
                            <button id="btnDisconnectConfirm" onclick="disconnectConfirm()" disabled
                                class="btn btn-outline-secondary btn-sm">
                                Desconectar
                            </button>
                            <button id="btnInitConfirm" onclick="initializeCapturerConfirm()" disabled
                                class="btn btn-outline-info btn-sm">
                                Reinicializar
                            </button>
                        </div>
                    </div>

                    <!-- Información de estado -->
                    <div id="ScoresConfirm">
                        <div id="qualityMessageBoxConfirm" style="
                    background-color: #f5f5f5;
                    border: 2px solid #007bff;
                    border-radius: 8px;
                    padding: 12px;
                    margin: 10px auto 15px auto;
                    color: #222;
                    font-size: 14px;
                    text-align: center;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.07);
                ">
                            <span id="qualityInputBoxConfirm" style="font-weight: 500;">Presione "Verificar Huella" para
                                comenzar</span>
                        </div>
                    </div>

                    <!-- Resultado de verificación -->
                    <div id="verificationResultConfirm"
                        style="display: none; padding: 15px; margin: 10px 0; border-radius: 8px; font-weight: bold; text-align: center;">
                    </div>

                    <!-- Contenedor principal en línea -->
                    <div class="row">
                        <!-- Columna de imagen de huella -->
                        <!-- <div class="col-md-6">
                            <div class="capture-area">
                                <div id="content-capture-confirm" style="height: 200px; width: 100%; margin: auto; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 2px dashed #ccc; background-color: #f9f9f9;">
                                    <div id="imagedivConfirm" style="margin: auto; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                        <div id="imagePlaceholderConfirm" class="text-center">
                                            <i class="fas fa-fingerprint fa-3x text-muted mb-2"></i>
                                            <p class="text-muted mb-0" style="font-size: 12px;">Imagen de la huella a verificar</p>
                                        </div>
                                        <img id="fingerprintImgConfirm" class="fingerprint-img" style="display: none; max-height: 180px; max-width: 100%; border-radius: 5px;" alt="Imagen de huella digital">
                                    </div>
                                </div>

                                
                                <div class="image-info mt-2 text-center">
                                    <small class="text-muted">
                                        <span id="imageInfoConfirm">Resolución: 0x0 px</span> |
                                        <span id="imageSizeConfirm">Tamaño: 0 KB</span>
                                    </small>
                                </div>
                            </div>
                        </div> -->

                        <!-- Columna del log -->
                        <div class="col-md-12">
                            <div class="log-section" style="height: 100%;">
                                <h6 style="font-size: 14px; margin-bottom: 8px;">📝 Registro de Verificación</h6>
                                <div id="logConfirm" class="log"
                                    style="height: 180px; overflow-y: scroll; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 5px; padding: 8px; font-size: 11px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del template almacenado (oculta visualmente pero funcional) -->
                    <div class="template-section mt-3" style="display: none;">
                        <textarea id="storedTemplateDataConfirm" class="form-control" rows="2" readonly></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Botones de verificación -->
                    <div class="btn-group mr-2" role="group">
                        <button id="btnVerifyConfirm" onclick="verifyFingerprint()" disabled class="btn btn-primary">
                            <i class="fas fa-search mr-1"></i> Verificar Huella
                        </button>
                    </div>

                    <!-- Botones de acciones -->
                    <button type="button" onclick="limpiarImagenConfirm()" class="btn btn-outline-secondary">
                        <i class="fas fa-broom mr-1"></i> Limpiar
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal SICOV Compacto y Sencillo -->
    <div class="modal fade" id="sicovModal" tabindex="-1" role="dialog" aria-labelledby="sicovModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" style="max-width: 90%;">
            <div class="modal-content">
                <div class="modal-header" style="background: #f8f9fa; border-bottom: 2px solid #dee2e6; padding: 8px 12px;">
                    <h5 class="modal-title" id="sicovModalLabel" style="font-size: 14px; font-weight: bold;">
                        EVENTOS SICOV - Placa: <span id="placaActual" style="color: #007bff;"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 20px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 10px;">
                    <div id="eventosSICOV">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="width: 50%; vertical-align: top; padding: 5px;">
                                    <div style="background: #fff; border: 1px solid #ddd;">
                                        <div style="background: #f8f9fa; padding: 6px 10px; border-bottom: 1px solid #ddd; font-weight: bold; font-size: 12px;">
                                            EVENTOS DE PIN
                                        </div>
                                        <div style="overflow: auto; height: 300px;">
                                            <table class="table table-bordered" style="margin: 0; font-size: 11px; width: 100%;">
                                                <thead style="background: #f8f9fa;">
                                                    <tr>
                                                        <th style="width: 45px; padding: 4px;">Ver</th>
                                                        <th style="padding: 4px;">Placa</th>
                                                        <th style="width: 50px; padding: 4px;">Oc.</th>
                                                        <th style="width: 85px; padding: 4px;">Fecha</th>
                                                        <th style="padding: 4px;">Evento</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="eventosPIN">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 50%; vertical-align: top; padding: 5px;">
                                    <div style="background: #fff; border: 1px solid #ddd;">
                                        <div style="background: #f8f9fa; padding: 6px 10px; border-bottom: 1px solid #ddd; font-weight: bold; font-size: 12px;">
                                            EVENTOS DE FUR
                                        </div>
                                        <div style="overflow: auto; height: 300px;">
                                            <table class="table table-bordered" style="margin: 0; font-size: 11px; width: 100%;">
                                                <thead style="background: #f8f9fa;">
                                                    <tr>
                                                        <th style="width: 45px; padding: 4px;">Ver</th>
                                                        <th style="padding: 4px;">Placa</th>
                                                        <th style="width: 50px; padding: 4px;">Oc.</th>
                                                        <th style="width: 85px; padding: 4px;">Fecha</th>
                                                        <th style="padding: 4px;">Evento</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="eventosFUR">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%; vertical-align: top; padding: 5px;">
                                    <div style="background: #fff; border: 1px solid #ddd;">
                                        <div style="background: #f8f9fa; padding: 6px 10px; border-bottom: 1px solid #ddd; font-weight: bold; font-size: 12px;">
                                            EVENTOS DE RUNT
                                        </div>
                                        <div style="overflow: auto; height: 300px;">
                                            <table class="table table-bordered" style="margin: 0; font-size: 11px; width: 100%;">
                                                <thead style="background: #f8f9fa;">
                                                    <tr>
                                                        <th style="width: 45px; padding: 4px;">Ver</th>
                                                        <th style="padding: 4px;">Placa</th>
                                                        <th style="width: 50px; padding: 4px;">Oc.</th>
                                                        <th style="width: 85px; padding: 4px;">Fecha</th>
                                                        <th style="padding: 4px;">Evento</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="eventosRUNT">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 50%; vertical-align: top; padding: 5px;">
                                    <div style="background: #fff; border: 1px solid #ddd;">
                                        <div style="background: #f8f9fa; padding: 6px 10px; border-bottom: 1px solid #ddd; font-weight: bold; font-size: 12px;">
                                            EVENTOS DE PRUEBAS
                                        </div>
                                        <div style="overflow: auto; height: 300px;">
                                            <table class="table table-bordered" style="margin: 0; font-size: 11px; width: 100%;">
                                                <thead style="background: #f8f9fa;">
                                                    <tr>
                                                        <th style="width: 45px; padding: 4px;">Ver</th>
                                                        <th style="padding: 4px;">Placa</th>
                                                        <th style="width: 85px; padding: 4px;">Fecha</th>
                                                        <th style="padding: 4px;">Evento</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="eventosPruebas">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 6px 10px; background: #f8f9fa; border-top: 1px solid #dee2e6;">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" style="font-size: 12px; padding: 4px 12px;">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para detalle de eventos (si no existe) -->
    <div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-labelledby="detalleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleModalLabel">Detalle del Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detalleEventoContent">
                    <!-- Contenido del detalle -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- CORE JS FRAMEWORK - START -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.easing.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"
        type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>/application/libraries/package/dist/sweetalert2.all.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"><\/script>');
    </script>
    <!-- CORE JS FRAMEWORK - END -->


    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->

    <script src="<?php echo base_url(); ?>assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js"
        type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/autonumeric/autoNumeric-min.js" type="text/javascript">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/lemonadejs/dist/lemonade.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@lemonadejs/signature/dist/index.min.js"></script>
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->


    <!-- CORE TEMPLATE JS - START -->
    <script src="<?php echo base_url(); ?>assets/js/scripts.js" type="text/javascript"></script>
    <!--<script src="<?php echo base_url(); ?>/application/libraries/package/dist/sweetalert2.all.min.js"></script>-->
    <script src="<?php echo base_url(); ?>application/libraries/sesion.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- END CORE TEMPLATE JS - END -->

    <script type="text/javascript">
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        var placa = "<?php
                        echo $placa;
                        ?>";
        var ocasion = "<?php
                        echo $ocacion;
                        ?>";
        var sicov = "<?php
                        echo $this->session->userdata('sicov');
                        ?>";
        var firmaDigital = "<?php
                            echo $this->session->userdata('firmaDigital');
                            ?>";
        var huellaDigital = "<?php
                                echo $this->session->userdata('huellaDigital');
                                ?>";
        $(document).ready(function() {

            var text = new XMLHttpRequest();
            text.open("GET", "<?php echo base_url(); ?>system/dominio.dat", false);
            text.send(null);
            dominio = text.responseText;
            var datos = {
                dominio: dominio,
                function: "getPassword"
            }
            fetch("http://updateapp.tecmmas.com/Actualizaciones/index.php/Cpassword", {
                    method: "POST",
                    body: JSON.stringify(datos),
                    headers: {
                        'Autorization': 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.Ijg5NnNkYndmZTg3dmNzZGFmOTg0bmc4ZmdoMjRvMTI5MHIi.HraZ7y3eG3dGhKngzOWge-je8Y3lxZgldXjbRbcA7cA',
                        'Content-Type': 'application/json'
                    },
                }, 200)
                .then(respuesta => respuesta.json())
                .then((rta) => {
                    $("#juez").val(rta[0]['juez']);
                    localStorage.setItem("juez", rta[0]['juez'])

                    //                                    localStorage.setItem("pserts",rta[0]['clave'])
                })

                .catch(error => {

                });
            var data = {
                desdeVisor: 'juez',
                dato: $('#idhojapruebas').val(),
                IdUsuario: '1',
                juez: localStorage.getItem("juez"),
                fechaJuez: localStorage.getItem("fechaEncript")
            };

            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/fur/CFUR',
                type: 'post',
                mimeType: 'json',
                data: data,
                success: function(rta) {
                    if (rta.furCorregido === "0")
                        $.ajax({
                            url: 'http://updateapp.tecmmas.com/Actualizaciones/index.php/Cjuez',
                            type: 'post',
                            mimeType: 'json',
                            data: {
                                rta: rta,
                                dominio: dominio
                            },
                            async: false,
                            timeout: 3000,
                            success: function(data, textStatus, jqXHR) {
                                if (localStorage.getItem("juez") == "1" && (rta.pruebas
                                        .length !== 0 || rta.resultados.length !== 0) && rta
                                    .fechaFur >= localStorage.getItem("fechaEncript")) {
                                    Swal.fire({
                                        title: 'Detección de registros alterados.',
                                        html: "<div style='font-size:15px; color: red'>Se han detectado alteraciones en esta inspección y no se puede certificar, por favor comuníquese con soporte técnico para más información.  </div>",
                                        icon: 'info',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Aceptar',
                                        allowOutsideClick: false
                                    }).then((result) => {
                                        if (result.value) {
                                            //                                                                window.location.replace("<?php echo base_url(); ?>index.php/oficina/CGestion");
                                        } else if (result.dismiss === "cancel") {
                                            //                                                                window.location.replace("<?php echo base_url(); ?>index.php/oficina/CGestion");
                                        }
                                    });

                                } else {
                                    // dominio = "cdalaestacion.tecmmas.com"
                                    if (dominio == "cdalaestacion.tecmmas.com" &&
                                        huellaDigital == '1') {
                                        $("#btnenviarsicov").attr("disabled", true);
                                        $("#btnVer").attr("disabled", false);
                                    } else {

                                        $("#btnenviarsicov").attr("disabled", false);
                                        $("#btnVer").attr("disabled", false);
                                    }
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                $("#btnenviarsicov").attr("disabled", false);
                                $("#btnVer").attr("disabled", false);
                            }
                        });
                    else {
                        Swal.fire({
                            title: 'Ajuste inspección',
                            html: "<div style='font-size:15px; color: blue'>La inspección ha sido ajustada bajo los parámetos de los literales (k) y (l) de la resolución 3625. Diríjase al visor para verificar los cambios </div>",
                            icon: 'info',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Aceptar',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.value) {
                                window.location.replace(
                                    "<?php echo base_url(); ?>index.php/oficina/CGestion");
                            } else if (result.dismiss === "cancel") {
                                window.location.replace(
                                    "<?php echo base_url(); ?>index.php/oficina/CGestion");
                            }
                        });

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var rta = new Object();
                    rta.fechaFur = "1900-00-00";
                    rta.furCorregido = "0";
                    var pruebas = [];
                    var resultados = [];
                    pruebas[0] = new Object();
                    pruebas[0].placa = "0";
                    pruebas[0].tipo_prueba = "e";
                    pruebas[0].old = jqXHR.responseText;
                    pruebas[0].new = "ERROR";
                    //                                        console.log(pruebas);
                    rta.pruebas = pruebas;
                    rta.resultados = resultados;
                    $.ajax({
                        url: 'http://updateapp.tecmmas.com/Actualizaciones/index.php/Cjuez',
                        type: 'post',
                        mimeType: 'json',
                        data: {
                            rta: rta,
                            dominio: dominio
                        },
                        async: false,
                        timeout: 3000,
                        success: function(data, textStatus, jqXHR) {},
                        error: function(jqXHR, textStatus, errorThrown) {
                            $("#btnenviarsicov").attr("disabled", false);
                            $("#btnVer").attr("disabled", false);
                        }
                    });
                    if (localStorage.getItem("juez") == "1") {
                        Swal.fire({
                            title: 'Detección de errores en esta inspección.',
                            html: "<div style='font-size:15px; color: red'>Se han detectado errores en esta inspección y no se puede certificar, por favor comuníquese con soporte técnico.  </div>",
                            icon: 'info',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Aceptar',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.value) {
                                //                                                                window.location.replace("<?php echo base_url(); ?>index.php/oficina/CGestion");
                            } else if (result.dismiss === "cancel") {
                                //                                                                window.location.replace("<?php echo base_url(); ?>index.php/oficina/CGestion");
                            }
                        });
                    } else {
                        $("#btnenviarsicov").attr("disabled", false);
                        $("#btnVer").attr("disabled", false);
                    }
                }
            });
            if (firmaDigital == 1)
                getFirmaFur();
            //                                

        });

        document.addEventListener('DOMContentLoaded', cargarMedioGuardado);

        function verlogsicov(placa) {
            // Mostrar la placa en el modal
            document.getElementById('placaActual').innerHTML = placa;

            // Abrir el modal
            $('#sicovModal').modal('show');

            // Mostrar loading mientras se cargan los datos
            mostrarLoading();

            // Cargar los eventos
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/CGestion/cargarSICOV',
                type: 'post',
                data: {
                    placa: placa
                }, // Enviar la placa al servidor si es necesario
                success: function(rta) {
                    try {
                        var eventos = JSON.parse(rta);
                        cargarEventosSicov('eventosPIN', eventos.sicovEventos, 'p', placa);
                        cargarEventosSicov('eventosFUR', eventos.sicovEventos, 'f', placa);
                        cargarEventosSicov('eventosRUNT', eventos.sicovEventos, 'r', placa);
                        cargarEventosPruebas(eventos.sicovEventos, placa);
                        ocultarLoading();
                    } catch (e) {
                        console.error('Error al parsear JSON:', e);
                        mostrarError('Error al cargar los datos del SICOV');
                        ocultarLoading();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la petición:', error);
                    mostrarError('Error de conexión al cargar los datos');
                    ocultarLoading();
                }
            });
        }

        // Función para mostrar loading
        function mostrarLoading() {
            $('#sicovModal .modal-body').append('<div id="loadingOverlay" style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.8); z-index:9999; display:flex; justify-content:center; align-items:center;"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span style="margin-left:10px;">Cargando eventos...</span></div>');
        }

        // Función para ocultar loading
        function ocultarLoading() {
            $('#loadingOverlay').remove();
        }

        // Función para mostrar error
        function mostrarError(mensaje) {
            alert(mensaje);
        }

       

        var cargarEventosSicov = function(contenedor, iterador, tipo, placa) {
            var contenido = '';
            document.getElementById(contenedor).innerHTML = '';
            if (iterador.length !== 0) {
                iterador.forEach(function(dat) {
                    if (dat.tipo === tipo) {
                        var msj = dat.respuesta.split('|');
                        var color = "#ccffcc";
                        if (msj[3] === 'error')
                            color = "#ffcccc";
                        var ocasion = "1ra";
                        if (dat[2] === '2')
                            ocasion = "2da";
                        contenido += '<tr style="background: ' + color + '">\n\
                            <td><button name="dato" value ="' + dat.respuesta.replace(/"/g, '&quot;') + '" onclick="verDetalleEvento(this)" type="button" style="border-radius: 40px 40px 40px 40px;font-size: 14px" data-toggle="modal" data-target="#detalleModal">Ver</button></td>\n\
                            <td>' + dat.idelemento + '</td>\n\
                            <td>' + ocasion + '</td>\n\
                            <td>' + dat.fecha + '</td>\n\
                            <td>' + (msj[0] || 'Sin descripción') + '</td>\n\
                          </tr>';
                    }
                });
            } else {
                contenido = '<tr><td colspan="5" style="text-align: center;">No hay eventos disponibles</td></tr>';
            }
            document.getElementById(contenedor).innerHTML = contenido;
        };

        var cargarEventosPruebas = function(iterador, placa) {
            var contenido = '';
            document.getElementById('eventosPruebas').innerHTML = '';
            if (iterador.length !== 0) {
                iterador.forEach(function(dat) {
                    if (dat.tipo === 'prueba') {
                        var msj = dat.respuesta.split('|');
                        contenido += '<tr>\n\
                            <td><button name="dato" value ="' + dat.respuesta.replace(/"/g, '&quot;') + '" onclick="verDetalleEvento(this)" type="button" style="border-radius: 40px 40px 40px 40px;font-size: 14px" data-toggle="modal" data-target="#detalleModal">Ver</button></td>\n\
                            <td>' + dat.idelemento + '</td>\n\
                            <td>' + dat.fecha + '</td>\n\
                            <td>' + (msj[0] || 'Sin descripción') + '</td>\n\
                          </tr>';
                    }
                });
            } else {
                contenido = '<tr><td colspan="4" style="text-align: center;">No hay eventos de pruebas</td></tr>';
            }
            document.getElementById('eventosPruebas').innerHTML = contenido;
        };

          function verDetalleEvento(boton) {
            var valor = boton.value;
            var detalles = valor.split('|');
            var contenido = '<div class="card">\n\
                        <div class="card-body">\n\
                            <h5 class="card-title">Detalles del Evento</h5>\n\
                            <p><strong>Descripción:</strong> ' + (detalles[0] || 'N/A') + '</p>\n\
                            <p><strong>Información adicional:</strong> ' + (detalles[4] || 'N/A') + '</p>\n\
                            <p><strong>Código:</strong> ' + (detalles[2] || 'N/A') + '</p>\n\
                            <p><strong>Tipo:</strong> ' + (detalles[3] || 'N/A') + '</p>\n\
                        </div>\n\
                    </div>';
            document.getElementById('detalleEventoContent').innerHTML = contenido;
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////// fin control de eventos /////////////////////////////////

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

        $("#formatestiguamiento").submit(function(ev) {
            // Este evento se ejecutará cuando se envíe el formulario
            $("#btnenviarsicov").attr("disabled", false);
            // No necesitas preventDefault() porque quieres que se envíe
        });

        $("#btnenviarsicov").click(function() {
            var idht = $('#idhojapruebas').val().split('-');
            console.log(idht[0]);
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/getDilucion',
                type: 'post',
                mimeType: 'json',
                data: {
                    idhojapruebas: idht[0],
                    reinspeccion: idht[1]
                },
                success: function(data) {
                    if (data.length > 0 && data[0].valor === 'DILUSION EXCESIVA') {
                        Toast.fire({
                            icon: "info",
                            html: "<div style='font-size:15px;'>Se ha detectado 'DILUCIÓN EXCESIVA' en los resultados de la prueba. Por favor, repita el procedimiento de inspección de la prueba de gases.</div>",
                            timer: 10000
                        });
                    } else {
                        // dominio = "cdalaestacion.tecmmas.com";
                        if (dominio == "cdalaestacion.tecmmas.com" && huellaDigital == '1') {

                            $("#modalConfirmBiometrica").modal('show');
                        } else {

                            $("#confirmacionEnvio").modal('show');
                        }
                    }



                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Toast.fire({
                        icon: "error",
                        title: "No se pudo validar informacion de rechazo"
                    });

                }
            });
        })



        var crearModalFirma = function() {
            if (firmaDigital == 1) {
                $("#resetCanvas").click();
                $("#root").html("");
                const root = document.getElementById("root")
                const resetCanvas = document.getElementById("resetCanvas")
                const getImage = document.getElementById("getFirma")
                const image1 = document.getElementById("image1")
                // Call signature with the root element and the options object, saving its reference in a variable
                const component = Signature(root, {
                    width: 450,
                    height: 200,
                    instructions: "Por favor ingrese la firma"
                });
                $("#modalFirmaFur").modal("show");

                resetCanvas.addEventListener("click", () => {
                    component.value = [];
                });

                getImage.addEventListener("click", () => {
                    //getImage.nextElementSibling.src = component.getImage();
                    firma = component.getImage();
                    guardarFirma(firma);
                    // image1.src = img.trim();

                });
            } else {
                Swal.fire({
                    title: '<div style="font-size:15px;">Activación</div>',
                    html: "<div style='font-size:15px;'>Este servicio requiere activación para mas información, comuniquese con el area de soporte.</div>",
                    icon: 'info',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false
                })
            }




        }


        var guardarFirma = function(firma) {
            const image1 = document.getElementById("image1")
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/guardarFirmaDigital',
                type: 'post',
                data: {
                    firma: firma,
                    idhojapruebas: $('#idhojapruebas').val(),
                    reinspeccion: $('#reinspeccion').val()
                },
                success: function(rta) {
                    $("#modalFirmaFur").modal("hide");
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Firma guardada",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    image1.src = firma;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: '<div style="font-size:15px;">No se pudo guardar la firma</div>',
                        html: "<div style='font-size:15px;'>Comuniquese con el area de soporte.</div>",
                        icon: 'info',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false
                    })

                }
            });
        }

        var getFirmaFur = function() {
            const image1 = document.getElementById("image1")
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/getFirmaFur',
                type: 'post',
                data: {
                    idhojapruebas: $('#idhojapruebas').val()
                },
                success: function(rta) {
                    if (rta == "NA") {
                        Swal.fire({
                            title: '<div style="font-size:15px;">Fur sin firma</div>',
                            html: "<div style='font-size:15px;'>Este fur no tiene asociada ninguna firma digital.</div>",
                            icon: 'info',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Aceptar',
                            backdrop: 'static',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                crearModalFirma();
                            }
                        });
                    } else {
                        $("#mesajeFirma").text("Firma ya registrada")
                        image1.src = rta;
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: '<div style="font-size:15px;">No se pudo guardar la firma</div>',
                        html: "<div style='font-size:15px;'>Comuniquese con el area de soporte.</div>",
                        icon: 'info',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false
                    })

                }
            });
        }
        var cambiarJefe = function(e) {
            var idht = $('#idhojapruebas').val().split('-');
            var data = {
                jefepista: e.value,
                idhojapruebas: idht[0]
            };
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/setJefePista',
                type: 'post',
                data: data,
                success: function(rta) {}
            });
        };

        var enviarFirmar = function() {
            var reinspeccion = $('#reinspeccion').val();
            var data = {
                idhojapruebas: $('#idhojapruebas').val(),
                placa: placa,
                ocasion: ocasion,
                reinspeccion: reinspeccion
            };
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/CGVrechaEnvioFirmar',
                type: 'post',
                data: data,
                async: false,
                success: function() {
                    window.location.replace("<?php echo base_url(); ?>index.php/oficina/CGestion");
                }
            });
        };

        var validEventosFinalizados = function() {
            if (sicov !== "CI2") {
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/validEventosFinalizados',
                    type: 'post',
                    mimeType: 'json',
                    async: false,
                    data: {
                        placa: placa,
                    },
                    success: function(data, textStatus, jqXHR) {
                        if (data.length > 0) {
                            var placas = "";
                            $.each(data, function(i, data) {
                                placas += data.idelemento + "<br>";
                            });
                            $("#btnNoenvio").click();
                            Swal.fire({
                                title: '<div style="font-size:15px;">No se ha finalizado el envio de eventos.</div>',
                                html: "<div style='font-size:15px;'>Los siguientes eventos no han sido enviados a sicov, por lo cual no se puede enviar el fur. Espere que el sistema envíe todos los eventos y luego envíe el fur.<br><br><label style='font-size:15px; color: red'>" +
                                    placas + "</label></div>",
                                icon: 'info',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Aceptar',
                                allowOutsideClick: false
                            })
                        } else {
                            enviarASICOV();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    }
                });
            } else {
                enviarASICOV();
            }

        }

        var enviarASICOV = function() {
            var segundos = 2;
            var proceso = setInterval(function() {
                document.getElementById('btnAsignar').disabled = 'true';
                document.getElementById('mensajeSicov').style.color = 'black';
                $('#mensajeSicov').text('Por favor espere. Este proceso puede tomar hasta un minuto');
                if (segundos === 0) {
                    clearInterval(proceso);
                    var data = {
                        envioSicov: 'true',
                        dato: $('#idhojapruebas').val(),
                        envio: '1',
                        IdUsuario: '1',
                        sicovModoAlternativo: localStorage.getItem("sicovModoAlternativo"),
                        ipSicovAlternativo: localStorage.getItem("ipSicovAlternativo")
                    };
                    $.ajax({
                        url: '<?php echo base_url(); ?>index.php/oficina/fur/CFUR',
                        type: 'post',
                        data: data,
                        async: false,
                        success: function(rta) {
                             document.getElementById('btnAsignar').disabled = 'false';
                            var dat = rta.split('|');
                            if (dat[1] === '0000' || dat[1] === '1') {
                                var segundos = 3;
                                var proceso = setInterval(function() {
                                    $('#mensajeSicov').text("Mensaje de SICOV: " + dat[0] +
                                        ". Detalles en el visor.");
                                    document.getElementById('mensajeSicov').style.color =
                                        'green';
                                    if (segundos === 0) {
                                        clearInterval(proceso);
                                        // window.location.replace(
                                        //     "<?php echo base_url(); ?>index.php/oficina/CGestion"
                                        // );
                                    }
                                    segundos--;
                                }, 1000);
                            } else {
                                $('#mensajeSicov').text("Mensaje de SICOV: " + dat[0] +
                                    ". Detalles en el visor.");
                                document.getElementById('mensajeSicov').style.color = 'salmon';
                                 document.getElementById('btnAsignar').disabled = 'false';
                                var segundos = 3;
                                var proceso = setInterval(function() {
                                    if (segundos === 0) {
                                        clearInterval(proceso);
                                        // window.location.replace(
                                        //     "<?php echo base_url(); ?>index.php/oficina/CGestion"
                                        // );
                                    }
                                    segundos--;
                                }, 1000);
                            }
                        }
                    });
                }
                segundos--;
            }, 500);
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
                            var asignado = "<td style= 'color: gray '><strong>" + data.estado +
                                "</strong></td>";
                        } else if (data.estado == 'Aprobado') {
                            var asignado = "";
                            var asignado = "<td style= 'color: green'><strong>" + data.estado +
                                "</strong></td>";
                        } else {
                            var asignado = "";
                            var asignado = "<td style= 'color: red'><strong>" + data.estado +
                                "</strong></td>";
                        }
                        var body = "<tr>";
                        body += "<td>" + data.idprueba + "</td>";
                        body += "<td>" + data.fechainicial + "</td>";
                        body += asignado;
                        body += "<td>" + data.fechafinal + "</td>";
                        body += "<td>" + data.pruebas + "</td>";
                        body +=
                            '<td style="text-aling: center;"><type="submit" class="btn btn-primary"  style="background-color: #393185;border-radius: 40px 40px 40px 40px"  onClick="reasignarpru(\'' +
                            data.idtipo_prueba + '\',\'' + data.idprueba + '\',\'' + idhojapruebas +
                            '\',\'' + data.pruebas + '\',\'' + data.prueba + '\')">Reasignar</td>';
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
                    $.each(data, function(i, data) {
                        if (data.idtipo_prueba == 14) {
                            document.getElementById("cap-new").style.display = 'none';
                        }
                        if (data.idtipo_prueba == 21 || data.idtipo_prueba == 22) {
                            var input =
                                '<td><input checked type="checkbox" style="transform: scale(2.0)" data2="' +
                                data.idtipo_prueba + '" data="' + data.idprueba +
                                '"class="skin-square-blue idpruebas"  >'
                        } else {
                            var input =
                                '<td><input type="checkbox" style="transform: scale(2.0)" data2="' +
                                data.idtipo_prueba + '" data="' + data.idprueba +
                                '"class="skin-square-blue idpruebas"  >'
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
                                            scrollTop: $("#val-razon")
                                                .offset().top
                                        }, 900);
                                        $('#val-razon').html(
                                            '<div style="color: #1D8348; font-size: 17px; text-align: center;">La prueba visual fue asignada.</div>'
                                        );
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
                                $('#val-razon').html(
                                    '<div style="color: #1D8348; font-size: 17px; text-align: center;">La prueba visual fue asignada.</div>'
                                );
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
                    $('#val-razon').html(
                        '<div style="color: #1D8348; font-size: 17px; text-align: center">La prueba ' +
                        pruebas + ' fue asignada.</div>');
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
                    $('#div-rest-estado').html(
                        '<div style="color: #1D8348;font-size: 17px; text-align: center">' + data +
                        '</div>');
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
                    $('#div-reconf-prueba').html(
                        '<div style="color: #1D8348;font-size: 17px; text-align: center">' + data +
                        '</div>');
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
                        $('#div-cancel-prueba').html(
                            '<div style="color: #1D8348; font-size: 17px; text-align: center">' +
                            data + '</div>');
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
                                $('#div-cancel-prueba').html(
                                    '<div style="color: #1D8348; font-size: 17px; text-align: center">' +
                                    data + '</div>');
                            },
                            error: function(jqXHR, textStatus, errorThrown) {

                            }
                        });
                    }
                })
            }
        });
    </script>

    <script>
        // Variables específicas para el modal de confirmación
        let socketConfirm = null;
        let isVerificationInProgress = false;
        let storedTemplateConfirm = '';

        // Elementos del DOM para el modal de confirmación
        const statusElementConfirm = document.getElementById('statusConfirm');
        const logElementConfirm = document.getElementById('logConfirm');
        const verificationResultElementConfirm = document.getElementById('verificationResultConfirm');
        const storedTemplateElementConfirm = document.getElementById('storedTemplateDataConfirm');

        // Botones del modal de confirmación
        const btnConnectConfirm = document.getElementById('btnConnectConfirm');
        const btnDisconnectConfirm = document.getElementById('btnDisconnectConfirm');
        const btnInitConfirm = document.getElementById('btnInitConfirm');
        const btnVerifyConfirm = document.getElementById('btnVerifyConfirm');

        // Función para cargar el template desde localStorage
        function loadStoredTemplateConfirm() {
            try {
                const biometrico = localStorage.getItem('biometrico');
                if (biometrico && biometrico.length > 0) {
                    storedTemplateConfirm = biometrico;
                    storedTemplateElementConfirm.value = biometrico;

                    logMessageConfirm('✅ Template cargado desde localStorage', 'success');
                    updateVerifyButtonState();
                    return true;
                } else {
                    logMessageConfirm('❌ No se encontró template en localStorage', 'error');
                    updateVerifyButtonState();
                    return false;
                }
            } catch (error) {
                logMessageConfirm(`❌ Error al cargar template: ${error}`, 'error');
                updateVerifyButtonState();
                return false;
            }
        }

        // Función para actualizar el estado del botón de verificación
        function updateVerifyButtonState() {
            const hasTemplate = storedTemplateConfirm && storedTemplateConfirm.length > 0;
            const isConnected = socketConfirm && socketConfirm.readyState === WebSocket.OPEN;

            btnVerifyConfirm.disabled = !hasTemplate || !isConnected || isVerificationInProgress;

            if (!hasTemplate) {
                btnVerifyConfirm.title = 'No hay template disponible';
            } else if (!isConnected) {
                btnVerifyConfirm.title = 'No conectado al servidor';
            } else {
                btnVerifyConfirm.title = 'Verificar huella';
            }
        }

        // Función para registrar mensajes en el log de confirmación
        function logMessageConfirm(message, type = 'info') {
            const timestamp = new Date().toLocaleTimeString();
            const className = type === 'error' ? 'error' :
                type === 'success' ? 'success' :
                type === 'event' ? 'event' :
                type === 'warning' ? 'warning' : '';
            logElementConfirm.innerHTML += `<div class="${className}">[${timestamp}] ${message}</div>`;
            logElementConfirm.scrollTop = logElementConfirm.scrollHeight;
        }

        // Función para actualizar el estado de conexión
        function updateStatusConfirm(connected, message = '') {
            if (connected) {
                statusElementConfirm.textContent = message || '✅ Conectado al servidor';
                statusElementConfirm.className = 'status connected';
                btnConnectConfirm.disabled = true;
                btnDisconnectConfirm.disabled = false;
                btnInitConfirm.disabled = false;

                // Cargar template después de conectar
                setTimeout(() => {
                    loadStoredTemplateConfirm();
                }, 100);
            } else {
                statusElementConfirm.textContent = message || '❌ Desconectado';
                statusElementConfirm.className = 'status disconnected';
                btnConnectConfirm.disabled = false;
                btnDisconnectConfirm.disabled = true;
                btnInitConfirm.disabled = true;
                isVerificationInProgress = false;
                updateVerifyButtonState();
            }
        }

        // Función para mostrar resultado de verificación
        function showVerificationResultConfirm(message, isSuccess) {
            verificationResultElementConfirm.style.display = 'block';
            verificationResultElementConfirm.textContent = message;

            if (isSuccess === true) {
                verificationResultElementConfirm.style.backgroundColor = '#d4edda';
                verificationResultElementConfirm.style.color = '#155724';
                verificationResultElementConfirm.style.border = '2px solid #c3e6cb';
            } else if (isSuccess === false) {
                verificationResultElementConfirm.style.backgroundColor = '#f8d7da';
                verificationResultElementConfirm.style.color = '#721c24';
                verificationResultElementConfirm.style.border = '2px solid #f5c6cb';
            } else {
                verificationResultElementConfirm.style.backgroundColor = '#fff3cd';
                verificationResultElementConfirm.style.color = '#856404';
                verificationResultElementConfirm.style.border = '2px solid #ffeaa7';
            }
        }

        // Función para conectar al servidor de confirmación
        function connectConfirm() {
            if (socketConfirm && socketConfirm.readyState === WebSocket.OPEN) {
                logMessageConfirm('Ya está conectado', 'info');
                return;
            }

            statusElementConfirm.textContent = '🔄 Conectando...';
            statusElementConfirm.className = 'status connecting';
            btnConnectConfirm.disabled = true;

            logMessageConfirm('Intentando conectar con el servidor...', 'info');

            try {
                socketConfirm = new WebSocket('ws://localhost:8081/');

                socketConfirm.onopen = function(event) {
                    updateStatusConfirm(true, '✅ Conectado - Servidor listo');
                    logMessageConfirm('Conexión WebSocket establecida correctamente', 'success');
                };

                socketConfirm.onmessage = function(event) {
                    const message = event.data;
                    logMessageConfirm(`📨 Servidor: ${message}`, 'event');
                    processVerificationMessageConfirm(message);
                };

                socketConfirm.onclose = function(event) {
                    logMessageConfirm(`Conexión cerrada: ${event.code} - ${event.reason || 'Sin razón'}`, 'info');
                    updateStatusConfirm(false);
                };

                socketConfirm.onerror = function(error) {
                    logMessageConfirm(`❌ Error de WebSocket: No se pudo conectar al servidor`, 'error');
                    updateStatusConfirm(false, '❌ Error de conexión');
                };

            } catch (error) {
                logMessageConfirm(`❌ Error al crear WebSocket: ${error}`, 'error');
                updateStatusConfirm(false);
            }
        }

        // Función para procesar mensajes del servidor durante verificación
        function processVerificationMessageConfirm(message) {
            if (message.startsWith('VERIFICATION_READY:')) {
                const status = message.split(':')[1];
                logMessageConfirm(`✅ ${status}`, 'success');
                logMessageConfirm('👆 Coloque su dedo en el lector para verificar', 'info');
                isVerificationInProgress = true;
                updateVerifyButtonState();
                showVerificationResultConfirm('Listo para verificar - Escanee su huella', null);
            } else if (message.startsWith('VERIFICATION_SUCCESS:')) {
                const result = message.split(':')[1];
                logMessageConfirm(`🎉 ${result}`, 'success');
                showVerificationResultConfirm('✅ HUELLA VERIFICADA CORRECTAMENTE', true);
                isVerificationInProgress = false;
                updateVerifyButtonState();

                // Cerrar automáticamente después de 2 segundos si es exitoso
                setTimeout(() => {
                    $('#modalConfirmBiometrica').modal('hide');
                    $("#confirmacionEnvio").modal('show');
                }, 2000);
            } else if (message.startsWith('VERIFICATION_FAILED:')) {
                const result = message.split(':')[1];
                logMessageConfirm(`❌ ${result}`, 'error');
                showVerificationResultConfirm('❌ HUELLA NO COINCIDE - Verificación fallida', false);
                isVerificationInProgress = false;
                updateVerifyButtonState();
            } else if (message.startsWith('VERIFICATION_ERROR:')) {
                const error = message.split(':')[1];
                logMessageConfirm(`❌ Error de verificación: ${error}`, 'error');
                showVerificationResultConfirm(`❌ Error: ${error}`, false);
                isVerificationInProgress = false;
                updateVerifyButtonState();
            } else if (message.startsWith('FINGERPRINT_CAPTURED:')) {
                // Mostrar la imagen capturada durante verificación
                const parts = message.split(':');
                if (parts.length >= 3) {
                    const imageBase64 = parts[2];
                    displayFingerprintImageConfirm(imageBase64);
                }
            } else if (message.startsWith('ERROR:')) {
                const errorMsg = message.split(':')[1];
                logMessageConfirm(`❌ Error del servidor: ${errorMsg}`, 'error');
                isVerificationInProgress = false;
                updateVerifyButtonState();
            }
        }

        // Función para verificar la huella
        function verifyFingerprint() {
            if (!storedTemplateConfirm) {
                logMessageConfirm('❌ Error: No hay template almacenado para verificar', 'error');
                showVerificationResultConfirm('No hay template almacenado para verificar', false);
                return;
            }

            if (isVerificationInProgress) {
                logMessageConfirm('⚠️ Ya hay una verificación en progreso', 'warning');
                return;
            }

            if (socketConfirm && socketConfirm.readyState === WebSocket.OPEN) {
                // Enviar el template para verificación
                const message = `verify:${storedTemplateConfirm}`;
                socketConfirm.send(message);
                logMessageConfirm('🔍 Enviando template para verificación...', 'info');
                logMessageConfirm('💡 Escanee la huella a verificar', 'info');
                isVerificationInProgress = true;
                updateVerifyButtonState();

                // Limpiar resultados anteriores
                showVerificationResultConfirm('', null);
                limpiarImagenConfirm();
            } else {
                logMessageConfirm('❌ Error: No hay conexión con el servidor', 'error');
                showVerificationResultConfirm('Error de conexión con el servidor', false);
            }
        }

        // Función para mostrar imagen de huella durante verificación
        function displayFingerprintImageConfirm(imageBase64) {
            try {
                if (imageBase64 && imageBase64.length > 100) {
                    const imageSrc = `data:image/png;base64,${imageBase64}`;
                    //const fingerprintImg = document.getElementById('fingerprintImgConfirm');
                    //const imagePlaceholder = document.getElementById('imagePlaceholderConfirm');

                    const img = new Image();
                    img.onload = function() {
                        fingerprintImg.src = imageSrc;
                        fingerprintImg.style.display = 'block';
                        imagePlaceholder.style.display = 'none';

                        document.getElementById('imageInfoConfirm').textContent =
                            `Resolución: ${this.width}x${this.height} px`;
                        document.getElementById('imageSizeConfirm').textContent =
                            `Tamaño: ${Math.round(imageBase64.length * 0.75 / 1024)} KB`;

                        logMessageConfirm(`🖼️ Imagen de huella capturada (${this.width}x${this.height} px)`,
                            'success');
                    };
                    img.src = imageSrc;
                }
            } catch (error) {
                logMessageConfirm(`❌ Error al mostrar imagen: ${error}`, 'error');
            }
        }

        // Función para limpiar imagen en el modal de confirmación
        function limpiarImagenConfirm() {
            //const fingerprintImg = document.getElementById('fingerprintImgConfirm');
            // const imagePlaceholder = document.getElementById('imagePlaceholderConfirm');

            // fingerprintImg.style.display = 'none';
            // imagePlaceholder.style.display = 'flex';
            // document.getElementById('imageInfoConfirm').textContent = 'Resolución: 0x0 px';
            // document.getElementById('imageSizeConfirm').textContent = 'Tamaño: 0 KB';
        }

        // Función para desconectar del servidor de confirmación
        function disconnectConfirm() {
            if (socketConfirm) {
                socketConfirm.close(1000, 'Desconexión manual del usuario');
                socketConfirm = null;
            }
            updateStatusConfirm(false);
            logMessageConfirm('Desconexión manual', 'info');
        }

        // Función para reinicializar el capturador en modo confirmación
        function initializeCapturerConfirm() {
            if (socketConfirm && socketConfirm.readyState === WebSocket.OPEN) {
                socketConfirm.send('init');
                logMessageConfirm('🔄 Enviando comando INIT...', 'info');
            } else {
                logMessageConfirm('❌ Error: No hay conexión con el servidor', 'error');
            }
        }

        // CONEXIÓN AUTOMÁTICA AL ABRIR EL MODAL
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalConfirmBiometrica');
            if (modal) {
                modal.addEventListener('show.bs.modal', function() {
                    console.log('Modal abierto - Conectando automáticamente...');
                    // Conectar inmediatamente al abrir el modal
                    setTimeout(() => {
                        connectConfirm();
                    }, 100);
                });

                modal.addEventListener('hidden.bs.modal', function() {
                    console.log('Modal cerrado - Desconectando...');
                    if (socketConfirm) {
                        disconnectConfirm();
                    }
                    limpiarImagenConfirm();
                    showVerificationResultConfirm('', null);
                    logElementConfirm.innerHTML = '';
                });
            }
        });

        // También forzar conexión cuando el modal se muestra (por si acaso)
        $(document).on('shown.bs.modal', '#modalConfirmBiometrica', function() {
            console.log('Modal mostrado - Verificando conexión...');
            if (!socketConfirm || socketConfirm.readyState !== WebSocket.OPEN) {
                setTimeout(() => {
                    connectConfirm();
                }, 200);
            }
        });
    </script>

</body>

</html>