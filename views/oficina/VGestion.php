<?php $this->load->view('./header'); ?>

<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>

        <div class="clearfix"></div>
        <!-- MAIN CONTENT AREA STARTS -->
        <h4>VISOR DE PLACAS</h4>
        <div style="width: 100%;text-align: center">
            <table style="width: 100%">
                <tr>
                    <td style="width: 10%;text-align: right">
                        <strong>Filtrar por: </strong>
                    </td>
                    <td style="width: 15%;padding-left: 10px;text-align: left">
                        <select class="form-control" id="tipo_inspeccion" onclick="setEscenario(this)">
                            <!--<option value="0">Todos</option>-->
                            <option value="1">RTMec</option>
                            <option value="2">Preventiva</option>
                            <option value="3">Prueba libre</option>
                        </select>
                    </td>

                    <td style="text-align: right">
                        <?php if ($sicov == 'INDRA') { ?>
                            Activar direccionamiento alternativo SICOV
                        <?php } ?>
                    </td>
                    <td style="width: 30%;text-align: left;padding-left: 10px">
                        <?php if ($sicov == 'INDRA') { ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="input" id="ipDireccionamientoSICOV" onchange="changeIpSicovAlternativo()" class="form-control" placeholder="192.168.10.219:8056">
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" id="direccionamientoSICOV" onchange="activarSicovAlternativo(this)">
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <input type="input" id="direccionamientoSICOV" class="form-control" placeholder="Direccionamiento SICOV">
                        <button class="btn btn-primary" onclick="activarSicovAlternativo(this)">Activar</button> -->
                        <?php } ?>
                    </td>

                </tr>
            </table>
        </div>
        <table style="width: 100%">
            <tr>
                <td>
                    <div class="col-xl-12">

                        <header class="panel_header">
                            <h4 class="title float-center">vehículos en pista</h4>
                            <!--<h4 class="title float-center">vehículos en pista</h4> - <strong id="cEnPista"></strong>-->
                        </header>
                        <div class="content-body">
                            <form action="<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/CGVenPista" method="post">
                                <div class="col-12" style="
                                     overflow: scroll;height: 300px">
                                    <table class="table table-bordered" style="background: #FDFFDF">
                                        <thead>
                                            <tr>
                                                <th>Placa</th>
                                                <th>Ver</th>
                                                <th>Vez</th>
                                            </tr>
                                        </thead>
                                        <tbody id="vEnPista">
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="col-xl-12">
                        <header class="panel_header">
                            <h2 class="title float-center" id="TitRech">Rechazado para firmar</h2>
                            <!--                            <h2 class="title float-center" id="TitRech">Rechazado para firmar</h2> - <strong id="cRechSinFirmar"></strong>-->
                        </header>
                        <div class="content-body">
                            <form action="<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/CGVrechaSinFirmar" method="post">
                                <div class="col-12" style="
                                     overflow: scroll;height: 300px">
                                    <table class="table table-bordered" style="background: #FFE5DF">
                                        <thead>
                                            <tr>
                                                <th>Placa</th>
                                                <th>Ver</th>
                                                <th>Vez</th>
                                            </tr>
                                        </thead>
                                        <tbody id="vRechSinFirmar">
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="col-xl-12">
                        <header class="panel_header">
                            <h2 class="title float-center" id="TitApro">Aprobado para firmar</h2>
                            <!--<h2 class="title float-center" id="TitApro">Aprobado para firmar</h2> - <strong id="cAproSinFirmar"></strong>-->
                        </header>
                        <div class="content-body">
                            <form action="<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/CGVaproSinFirmar" method="post">
                                <div class="col-12" style="
                                     overflow: scroll;height: 300px">
                                    <table class="table table-bordered" style="background: #DFFFE1">
                                        <thead>
                                            <tr>
                                                <th>Placa</th>
                                                <th>Ver</th>
                                                <th>Vez</th>
                                            </tr>
                                        </thead>
                                        <tbody id="vAproSinFirmar">
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            <tr id="colsSicov">
                <td>
                    <div class="col-xl-12">
                        <header class="panel_header">
                            <h2 class="title float-center">Rechazado para consecutivo</h2>
                            <!--<h2 class="title float-center">Rechazado para consecutivo</h2> - <strong id="cRechSinConsecutivo"></strong>-->
                        </header>
                        <div class="content-body">
                            <form action="<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/CGVrechaSinConsecutivo" method="post">
                                <div class="col-12" style="
                                     overflow: scroll;height: 300px">
                                    <table class="table table-bordered" style="background: #FFC9C9">
                                        <thead>
                                            <tr>
                                                <th>Placa</th>
                                                <th>Ver</th>
                                                <th>Vez</th>
                                            </tr>
                                        </thead>
                                        <tbody id="vRechSinConsecutivo">
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="col-xl-12">
                        <header class="panel_header">
                            <h2 class="title float-center">Aprobado para consecutivo</h2> - <strong id="cAproSinConsecutivo"></strong>
                        </header>
                        <div class="content-body">
                            <form action="<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/CGVaproSinConsecutivo" method="post">
                                <div class="col-12" style="
                                     overflow: scroll;height: 300px">
                                    <table class="table table-bordered" style="background: #CAFFC9">
                                        <thead>
                                            <tr>
                                                <th>Placa</th>
                                                <th>Ver</th>
                                                <th>Vez</th>
                                            </tr>
                                        </thead>
                                        <tbody id="vAproSinConsecutivo">
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="col-xl-12">
                        <header class="panel_header">
                            <h2 class="title float-center">Vehiculo finalizado</h2><br>
                            <!--                            Aprobados - <strong id="cAproFin"></strong><br>
                            Rechazados - <strong id="cRechaFin"></strong>-->
                        </header>
                        <div class="content-body">
                            <form action="<?php echo base_url(); ?>index.php/oficina/gestion/CGPrueba/CGVfinalizado" method="post">
                                <div class="col-12" style="overflow: scroll;height: 300px">
                                    <table class="table table-bordered" style="background: #C9E1FF">
                                        <thead>
                                            <tr>
                                                <th>Placa</th>
                                                <th>Ver</th>
                                                <th>Vez</th>
                                                <th id="envioemail" style="display: none">Envio fur email</th>
                                            </tr>
                                        </thead>
                                        <tbody id="vFinalizado">

                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        </table><br>
        <div id="eventosSICOV">
            <h4>EVENTOS DEL SICOV</h4>
            <table style="width: 100%">
                <tr>
                    <td style="width: 50%">
                        <div class="col-xl-12">
                            <header class="panel_header">
                                <h4 class="title">EVENTOS DE PIN</h4>
                            </header>
                            <div class="content-body">
                                <div style="overflow: scroll;height: 400px;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Ver</th>
                                                <th>Placa</th>
                                                <th>Ocasión</th>
                                                <th>Fecha</th>
                                                <th>Evento</th>
                                            </tr>
                                        </thead>
                                        <tbody id="eventosPIN">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="width: 50%">
                        <div class="col-xl-12">
                            <header class="panel_header">
                                <h2 class="title float-center">Eventos de FUR</h2>
                            </header>
                            <div class="content-body">
                                <div class="col-12" style="
                                     overflow: scroll;height: 400px">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Ver</th>
                                                <th>Placa</th>
                                                <th>Ocasión</th>
                                                <th>Fecha</th>
                                                <th>Evento</th>
                                            </tr>
                                        </thead>
                                        <tbody id="eventosFUR">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-xl-12">
                            <header class="panel_header">
                                <h4 class="title">EVENTOS DE RUNT</h4>
                            </header>
                            <div class="content-body">
                                <div class="col-12" style="
                                     overflow: scroll;height: 400px">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Ver</th>
                                                <th>Placa</th>
                                                <th>Ocasión</th>
                                                <th>Fecha</th>
                                                <th>Evento</th>
                                            </tr>
                                        </thead>
                                        <tbody id="eventosRUNT">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="col-xl-12">
                            <header class="panel_header">
                                <h2 class="title float-center">EVENTOS DE PRUEBAS</h2>
                            </header>
                            <div class="content-body">
                                <div class="col-12" style="
                                     overflow: scroll;height: 400px">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Ver</th>
                                                <th>Placa</th>
                                                <th>Fecha</th>
                                                <th>Evento</th>
                                            </tr>
                                        </thead>
                                        <tbody id="eventosPruebas">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <!-- MAIN CONTENT AREA ENDS -->
    </section>
</section>

<div class="modal" id="detalleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog animated bounceInDown">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalle del evento</h4>
            </div>
            <div class="modal-body" style="background: whitesmoke">
                <label id="detalleSICOV"
                    style="background: white;
                       width: 100%;
                       text-align: center;
                       font-weight: bold;
                       font-size: 15px;
                       padding: 5px;border: solid gray 2px;
                       border-radius:  15px 15px 15px 15px;color: black"></label>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-success" type="button">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="envioEmail" s tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog animated bounceInDown">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="titulo_">ENVIO DE FORMATO</h4>
            </div>
            <div class="modal-body" style="background: whitesmoke">
                <label id="mensaje"
                    style="background: white;
                       width: 100%;
                       text-align: center;
                       font-weight: bold;
                       font-size: 15px;
                       padding: 5px;border: solid gray 2px;
                       border-radius:  15px 15px 15px 15px;color: gray">Bienvenido</label>
                <br>
                <table class="table">
                    <tr id="pre_email">
                        <td><input type="checkbox" style="transform: scale(2.0)" class="skin-square-blue" id="email_prerevision" /></td>
                        <td>Adjuntar formato de prerevision</td>
                    </tr>
                    <tr>
                        <td style="text-align: right">Email</td>
                        <td colspan="3" style="text-align: left;padding-left: 10px">
                            <input id="datEmail" type="email" class="form-control" />
                        </td>
                    </tr>

                </table>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" id="cancelar" class="btn btn-default" type="button">Cancelar</button>
                <button class="btn btn-success" id="btnEnviar" type="submit" onclick="enviarEmailData()">Enviar</button>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('./footer');
?>

<script type="text/javascript">
    var activoSicov = '<?php
                        if (isset($activoSicov)) {
                            echo $activoSicov;
                        } else {
                            echo '0';
                        }
                        ?>';
    var idCdaRUNT = '<?php
                        if (isset($idCdaRUNT)) {
                            echo $idCdaRUNT;
                        } else {
                            echo '0';
                        }
                        ?>';
    var ipSicovAlternativo = '<?php
                                if (isset($ipSicovAlternativo)) {
                                    echo $ipSicovAlternativo;
                                } else {
                                    echo '0';
                                }
                                ?>';
    var sicovModoAlternativo = '<?php
                                if (isset($sicovModoAlternativo)) {
                                    echo $sicovModoAlternativo;
                                } else {
                                    echo '0';
                                }
                                ?>';
    var ipSicov = '<?php
                    if (isset($ipSicov)) {
                        echo $ipSicov;
                    } else {
                        echo '0';
                    }
                    ?>';
    var usuarioSicov = '<?php
                        if (isset($usuarioSicov)) {
                            echo $usuarioSicov;
                        } else {
                            echo '0';
                        }
                        ?>';
    var claveSicov = '<?php
                        if (isset($claveSicov)) {
                            echo $claveSicov;
                        } else {
                            echo '0';
                        }
                        ?>';
    var sicov = '<?php
                    if (isset($sicov)) {
                        echo $sicov;
                    } else {
                        echo '0';
                    }
                    ?>';
    var salaEspera2 = '<?php
                        if (isset($salaEspera2)) {
                            echo $salaEspera2;
                        } else {
                            echo '0';
                        }
                        ?>';
    var moduloPrerevision = '<?php
                                if (isset($moduloPrerevision)) {
                                    echo $moduloPrerevision;
                                } else {
                                    echo '0';
                                }
                                ?>';
    var envioCorreo = '<?php
                        if (isset($envioCorreo)) {
                            echo $envioCorreo;
                        } else {
                            echo '0';
                        }
                        ?>';
    var CARinformeActivo = '<?php
                            if (isset($CARinformeActivo)) {
                                echo $CARinformeActivo;
                            } else {
                                echo '0';
                            }
                            ?>';
    var ipCAR = '<?php
                    if (isset($ipCAR)) {
                        echo $ipCAR;
                    } else {
                        echo '0';
                    }
                    ?>';
    var dominio = "";

    var reload = function() {
        setInterval(function() {
            cargarDatos();
            //cargarSICOV();
            //enviarEventosINDRA();
            enviarAuditoria();
           // migracionPrerevision();
            //            console.log(localStorage.getItem("dominio"));
            //ranTh(0,0);
            //            if (localStorage.getItem("dominio") === "cdasolviales.tecmmas.com")
            //                ranTh(1, 51);
            //            if (salaEspera2 === "1")
            //                enviarPlacaSalaE();
        }, 10000);
    };
    //console.log(dominio)

    var setPlaca = function(contenedor, iterador) {
        //        cEnPista = 0
        //        cRechSinFirmar = 0;
        //        cAproSinFirmar = 0;
        //        vRechSinConsecutivo = 0;
        //        vAproSinConsecutivo = 0;
        var contenido = '';
        var email = '';
        //        if (sicov === 'INDRA' && activoSicov === '1')
        //            enviarEventosINDRA();
        document.getElementById(contenedor).innerHTML = "";
        if (iterador !== '')
            switch ($('#tipo_inspeccion').val().toString()) {
                case '1':
                    localStorage.setItem("tipoIns", "1");
                    if (contenedor === 'vFinalizado') {
                        cRechaFin = 0;
                        cAproFin = 0;
                        //                        document.getElementById('cAproFin').innerHTML = cAproFin;
                        //                        document.getElementById('cRechaFin').innerHTML = cRechaFin;
                    } else if (contenedor === 'vEnPista') {
                        cEnPista = 0;
                        //                        document.getElementById('cEnPista').innerHTML = cEnPista;
                    } else if (contenedor === 'vRechSinFirmar') {
                        cRechSinFirmar = 0;
                        //                        document.getElementById('cRechSinFirmar').innerHTML = cRechSinFirmar;
                    } else if (contenedor === 'vAproSinFirmar') {
                        cAproSinFirmar = 0;
                        //                        document.getElementById('cAproSinFirmar').innerHTML = cAproSinFirmar;
                    } else if (contenedor === 'vRechSinConsecutivo') {
                        cRechSinConsecutivo = 0;
                        //                        document.getElementById('cRechSinConsecutivo').innerHTML = cRechSinConsecutivo;
                    } else if (contenedor === 'vAproSinConsecutivo') {
                        cAproSinConsecutivo = 0;
                        //                        document.getElementById('cAproSinConsecutivo').innerHTML = cAproSinConsecutivo;
                    }
                    iterador.forEach(function(dat) {
                        if (dat.reinspeccion === '1' || dat.reinspeccion === '0') {
                            document.getElementById('envioemail').style.display = '';
                            var color = '';
                            var res = '';
                            if (contenedor === 'vFinalizado') {
                                //                                email = '<td><button name="dato" value ="' + dat.idhojapruebas + '-' + dat.reinspeccion + res + '" type="submit" style="border-radius: 40px 40px 40px 40px;font-size: 14px">Enviar</button></td>';

                                if (dat.estadototal === '4') {
                                    res = '-4';
                                    color = 'style="background:#ccffcc"';
                                    cAproFin++;
                                } else {
                                    res = '-7';
                                    color = 'style="background:#ffcccc"';
                                    cRechaFin++;
                                }
                                email = '<td><input type="submit" id="enviar_email" title="' + dat.idhojapruebas + '|' + dat.email + '|' + dat.idprerevision + '|' + dat.reinspeccion + '|' + res + '"  onclick="enviarEmail(event,this.title)"  data-toggle="modal" data-target="#envioEmail"  style="border-radius: 40px 40px 40px 40px;font-size: 14px" value="Enviar" /></td>';
                            } else if (contenedor === 'vEnPista') {
                                cEnPista++;
                            } else if (contenedor === 'vRechSinFirmar') {
                                cRechSinFirmar++;
                            } else if (contenedor === 'vAproSinFirmar') {
                                cAproSinFirmar++;
                            } else if (contenedor === 'vRechSinConsecutivo') {
                                cRechSinConsecutivo++;
                            } else if (contenedor === 'vAproSinConsecutivo') {
                                cAproSinConsecutivo++;
                            }
                            contenido += '<tr ' + color + ' ><td>' + dat.placa + '</td><td><button name="dato" value ="' + dat.idhojapruebas + '-' + dat.reinspeccion + res + '" type="submit" style="border-radius: 40px 40px 40px 40px;font-size: 14px">Ver</button></td><td>' + dat.ocacion + '</td> ' + email + '</tr>';
                        }
                    });
                    //                    console.log(contenedor);
                    if (contenedor === 'vFinalizado') {
                        //                        document.getElementById('cAproFin').innerHTML = cAproFin;
                        //                        document.getElementById('cRechaFin').innerHTML = cRechaFin;
                    } else if (contenedor === 'vEnPista') {
                        //                        document.getElementById('cEnPista').innerHTML = cEnPista;
                    } else if (contenedor === 'vRechSinFirmar') {
                        //                        document.getElementById('cRechSinFirmar').innerHTML = cRechSinFirmar;
                    } else if (contenedor === 'vAproSinFirmar') {
                        //                        document.getElementById('cAproSinFirmar').innerHTML = cAproSinFirmar;
                    } else if (contenedor === 'vRechSinConsecutivo') {
                        //                        document.getElementById('cRechSinConsecutivo').innerHTML = cRechSinConsecutivo;
                    } else if (contenedor === 'vAproSinConsecutivo') {
                        //                        document.getElementById('cAproSinConsecutivo').innerHTML = cAproSinConsecutivo;
                    }
                    break;
                case '2':
                    localStorage.setItem("tipoIns", "2");
                    iterador.forEach(function(dat) {
                        if (dat.reinspeccion === '44441' || dat.reinspeccion === '4444') {
                            if (dat.reinspeccion === '4444')
                                dat.ocacion = '1ra';
                            else
                                dat.ocacion = '2da';
                            contenido += '<tr><td>' + dat.placa + '</td><td><button name="dato" value ="' + dat.idhojapruebas + '-' + dat.reinspeccion + '" type="submit" style="border-radius: 40px 40px 40px 40px;font-size: 14px">Ver</button></td><td>' + dat.ocacion + '</td></tr>';
                        }
                    });
                    break;
                case '3':
                    localStorage.setItem("tipoIns", "3");
                    iterador.forEach(function(dat) {
                        dat.ocacion = '1ra';
                        if (dat.reinspeccion === '8888')
                            contenido += '<tr><td>' + dat.placa + '</td><td><button name="dato" value ="' + dat.idhojapruebas + '-' + dat.reinspeccion + '" type="submit" style="border-radius: 40px 40px 40px 40px;font-size: 14px">Ver</button></td><td>' + dat.ocacion + '</td></tr>';
                    });
                    break;
            }
        document.getElementById(contenedor).innerHTML = contenido;
    };

    var cargarDatos = function() {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/CGestion/cargarVehiculos',
            type: 'post',
            success: function(rta) {
                // console.log(rta);
                var pruebas = JSON.parse(rta);
                setPlaca('vEnPista', pruebas.vEnPista);
                setPlaca('vRechSinFirmar', pruebas.vRechSinFirmar);
                setPlaca('vAproSinFirmar', pruebas.vAproSinFirmar);
                setPlaca('vRechSinConsecutivo', pruebas.vRechSinConsecutivo);
                setPlaca('vAproSinConsecutivo', pruebas.vAproSinConsecutivo);
                setPlaca('vFinalizado', pruebas.vFinalizado);
            }
        });
    };

    var cargarEventosSicov = function(contenedor, iterador, tipo) {
        var contenido = '';
        document.getElementById(contenedor).innerHTML = '';
        if (iterador.length !== 0)
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
                                <td><button name="dato" value ="' + dat.respuesta + '" onclick="verDetalleEvento(this)" type="submit" style="border-radius: 40px 40px 40px 40px;font-size: 14px" data-toggle="modal" data-target="#detalleModal">Ver</button></td>\n\
                                <td>' + dat.idelemento + '</td>\n\
                                <td>' + ocasion + '</td>\n\
                                <td>' + dat.fecha + '</td>\n\
                                <td>' + msj[0] + '</td>\n\
                              </tr>';
                }
            });
        document.getElementById(contenedor).innerHTML = contenido;
    };

    var cargarSICOV = function() {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/CGestion/cargarSICOV',
            type: 'post',
            success: function(rta) {
                var eventos = JSON.parse(rta);
                cargarEventosSicov('eventosPIN', eventos.sicovEventos, 'p');
                cargarEventosSicov('eventosFUR', eventos.sicovEventos, 'f');
                cargarEventosSicov('eventosRUNT', eventos.sicovEventos, 'r');
                cargarEventosPruebas(eventos.sicovEventos);
            }
        });
    };

    var enviarEventosINDRA = function() {
        var data = {
            sicovModoAlternativo: sicovModoAlternativo,
            ipSicovAlternativo: ipSicovAlternativo,
            ipSicov: ipSicov,
            idCdaRUNT: idCdaRUNT
        };
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/CGestion/enviarEventosIndra',
            type: 'post',
            data: data
        });
    };
    window.onload = function() {
        //        if (localStorage.getItem("dominio") == undefined || localStorage.getItem("dominio") == "") {
        //            getDominio();
        //        } else {
        //            
        //            dominio = localStorage.getItem("dominio");
        //        }
        cargarDatos();
       // cargarSICOV();
        if (localStorage.getItem("tipoIns") !== null && localStorage.getItem("tipoIns") !== undefined) {
            var element = document.getElementById("tipo_inspeccion");
            element.value = localStorage.getItem("tipoIns");
            setEscenario(element);
        }


        if (sicov === 'INDRA' && activoSicov === '1') {
            //            enviarEventosINDRA();
            document.getElementById("direccionamientoSICOV").innerHTML = "";
            sicovModoAlternativo = localStorage.getItem("sicovModoAlternativo");
            if (localStorage.getItem("ipSicovAlternativo") !== null && localStorage.getItem("ipSicovAlternativo") !== undefined) {
                document.getElementById("ipDireccionamientoSICOV").value = localStorage.getItem("ipSicovAlternativo");
                ipSicovAlternativo = localStorage.getItem("ipSicovAlternativo");
            }
            if (localStorage.getItem("sicovModoAlternativo") === '1') {
                document.getElementById("direccionamientoSICOV").innerHTML = "<option value='1'>SI</option><option value='0'>NO</option>";
            } else {
                document.getElementById("direccionamientoSICOV").innerHTML = "<option value='0'>NO</option><option value='1'>SI</option>";
            }
        }
        if (moduloPrerevision === "0") {
            document.getElementById('pre_email').style.display = "none";
        }
        reload();
    };



    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
        customClass: {
            container: 'swal2-container-above-modal'
        },
        target: 'body'
    });

    // Add CSS to ensure toast appears above modals
    const style = document.createElement('style');
    style.textContent = `
        .swal2-container-above-modal {
            z-index: 2000 !important;
        }
    `;
    document.head.appendChild(style);

    var changeIpSicovAlternativo = function() {
        // console.log(document.getElementById('ipDireccionamientoSICOV').value);
        document.getElementById('direccionamientoSICOV').value = '0';
    }


    var activarSicovAlternativo = function(e) {
        if (document.getElementById('ipDireccionamientoSICOV').value === '') {

            Toast.fire({
                icon: "warning",
                title: "Atención",
                text: 'Debe ingresar la ip el direccionamiento alternativo',
            });
            document.getElementById('direccionamientoSICOV').value = '0';
            return;
        }
        if (e.value === '1') {
            Toast.fire({
                icon: "warning",
                title: "Atención",
                text: 'El direccionamiento alternativo estará activo durante la sesión actual, si cierra sesión y si aún desea mantener el direccionamiento alternativo, deberá activar esta opción nuevamente.',
                timer: 10000,
            });


            sicovModoAlternativo = e.value;
            ipSicovAlternativo = document.getElementById('ipDireccionamientoSICOV').value;
            console.log(document.getElementById('ipDireccionamientoSICOV').value);

            localStorage.setItem("sicovModoAlternativo", sicovModoAlternativo);
            localStorage.setItem("ipSicovAlternativo", document.getElementById('ipDireccionamientoSICOV').value);
        }
    };

    
    var cargarEventosPruebas = function(iterador) {
        var contenido = '';
        document.getElementById('eventosPruebas').innerHTML = '';
        if (iterador.length !== 0)
            iterador.forEach(function(dat) {
                if (dat.tipo === 'e') {
                    var color = "#ccffcc";
                    var msj = dat.respuesta.split('|');
                    if (dat.enviado === '0') {
                        color = "#ffffcc";
                    } else if (dat.enviado === '1') {
                        color = "#ccffcc";
                    } else {
                        color = "#ffcccc";
                    }
                    contenido += '<tr style="background: ' + color + '">\n\
                                <td><button name="dato" value ="' + dat.respuesta + '" onclick="verDetalleEvento(this)" type="submit" style="border-radius: 40px 40px 40px 40px;font-size: 14px" data-toggle="modal" data-target="#detalleModal">Ver</button></td>\n\
                                <td>' + dat.idelemento + '</td>\n\
                                <td>' + dat.fecha + '</td>\n\
                                <td>' + msj[0] + '</td>\n\
                              </tr>';
                }
            });
        document.getElementById('eventosPruebas').innerHTML = contenido;
    };

    var migracionPrerevision = function() {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/CGestion/migracionPrerevision'
        });
    }



    var ranTh = function(param, idm) {
        if (param === 0) {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/CGestion/ranTh'
            });
        } else {

            $.ajax({
                url: '<?php echo base_url(); ?>index.php/oficina/CGestion/ranTh1',
                type: 'post',
                data: {
                    idm: idm
                }
            });
        }

    };

    var enviarAuditoria = function() {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/CGestion/consultarAuditoria',
            success: function(rta) {
                var rta_ = JSON.parse(rta);
                if (rta_.toString() !== "") {
                    rta_.forEach(function(a) {
                        var data = {
                            placa: a.placa,
                            idprueba: a.idprueba,
                            idresultado: a.idresultado,
                            intento: a.intento
                        };
                        $.ajax({
                            url: "http://" + localStorage.getItem("dominio") + "/cda/index.php/Cservicio/insertAuditoria",
                            type: 'post',
                            data: data,
                            success: function(r) {}
                        });
                    });
                }
            }
        });
    };

    var enviarPlacaSalaE = function() {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/CGestion/consultarPlacaSalaE',
            success: function(rta) {
                var rta_ = JSON.parse(rta);
                if (rta_.toString() !== "") {
                    rta_.forEach(function(a) {
                        console.log(CARinformeActivo);
                        if (CARinformeActivo === "1" && (a.idtipo_prueba === "3" || a.idtipo_prueba === "2") && a.estado !== "0" && a.estado !== "3") {
                            getResultadosGases(a);
                        }
                        var data = {
                            idhojaprueba: a.idhojaprueba,
                            idtipo_prueba: a.idtipo_prueba,
                            estado: a.estado
                        };
                        $.ajax({
                            url: "http://" + localStorage.getItem("dominio") + "/cda/index.php/Csala/actualizarPrueba",
                            type: 'post',
                            data: data,
                            success: function(r) {
                                console.log(r);
                            }
                        });
                    });
                }
            }
        });
    };


    //    var getDominio = function () {
    //        $.ajax({
    //            url: '<?php echo base_url(); ?>index.php/Cconfiguracion/getDominio',
    //            type: 'post',
    //            
    //            success: function (dominio_) {
    //                if (dominio_ !== '') {
    //                    localStorage.setItem("dominio", dominio_);
    //                    dominio = dominio_;
    //                }
    //            }
    //        });
    //    };

    var cEnPista = 0;
    var cRechSinFirmar = 0;
    var cAproSinFirmar = 0;
    var cRechSinConsecutivo = 0;
    var cAproSinConsecutivo = 0;
    var cRechaFin = 0;
    var cAproFin = 0;

    

    var verDetalleEvento = function(e) {
        $('#detalleSICOV').text(e.value);
    };

    var setEscenario = function(e) {
        cargarDatos();
        //cargarSICOV();
        //        if (sicov === 'INDRA' && activoSicov === '1')
        //            enviarEventosINDRA();
        var colsSicov = document.getElementById("colsSicov");
        var eventosSICOV = document.getElementById("eventosSICOV");
        if (e.value === '1') {
            $('#TitRech').text('RECHAZADO SIN FIRMAR');
            $('#TitApro').text('APROBADO SIN FIRMAR');
            // colsSicov.style.visibility = 'visible';
            // eventosSICOV.style.visibility = 'visible';
            colsSicov.style.visibility = 'visible';
            eventosSICOV.style.visibility = 'hidden';
        } else {
            $('#TitRech').text('RECHAZADOS');
            $('#TitApro').text('APROBADOS');
            colsSicov.style.visibility = 'hidden';
            eventosSICOV.style.visibility = 'hidden';
        }
    };
    var idhojaprueba = 0;
    var idprerevision = 0;
    var datos = "";
    var enviarEmail = function(ev, data) {
        $('#mensaje').html('Bienvenido');
        ev.preventDefault();
        var dat = data.split('|');
        document.getElementById('btnEnviar').disabled = false;
        $('#datEmail').val(dat[1]);
        idhojaprueba = dat[0];
        idprerevision = dat[2];
        datos = dat[0] + "-" + dat[3] + "-" + dat[4].replace("-", "") + "-" + '1';
    }

    function enviarEmailData() {
        var emaild = $('#datEmail').val();
        if (envioCorreo === "1") {
            document.getElementById('btnEnviar').disabled = true;
            $('#mensaje').html('Enviado Información, por favor espere.');
            //        console.log(emaild, idpred);
            if ((idhojaprueba === null || idhojaprueba === "") || (emaild === null || emaild === "")) {
                $('#cancelar').click();
                Swal.fire({
                    icon: 'error',
                    text: 'Campo email vacio.'
                });
            } else {
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/oficina/fur/CFUR',
                    type: 'post',
                    data: {
                        dato: datos,
                        email: emaild
                    },
                    success: function(data, textStatus, jqXHR) {
                        var v = 0;
                        if (document.getElementById('email_prerevision').checked) {
                            v = enviarPrerevision(emaild);
                        }
                        $('#cancelar').click();
                        if (v == 1 || data == 1) {
                            Swal.fire({
                                icon: 'success',
                                text: 'Email enviado con exito.',
                            })
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#cancelar').click();
                        Swal.fire({
                            icon: 'error',
                            html: 'No se pudo enviar el email.<br>'.jqXHR,
                        })
                    }
                })
            }
        } else {
            $('#cancelar').click();
            Swal.fire({
                icon: 'error',
                html: 'Apreciado usuario, usted no tiene habilitado este módulo de envío. por favor comuníquese con TECMMAS SAS<br>',
            });
        }

    }

    function enviarPrerevision(emaild) {
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/informes/CPrerevision/generar',
            type: 'post',
            mimeType: 'json',
            data: {
                savePdf: 1,
                idpre_prerevision: idprerevision,
                email: emaild
            },
            success: function(data, textStatus, jqXHR) {
                return 1;

            },
            error: function(jqXHR, textStatus, errorThrown) {
                return 0;
            }
        });
    }

    function getResultadosGases(p) {
        iniciarSample();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/oficina/CGestion/getResultadoGases',
            type: 'post',
            mimeType: 'json',
            data: {
                idprueba: p.idprueba
            },
            success: function(datos) {
                dataSample.placa = datos[0].numero_placa;
                dataSample.tipo = datos[0].norma;
                if (datos[0].norma === "4231") {
                    dataSample.ltoe = datos[0].LTOE;
                    dataSample.fallatemp = datos[0].Falla_por_temperatura_motor_disel;
                }
                datos.forEach(function(d) {
                    switch (d.idconfig_prueba) {
                        case "85":
                            dataSample.rpmralenti = d.valor;
                            break;
                        case "87":
                            dataSample.hcralenti = d.valor;
                            break;
                        case "88":
                            dataSample.coralenti = d.valor;
                            break;
                        case "89":
                            dataSample.co2ralenti = d.valor;
                            break;
                        case "90":
                            dataSample.o2ralenti = d.valor;
                            break;
                        case "91":
                            dataSample.rpmcrucero = d.valor;
                            break;
                        case "92":
                            dataSample.hccrucero = d.valor;
                            break;
                        case "93":
                            dataSample.cocrucero = d.valor;
                            break;
                        case "94":
                            dataSample.co2crucero = d.valor;
                            break;
                        case "95":
                            dataSample.o2crucero = d.valor;
                            break;
                        case "41":
                            dataSample.rpmcpre = d.valor;
                            break;
                        case "63":
                            dataSample.rpmcpri = d.valor;
                            break;
                        case "64":
                            dataSample.rpmcseg = d.valor;
                            break;
                        case "65":
                            dataSample.rpmcter = d.valor;
                            break;
                        case "34":
                            dataSample.opacidadcpre = d.valor;
                            break;
                        case "35":
                            dataSample.opacidadcpri = d.valor;
                            break;
                        case "36":
                            dataSample.opacidadcseg = d.valor;
                            break;
                        case "37":
                            dataSample.opacidadcter = d.valor;
                            break;
                        case "39":
                            dataSample.tempfinal = d.valor;
                            break;
                        default:

                            break;
                    }
                });
                //                envioResulGases(dataSample, p.idprueba)
                //                console.log(dataSample);
            },
            error: function(jqXHR) {
                console.log(jqXHR);
            }
        });
    }

    function envioResulGases(dataSample, idprueba) {
        var data = new Object();
        data.sample = dataSample;
        //        console.log(JSON.stringify(data.sample));
        $.ajax({
            type: "POST",
            url: "http://" + ipCAR + "/cdapp/rest/medicion/captura",
            headers: {
                "Authorization": "b56c19aa217e36a6c182be3ce6fab1851c32a6860f74a312f2cf6d230f6c1573",
                "Content-Type": "application/json"
            },

            data: JSON.stringify(data),
            success: function(rta) {
                console.log(rta)
                if (rta.resp == "OK") {
                    var estado = 1;
                    var tipo = 'Envio sample exitoso.';
                    guardarTabla(estado, tipo, idprueba);
                } else {
                    var estado = 0;
                    var tipo = 'Envio sample fallido.';
                    guardarTabla(estado, tipo, idprueba);
                }
            },
            errors: function(rta) {
                console.log(rta);
            }
        });
    }

    function guardarTabla(estado, tipo, idprueba) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/oficina/fur/CFUR/saveControl",
            data: {
                estado: estado,
                tipo: tipo,
                idprueba: idprueba
            },
            success: function(rta) {
                console.log(rta);
            },
            errors: function(rta) {
                console.log(rta);
            }
        });
    }
    var dataSample = new Object();
    var iniciarSample = function() {
        dataSample.placa = "";
        dataSample.tipo = "";
        dataSample.rpmralenti = "";
        dataSample.hcralenti = "";
        dataSample.coralenti = "";
        dataSample.co2ralenti = "";
        dataSample.o2ralenti = "";
        dataSample.rpmcrucero = "";
        dataSample.hccrucero = "";
        dataSample.cocrucero = "";
        dataSample.co2crucero = "";
        dataSample.o2crucero = "";
        dataSample.opacidadcpre = "";
        dataSample.rpmcpre = "";
        dataSample.opacidadcpri = "";
        dataSample.rpmcpri = "";
        dataSample.opacidadcseg = "";
        dataSample.rpmcseg = "";
        dataSample.opacidadcter = "";
        dataSample.rpmcter = "";
        dataSample.ltoe = "";
        dataSample.tempfinal = "";
        dataSample.fallatemp = "";
        //    sampleData(dataSample);
    };
</script>
<!-- END CONTENT -->